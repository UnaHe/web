<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 15:51
 */
namespace App\Services;

use App\Models\Banner;
use App\Models\GoodsCategory;

class TransferService
{
    public function transferLink($taobaoGoodsId, $pid, $token){
        include app_path("Librarys/Taobao/TopSdk.php");

        $appKey = '23225630';
        $secretKey = '93fee8926d98bfb23c05628f701c4b0d';

        $pids = explode('_',$pid);
        $c = new \TopClient($appKey, $secretKey);
        $c->format="json";
        $req = new \TbkPrivilegeGetRequest;
        $req->setItemId($taobaoGoodsId);
        $req->setAdzoneId($pids[3]); //B pid 第三位
        $req->setPlatform("1");
        $req->setSiteId($pids[2]);//A pid 第二位
        $resp = $c->execute($req, $token);

        //转换失败
        if (!$resp){
            throw new \Exception("转链失败");
        }

        //判断结果
        if(isset($resp['code'])){
            if (27 == $resp['code']){
                //session过期
                throw new \Exception("授权过期");
            }else if (15 == $resp['code']){
                //pid错误
                throw new \Exception("PID错误");
            }
            throw new \Exception("转链失败");
        }

        return $resp['result']['data'];
    }
}
