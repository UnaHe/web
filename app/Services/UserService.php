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
        $hphg = ($inviteCodeInfo['code_type'] === 0) ? 0 : 1;
        $redisParams = [
            'type' => 1,
            'code' => $inviteCode,
            'uprice' => $unit_price,
            'userId' => $codeUserId,
            'effdays' => $effectiveDay,
            'hphg' => $hphg,
        ];
        $redisParamsJson = json_encode($redisParams);

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
            
            // 存入注册列表.
            Redis::lpush('manager:queue:complate_order_info', $redisParamsJson);
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
