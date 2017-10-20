<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 15:51
 */
namespace App\Services;

use App\Helpers\SmsHelper;
use Illuminate\Support\Facades\Cache;

class CaptchaService
{
    /**
     * 发送注册验证码
     * @param $mobile
     */
    public function registerSms($mobile){
        $code = mt_rand(1000, 9999);
        $codeId = md5(__METHOD__.uniqid().time());
        $cacheKey = "smsCode.".$codeId;

        if((new SmsHelper())->sms($mobile, env('SMS_SIGNNAME'), 'SMS_105225367', ['code'=>$code])){
            Cache::put($cacheKey, $code, env('SMS_CODE_EXPIRE_TIME', 5));
            return $codeId;
        }

        return false;
    }

    /**
     * 验证注册验证码
     * @param $codeId
     * @param $code
     * @return bool
     */
    public function checkRegisterSms($codeId, $code){
        $cacheKey = "smsCode.".$codeId;

        if(Cache::get($cacheKey) == $code){
            return true;
        }

        return false;
    }
}
