<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 14:48
 */
namespace  App\Traits;

use Illuminate\Http\JsonResponse;

trait AjaxResponse
{
    /**
     * 成功返回
     * @param array $data
     * @return static
     */
    protected function ajaxSuccess($data=array()){
        $ret = array(
            'code'=>200,
            'msg'=>'success',
            'data'=>$data
        );
        return JsonResponse::create($ret);
    }

    /**
     * 失败返回
     * @param string $msg
     * @param int $code
     * @param array $data
     * @return static
     */
    protected function ajaxError($msg='error', $code=300, $data= array()){
        $ret = array(
            'code'=>$code,
            'msg'=>$msg,
            'data'=>$data
        );
        return JsonResponse::create($ret);
    }

}