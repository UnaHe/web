<?php
namespace App\Http\Controllers\Web;

use Illuminate\Contracts\View\Factory;
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
    /**
     * 首页
     */
    public function index()
    {
        $title = '首页';
        $active = ['active_column_code' => 'today_tui'];
        return view('web.index', compact('title', 'active'));
    }

    /**
     * 商务合作页面
     */
    public function business()
    {
        $title = '商务合作';
        $columnCode = 'today_tui';
        $active = ['active_column_code' => $columnCode];
        return view('web.business', compact('title', 'active'));
    }

    /**
     * 网站建设中
     * @return Factory|\Illuminate\View\View
     */
    public function construction($name)
    {
        $title = '建设中';
        $columnCode = 'today_tui';
        $active = ['active_column_code' => $columnCode];
        return view('web.construction', compact('title', 'active', 'name'));
    }


}
