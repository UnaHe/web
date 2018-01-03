<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;

/**
 * 首页
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    /**
     * 主页
     */
    public function index(Request $request){
        echo 1111;
    }

}
