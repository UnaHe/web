<?php

namespace App\Http\Controllers;

use App\Models\InviteCode;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * 用户注册
     */
    public function register(Request $request){
        $inviteCode = $request->post('invite_code');
        $userName = $request->post('username');
        $password = $request->post('password');

        if(!$inviteCode || !$userName || !$password){
            return $this->ajaxError("参数错误");
        }

        DB::beginTransaction();
        try{
            //使用验证码
            if(!(new InviteCode())->useCode($inviteCode)){
                throw new \LogicException("验证码无效");
            }

            //创建用户
            $isSuccess = User::create([
                'phone' => $userName,
                'password' => bcrypt($password),
                'invite_code' => $inviteCode,
                'reg_time' => date('Y-m-d H:i:s'),
                'reg_ip' => $request->ip(),
            ]);

            if(!$isSuccess){
                throw new \LogicException("注册失败");
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            if($e instanceof \LogicException){
                return $this->ajaxError($e->getMessage());
            }
            return $this->ajaxError("注册失败");
        }

        return $this->ajaxSuccess();
    }

}
