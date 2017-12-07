<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Caiji;
use Illuminate\Support\Facades\Log;

class CaijiController extends Controller
{
    public function caiji(Request $request)
    {
        $data = $request->all();
        $messageType = $request->post('message_type');
        $postType = $request->post('post_type');
        $groupId = $request->post('group_id');
        $userId = $request->post('user_id');
        $message = html_entity_decode($request->post('message'));

        if (!($postType == 'message' && $messageType == 'group')) {
            return;
        }

        $messages = explode("\n", trim($message));

        if (strpos($message, '复制这条信息') || strpos($message, '淘口令')) {
            Log::info("过滤");
            Log::info($message);
            return;
        }

        //匹配券
        if (!preg_match("/https?:\/\/(((market|shop)\.m)|(taoquan))\.taobao\.com\/[A-Za-z0-9&=_\?\.\/]+/", $message, $matchQuanUrl)) {
            Log::info("无券链接");
            Log::info($message);
            return;
        }
        $quanUrl = $matchQuanUrl[0];

        $goodsUrl = null;
        //匹配商品
        if (preg_match("/https?:\/\/((item\.taobao)|(detail\.tmall))\.com\/[A-Za-z0-9&=_\?\.\/]+/", $message, $matchGoodsUrl)) {
            $goodsUrl = $matchGoodsUrl[0];
        } else if (preg_match("/https?:\/\/s\.click\.taobao\.com\/[A-Za-z0-9&=_\?\.\/]+/", $message, $matchGoodsUrl)) {
            $goodsUrl = $matchGoodsUrl[0];
            $goodsUrl = (new \App\Services\TransferService())->getFinalUrl($goodsUrl);
        }

        if (!$goodsUrl) {
            Log::info("无商品地址");
            Log::info($message);
            return;
        }

        $picField = $messages[0];
        if (!preg_match("/\[CQ:image.*?url=(.*?)\]/", $picField, $matchPic)) {
            Log::info("无主图");
            Log::info($messages);
            return;
        }
        $pic = urldecode($matchPic[1]);

        $messageText = preg_replace("/^.*?http.*\n?/m", "", $message);
        $messageText = preg_replace("/^.*?(原价|抢券|领券|优惠券|佣金|秒过|卷后|券后|劵后|深夜福利|转发|分界线|---|===).*\n?/m", "", $messageText);
        $messageTextArray = explode("\n", $messageText);
        foreach ($messageTextArray as $key => $val) {
            //中文字数不够的行直接过滤
            preg_match_all("/[\x{4e00}-\x{9fa5}]/um", $val, $matchWord);
            if (count($matchWord[0]) < 5) {
                unset($messageTextArray[$key]);
            }
        }
        $messageTextArray = array_values($messageTextArray);

        $title = $messageTextArray[0];
        $description = $messageTextArray[1];

        try {
            parse_str(parse_url($goodsUrl)['query'], $query);
            $goodsId = $query['id'];
        } catch (\Exception $e) {
            Log::info("商品地址解析失败");
            Log::info($goodsUrl);
            return;
        }

        parse_str(parse_url($quanUrl)['query'], $query);
        $couponId = isset($query['activityId']) ? $query['activityId'] : '';
        $couponId = isset($query['activity_id']) ? $query['activity_id'] : $couponId;

        $sellerId = isset($query['sellerId']) ? $query['sellerId'] : '';
        $sellerId = isset($query['seller_id']) ? $query['seller_id'] : $sellerId;

        Caiji::create([
            'title' => $title,
            'description' => $description,
            'goods_id' => $goodsId,
            'coupon_id' => $couponId,
            'seller_id' => $sellerId,
            'add_time' => date('Y-m-d H:i:s'),
            'message' => $message,
            'pic' => $pic
        ]);
    }
}