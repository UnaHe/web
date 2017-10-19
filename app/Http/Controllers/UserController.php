<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

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
        if(!preg_match('/^1\d{10}$/', $userName)){
            return $this->ajaxError('请输入正确的手机号码');
        }
        if(strlen($password) < 6){
            return $this->ajaxError('密码长度至少为6位');
        }

        try{
            (new UserService())->registerUser($userName, $password, $inviteCode);
        }catch (\Exception $e){
            return $this->ajaxError($e->getMessage());
        }

        return $this->ajaxSuccess();
    }

}
