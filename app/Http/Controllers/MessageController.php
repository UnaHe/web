<?php

namespace App\Http\Controllers;
use App\Services\MessageService;
use Illuminate\Http\Request;

/**
 * 消息通知
 * Class MessageController
 * @package App\Http\Controllers
 */
class MessageController extends Controller
{
    /**
     * 获取消息列表
     */
    public function getMessageList(Request $request){
        $data = (new MessageService())->getMessages($request->user()->id);
        return $this->ajaxSuccess($data);
    }

    /**
     * 获取消息详情, 并标记消息为已读
     * @param $messageId
     */
    public function getMessage(Request $request, $messageId){
        try{
            $data = (new MessageService())->read($request->user()->id, $messageId);
        }catch (\Exception $e){
            return $this->ajaxError($e->getMessage());
        }
        return $this->ajaxSuccess($data);
    }

    /**
     * 删除消息
     * @param $messageId
     */
    public function deleteMessage(Request $request, $messageId){
        try{
            $data = (new MessageService())->delete($request->user()->id, $messageId);
        }catch (\Exception $e){
            return $this->ajaxError($e->getMessage());
        }
        return $this->ajaxSuccess($data);
    }

}
