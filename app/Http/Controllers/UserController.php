<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * 用户登录
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function login(){
        return Response("fsd");
    }

    /**
     * 用户注册
     */
    public function register(){
//        $user = new User();
//        $user->name = "";
//        $user->phone = "ssss";
//        $user->pwd = "ssss";
//        $user->save();
        var_dump(User::all());
    }


}
