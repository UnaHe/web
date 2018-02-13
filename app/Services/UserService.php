<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 15:51
 */
namespace App\Services;

use App\Models\UserReferralCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\InviteCode;
use App\Models\User;
use App\Models\CodePrice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use GuzzleHttp\Client;

class UserService
{
    /**
     * 注册用户
     * @param $userName
     * @param $password
     * @param $inviteCode
     * @throws \Exception
     */
    public function registerUser($inviteCode, $userName, $password, $codeId, $captcha){
        // 请求注册服务器.
        $response = (new Client())->post(config('app.usercenter_host')."/api/register", [
            'form_params' => [
                'username' => $userName,
                'password' => $password,
                'codeId' => $codeId,
                'captcha' => $captcha,
            ]
        ])->getBody()->getContents();

        if(!$response){
            Log::error("注册服务器错误");
            throw new \Exception("注册服务器错误");
        }
        $result = json_decode($response, true);
        if($result['code'] == 300){
            throw new \Exception("注册失败");
        }

        $User = new User();
        $regUser = $User->where('phone', $userName)->first();
        if($regUser === NULL){
            throw new \Exception("注册失败");
        }

        // 邀请码信息.
        $InviteCode = new InviteCode();
        $query = $InviteCode->from($InviteCode->getTable()." as invite")->where([
            ["invite.invite_code", $inviteCode],
            ["invite.status", InviteCode::STATUS_UNUSE],
        ]);
        $query->leftjoin($User->getTable()." as user", "user.id", '=', "invite.user_id");
        $query->select(["user.id", "user.grade", "user.path", "invite.effective_days", 'invite.code_type']);
        $inviteCodeInfo = $query->first();

        if(!$inviteCodeInfo){
            throw new \LogicException("邀请码无效");
        }

        // 计算用户path.
        $masterId = $inviteCodeInfo['id'];
        $masterGrade = $inviteCodeInfo['grade'] ? $inviteCodeInfo['grade'] : 1;
        $masterPath = $inviteCodeInfo['path'];
        if ($masterGrade === 3) {
            $path = $masterId.':';
        } else {
            $path = $masterPath.$masterId.':';
        }

        //有效期
        $effectiveDay = $inviteCodeInfo['effective_days'];
        $expireTime = null;
        if($effectiveDay>0){
            $expireTime = (new Carbon())->addDay($effectiveDay)->endOfDay();
        }

        // Redis 队列.
        $types = $inviteCodeInfo['effective_days'];
        $unit_price = CodePrice::where('duration', $types)->pluck('code_price')->first();
        $codeUserId = $inviteCodeInfo['id'];
        $codeType = $inviteCodeInfo['code_type'];
        $redisParams = [
            'type' => 1,
            'code' => $inviteCode,
            'uprice' => $unit_price,
            'userId' => $codeUserId,
            'effdays' => $types,
            'codetype' => $codeType,
        ];
        $redisParamsJson = json_encode($redisParams, JSON_FORCE_OBJECT);

        DB::beginTransaction();
        try{
            //使用邀请码
            if(!(new InviteCode())->useCode($inviteCode)){
                throw new \LogicException("邀请码无效");
            }

            //创建用户
            $isSuccess = $regUser->update([
                'invite_code' => $inviteCode,
                'expiry_time' => $expireTime,
                'path' => $path,
            ]);

            if(!$isSuccess){
                throw new \LogicException("注册失败");
            }
            DB::commit();

            if ($effectiveDay == -1) {
                // 终身码注册,存入注册列表.
                Redis::lPush('manager:queue:complate_order_info', $redisParamsJson);
                Redis::hSet('manager:hash:reginvitereluser:'.$codeUserId, $inviteCode, 1);
            }
        }catch (\Exception $e){
            DB::rollBack();
            $error = "注册失败";
            if($e instanceof \LogicException){
                $error = $e->getMessage();
            }else{
                if(User::where('phone', $userName)->exists()){
                    $error = '该用户已注册';
                }
            }
            throw new \Exception($error);
        }
    }

    public function generate_code($length = 9) {
        return rand(pow(10,($length-1)), pow(10,$length)-1);
    }

