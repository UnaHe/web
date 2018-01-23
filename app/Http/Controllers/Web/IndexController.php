<?php
namespace App\Http\Controllers\Web;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;


/**
 * 首页
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    public function index(Request $request){
        $title = '官网';
        $active=['active_column_code'=>'today_tui'];
//        return  view('web.layouts.layouts', compact('title','active'));
        return  view('web.index', compact('title','active'));
    }


    public function business(){
        $title='商务合作';
        $columnCode='today_tui';
        $active = ['active_column_code' => $columnCode];
        return  view('web.business',compact( 'title', 'active'));
    }
}
