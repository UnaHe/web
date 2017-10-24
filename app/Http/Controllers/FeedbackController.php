<?php

namespace App\Http\Controllers;

use App\Services\CaptchaService;
use App\Services\FeedbackService;
use App\Services\UserService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * 意见反馈
     * @param Request $request
     */
    public function feedback(Request $request){
        $content = $request->post('content');
        if(!$content){
            return $this->ajaxError("参数错误");
        }

        if(!(new FeedbackService())->addFeedback($request->user()->id, $content)){
            return $this->ajaxError("提交失败");
        }

        return $this->ajaxSuccess();
    }
}
