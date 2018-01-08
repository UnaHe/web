<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Services\CaptchaService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    public function index(Request $request)
    {
        echo "<pre>";
        var_dump(Auth::user());
        exit;
    }

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            if (Auth::attempt(['phone' => $request->get('username'), 'password' => $request->get('password')])) {
                return $this->ajaxSuccess();
            } else {
                return $this->ajaxError(['msg' => '登录失败']);
            }
        } elseif ($request->isMethod('get')) {
            return view('web.user.login', [
                'active' => 'login'
            ]);
        }
    }

    /**
     * 用户注册
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $codeId = $request->post('codeId');
            $username = $request->post('username');
            $password = $request->post('password');
            $captcha = $request->post('captcha');

            $validator = Validator::make($request->all(), [
                'username' => 'required|size:11',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
                'captcha' => 'required',
            ], [
                'required' => ':attribute 不能为空.',
                'unique' => ':attribute 已存在.',
                'min' => ':attribute 长度不够.',
                'confirmed' => ':attribute 不一致',
                'size' => ':attribute 格式不合法',
            ], [
                'username' => '用户名',
                'password' => '密码',
                'password_confirmation' => '确认密码',
                'captcha' => '验证码'
            ]);

            if (empty($codeId) || empty($captcha) || !(new CaptchaService())->checkSmsCode($codeId, $captcha)) {
                return $this->ajaxError(['msg' => '验证码错误']);
            }

            if ($validator->fails()) {
                $errors = \GuzzleHttp\json_decode($validator->errors(), true);
                $msg = '';
                foreach ($errors as $v) {
                    $msg .= $v[0] . '<br/>';
                }
                return $this->ajaxError(['msg' => $msg]);
            }
            try {
                (new UserService())->webRegisterUser($username, $password, $inviteCode = '');
            } catch (\Exception $e) {
                return $this->ajaxError(['msg' => $e->getMessage()]);
            }
            return $this->ajaxSuccess(['message'=>'注册成功']);
        } elseif ($request->isMethod('get')) {
            return view('web.user.register', [
                'active' => 'register'
            ]);
        }
    }

    /**
     * 注册获取短信
     * @param Request $request
     * @return static
     */
    public function getCode(Request $request)
    {
        $mobile = $request->post('username');
        if (!preg_match('/^1\d{10}$/', $mobile)) {
            return $this->ajaxError(['msg' => '请输入正确的手机号码']);
        }
        $codeId = (new CaptchaService())->registerSms($mobile);
        if (!$codeId) {
            return $this->ajaxError(['msg' => '验证码发送失败']);
        }
        return $this->ajaxSuccess([$codeId]);
    }

    /**
     * 忘记密码
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|static
     */
    public function forgetPwd(Request $request)
    {
        if ($request->isMethod('post')) {
            $codeId = $request->post('codeId');
            $captcha = $request->post('captcha');
            $username = $request->post('username');
            $user = User::where("phone", $username)->first();
            if (!$user) {
                return $this->ajaxError(['msg' => '用户不存在']);
            }
            if (empty($codeId) || empty($captcha) || !(new CaptchaService())->checkSmsCode($codeId, $captcha)) {
                return $this->ajaxError(['msg' => '验证码错误']);
            }
            Auth::login($user);
            return $this->ajaxSuccess();
        } else {
            return view('web.user.forgetPwd');
        }

    }

    /**
     * 修改密码
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updatePwd(Request $request)
    {
        if ($request->isMethod('post')) {

        } else {
            if (Auth::check()) {
                return view('web.user.updatePwd');
            } else {
                return view('web.user.forgetPwd');
            }

        }
    }


}
