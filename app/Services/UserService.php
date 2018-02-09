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
use Illuminate\Support\Facades\Request;
use phpDocumentor\Reflection\Types\Object_;

class UserService
{
    /**
     * 注册用户
     * @param $userName
     * @param $password
     * @param $inviteCode
     * @throws \Exception
     */
    public function registerUser($userName, $password, $inviteCode){
        $User = new User();
        $InviteCode = new InviteCode();
        $query = $InviteCode->from($InviteCode->getTable()." as invite")->where([
            ["invite.invite_code", $inviteCode],
            ["invite.status", InviteCode::STATUS_UNUSE],
        ]);
        $query->leftjoin($User->getTable()." as user", "user.id", '=', "invite.user_id");
        $query->select(["user.id", "user.grade", "user.path", "invite.effective_days"]);
        $inviteCodeInfo = $query->first();

        DB::beginTransaction();
        try{
            //使用邀请码
            if (!(new InviteCode())->useCode($inviteCode)) {
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
            if ($effectiveDay > 0) {
                $expireTime = (new Carbon())->addDay($effectiveDay)->endOfDay();
            }

            //创建用户
            $isSuccess = User::create([
                'phone' => $userName,
                'password' => bcrypt($password),
                'invite_code' => $inviteCode,
                'reg_time' => date('Y-m-d H:i:s'),
                'reg_ip' => Request::ip(),
                'expiry_time' => $expireTime,
                'path' => $path,
            ]);

            if (!$isSuccess) {
                throw new \LogicException("注册失败");
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $error = "注册失败";
            if ($e instanceof \LogicException) {
                $error = $e->getMessage();
            } else {
                if (User::where('phone', $userName)->exists()) {
                    $error = '该用户已注册';
                }
            }
            throw new \Exception($error);
        }
    }

    /**
     * 注册用户
     * @param $userName
     * @param $password
     * @param $inviteCode
     * @throws \Exception
     */
    public function webRegisterUser($userName, $password, $inviteCode)
    {
        DB::beginTransaction();
        try {
            $inviteCodeInfo = (new InviteCode())->checkUsable($inviteCode);

            //有效期
            $effectiveDay = $inviteCodeInfo['effective_days'];
            $expireTime = null;
            if ($effectiveDay > 0) {
                $expireTime = (new Carbon())->addDay($effectiveDay)->endOfDay();
            }

            //创建用户
            $isSuccess = User::create([
                'phone' => $userName,
                'password' => bcrypt($password),
                'invite_code' => $inviteCode,
                'reg_time' => date('Y-m-d H:i:s'),
                'reg_ip' => Request::ip(),
                'expiry_time' => $expireTime,
            ]);

            if (!$isSuccess) {
                throw new \LogicException("注册失败");
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $error = "注册失败";
            if ($e instanceof \LogicException) {
                $error = $e->getMessage();
            } else {
                if (User::where('phone', $userName)->exists()) {
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
    public function modifyPassword($userName, $password)
    {
        try {
            $user = User::where("phone", $userName)->first();
            if (!$user) {
                throw new \LogicException("用户不存在");
            }
            $user['password'] = bcrypt($password);

            $user->save();
        } catch (\Exception $e) {
            if ($e instanceof \LogicException) {
                $error = $e->getMessage();
            } else {
                $error = '修改密码失败';
            }
            throw new \Exception($error);
        }
    }

    /**

     * 通过个人中心修改部分信息
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function modifyUserInfo($data)
    {
        try {
            $user = DB::table('xmt_pygj_user_info')->where('user_id', '=', $data['user_id'])->first();
            if(!empty($data['promotion']) && is_array($data['promotion'])){
                $data['promotion']=implode(',',$data['promotion']);
            }else{
                $data['promotion']='';
            }
            if (empty($user)) {//新增加
                $bool = DB::table("xmt_pygj_user_info")->insert($data);
            } else {//update
                $bool = DB::table("xmt_pygj_user_info")->where('id', $user->id)->update($data);
            }
            return $bool;
        } catch (\Exception $e) {
            return $e;
           return  false;
        }
    }

    /**
     * 获取用户个人中心信息
     * @param $user_id
     * @return mixed
     */
    public function getUserInfo($user_id)
    {
        $user = DB::table('xmt_pygj_user_info')->where('user_id', '=', $user_id)->first();
        return $user;
    }




    /*
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