    /**
     * @param $codes
     * @return string
     */
    public function reg($codes) {
        $InviteCode = new InviteCode();
        $User = new User();
        $query = $InviteCode->from($InviteCode->getTable()." as invite")->where([
            ["invite.invite_code", $codes[0]],
            ["invite.status", InviteCode::STATUS_UNUSE],
        ]);
        $query->leftjoin($User->getTable()." as user", "user.id", '=', "invite.user_id");
        $query->select(["user.id", "user.grade", "user.path", "invite.effective_days", 'invite.code_type']);
        $inviteCodeInfo = $query->first();

        if(!$inviteCodeInfo){
            throw new \LogicException("邀请码无效");
        }
        // 计算用户path.
        $masterId = $inviteCodeInfo['id'];
        $masterGrade = $inviteCodeInfo['grade'] ? $inviteCodeInfo['grade'] : 1;
        $masterPath = $inviteCodeInfo['path'];
        if ($masterGrade === 3) {
            $path = $masterId.':';
        } else {
            $path = $masterPath.$masterId.':';
        }

        $effectiveDay = $inviteCodeInfo['effective_days'];
        // Redis 队列.
        $types = $inviteCodeInfo['effective_days'];
        $unit_price = CodePrice::where('duration', $types)->pluck('code_price')->first();
        $codeUserId = $inviteCodeInfo['id'];
        $codeType = $inviteCodeInfo['code_type'];

        $sql = '';
        $pwd = '$2y$10$UIrysYMy3Tq2k3Cxc/v4i.vdC3aIpwRuq5CsogyingRX2G89AdsA.';
        foreach($codes as $k=>$v){
            $name = '12'.$this->generate_code();
            $sql .= "('$name','$pwd','$v','$path'),";
        }
        $sql = rtrim($sql,",");
        $res = DB::insert(DB::raw('INSERT INTO xmt_user (phone,password,invite_code,path) VALUES '.$sql));

        if($res){
            $ress  = $InviteCode->whereIn("invite_code", $codes)->where("status", InviteCode::STATUS_UNUSE)->update(["status"=>InviteCode::STATUS_USED]);
            $arr = [];
            foreach($codes as $k=>$v){
                $redisParams = [
                    'type' => 1,
                    'code' => $v,
                    'uprice' => $unit_price,
                    'userId' => $codeUserId,
                    'effdays' => $effectiveDay,
                    'codetype' => $codeType,
                ];
                $redisParamsJson = json_encode($redisParams, JSON_FORCE_OBJECT);
                Redis::lPush('manager:queue:complate_order_info', $redisParamsJson);
                $arr[$v] = 1;
            }
            Redis::hMset('manager:hash:reginvitereluser:'.$codeUserId, $arr);
        }

        return $res.'|'.$ress;
    }

    /**
     * 修改密码
     * @param $userName
     * @param $password
     * @throws \Exception
     */
    public function modifyPassword($userName, $password){
        try{
            $user = User::where("phone", $userName)->first();
            if(!$user){
                throw new \LogicException("用户不存在");
            }
            $user['password'] = bcrypt($password);

            $user->save();
        }catch (\Exception $e){
            if($e instanceof \LogicException){
                $error = $e->getMessage();
            }else{
                $error = '修改密码失败';
            }
            throw new \Exception($error);
        }
    }

    /**
     * 获取推荐码
     * @param User $user
     * @return null
     */
    public function getReferralCode($user){
        $code = (new UserReferralCode())->getByUserId($user->id);
        $referralCode = null;
        if(!$code){
            $inviteCode = $user['invite_code'];
            if($inviteCode && (new UserReferralCode())->updateCode($inviteCode, $user->id)){
                $referralCode = $inviteCode;
            }
        }else{
            $referralCode = $code['referral_code'];
        }

        return $referralCode;
    }

    /**
     * 通过推荐码获取用户信息
     * @param $code
     * @return User
     */
    public function getUserByReferralCode($code){
        $code = (new UserReferralCode())->getByCode($code);
        if(!$code){
            return false;
        }
        return User::find($code['user_id']);
    }

}
