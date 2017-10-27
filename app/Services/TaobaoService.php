<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/23
 * Time: 15:51
 */
namespace App\Services;


use App\Helpers\ErrorHelper;
use App\Models\Goods;
use App\Models\TaobaoPid;
use App\Models\TaobaoToken;

class TaobaoService
{
    /**
     * 保存淘宝token
     * @param $userId
     * @param $tokens
     */
    public function saveAuthToken($userId, $tokens){
        $time = time();
        $now  = date('Y-m-d H:i:s', $time);

        $token = TaobaoToken::where("user_id", $userId)->first();
        if(!$token){
            $token = new TaobaoToken();
            $token['create_time'] = $now;
            $token['user_id'] = $userId;
        }
        try{
            $token['access_token'] = $tokens['access_token'];
            $token['token_type'] = $tokens['token_type'];
            $token['expires_at'] = date('Y-m-d H:i:s', $time+$tokens['expires_in']);
            $token['refresh_token'] = $tokens['refresh_token'];
            $token['re_expires_at'] = $tokens['re_expires_in'] ? date('Y-m-d H:i:s', $time+$tokens['re_expires_in']) : null;
            $token['taobao_user_id'] = $tokens['taobao_user_id'];
            $token['taobao_user_nick'] = $tokens['taobao_user_nick'];
            $token['update_time'] = $now;
            $token->save();

        }catch (\Exception $e){
            return false;
        }

        return true;
    }

    /**
     * 保存pid
     * @param $userId
     * @param $pid
     * @return bool
     */
    public function savePid($userId, $pid){
        $time = time();
        $now  = date('Y-m-d H:i:s', $time);

        $token = $this->getToken($userId);
        $this->testPid($token, $pid);

        $model = TaobaoPid::where("user_id", $userId)->first();
        if(!$model){
            $model = new TaobaoPid();
            $model['create_time'] = $now;
            $model['user_id'] = $userId;
        }
        try{
            $model['pid'] = $pid;
            $model['update_time'] = $now;
            $model->save();
        }catch (\Exception $e){
            return false;
        }

        return true;
    }

    /**
     * 获取用户token
     * @param $userId
     * @return mixed
     */
    public function getAuthToken($userId){
        return TaobaoToken::where("user_id", $userId)->first();
    }

    /**
     * 获取token
     * @param $userId
     * @return mixed
     */
    public function getToken($userId){
        $token = $this->getAuthToken($userId);
        if(!$token){
            return null;
        }
        return $token['access_token'];
    }

    /**
     * 获取用户pid
     * @param $userId
     * @return mixed
     */
    public function getPid($userId){
        return TaobaoPid::where("user_id", $userId)->pluck("pid")->first();
    }

    /**
     * 查询用户授权信息
     * @param $userId
     */
    public function authInfo($userId){
        $pid = $this->getPid($userId);
        $token = $this->getAuthToken($userId);

        return [
            'is_auth'=> $token ? true : false,
            'auth_expire_time' => $token['expires_at'],
            'pid' => $pid
        ];
    }

    /**
     * 检测用户pid是否正确
     * @param $token
     * @param $pid
     */
    public function testPid($token, $pid){
        $goodsId = Goods::orderBy("id", 'desc')->pluck("goodsid")->first();
        (new TransferService())->transferLink($goodsId, $pid, $token);
        return true;
    }

}
