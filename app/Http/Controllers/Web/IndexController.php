<?php
namespace App\Http\Controllers\Web;
use Illuminate\Support\Facades\Auth;


/**
 * 首页
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    public function index(){
        $title = '官网';
//        echo "<pre>";
//        var_dump(Auth::user());
//        exit;
        return  view('web.index', compact('title'));
    }
}
