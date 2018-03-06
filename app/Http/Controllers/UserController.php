<?php

namespace App\Http\Controllers;

use App\Services\CaptchaService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 用户注册
     * @param Request $request
     * @return UserController
     */
    public function register(Request $request){
        $inviteCode = $request->post('invite_code');
        $userName = $request->post('username');
        $password = $request->post('password');
        $codeId = $request->post('codeId');
        $captcha = $request->post('captcha');

        if(!$inviteCode || !$userName || !$password || !$codeId){
            return $this->ajaxError("参数错误");
        }
        if(!preg_match('/^\w{1,6}$/', $inviteCode)){
            return $this->ajaxError('邀请码格式错误');
        }
        if(!preg_match('/^1\d{10}$/', $userName)){
            return $this->ajaxError('请输入正确的手机号码');
        }
        if(strlen($password) < 6){
            return $this->ajaxError('密码长度至少为6位');
        }
        if(!(new CaptchaService())->checkSmsCode($userName, $codeId, $captcha)){
            return $this->ajaxError("验证码错误");
        }

        try{
            (new UserService())->registerUser($inviteCode, $userName, $password, $codeId, $captcha);
        }catch (\Exception $e){
            return $this->ajaxError($e->getMessage());
        }
        return $this->ajaxSuccess();
    }

    /**
     * @param Request $request
     * @return UserController
     */
    function reg(Request $request) {
        $code = $request->post('invite_code');
        $codes = explode(' ', $code);

        try{
            $data = (new UserService())->reg($codes);
        }catch (\Exception $e){
            return $this->ajaxError($e->getMessage());
        }

        return $this->ajaxSuccess($data);
    }

    /**
     * 发送注册验证码
     * @param Request $request
     * @return static
     */
    public function registerSms(Request $request){
        $mobile = $request->post('mobile');
        if(!preg_match('/^1\d{10}$/', $mobile)){
            return $this->ajaxError('请输入正确的手机号码');
        }

        $codeId = (new CaptchaService())->registerSms($mobile);
        if(!$codeId){
            return $this->ajaxError("短信发送失败");
        }

        return $this->ajaxSuccess(['codeId' => $codeId]);
    }

    /**
     * 修改密码验证码
     * @param Request $request
     * @return static
     */
    public function modifyPasswordSms(Request $request){
        $mobile = $request->post('mobile');
        if(!preg_match('/^1\d{10}$/', $mobile)){
            return $this->ajaxError('请输入正确的手机号码');
        }

        $codeId = (new CaptchaService())->modifyPasswordSms($mobile);
        if(!$codeId){
            return $this->ajaxError("短信发送失败");
        }

        return $this->ajaxSuccess(['codeId' => $codeId]);
    }

    /**
     * 修改密码
     * @param Request $request
     * @return static
     */
    public function modifyPassword(Request $request){
        $userName = $request->post('username');
        $password = $request->post('password');
        $codeId = $request->post('codeId');
        $captcha = $request->post('captcha');

        if(!$userName || !$password || !$codeId){
            return $this->ajaxError("参数错误");
        }
        if(!preg_match('/^1\d{10}$/', $userName)){
            return $this->ajaxError('请输入正确的手机号码');
        }
        if(strlen($password) < 6){
            return $this->ajaxError('密码长度至少为6位');
        }

        if(!(new CaptchaService())->checkSmsCode($userName, $codeId, $captcha)){
            return $this->ajaxError("验证码错误");
        }

        try{
            (new UserService())->modifyPassword($userName, $password);
        }catch (\Exception $e){
            return $this->ajaxError($e->getMessage());
        }

        return $this->ajaxSuccess();
    }


}
