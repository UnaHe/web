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

        return  view('web.index', compact('title'));
    }


    public function business(){
        $title='商务合作';
        $columnCode='today_tui';
        $active = ['active_column_code' => $columnCode];
        return  view('web.business',compact( 'title', 'active'));
    }
}
