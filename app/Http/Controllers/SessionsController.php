<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email'=>'required|email|max:225',
            'password'=>'required',
        ]);

        if(Auth::attempt($credentials,$request->has('remember'))){
            session()->flash('danger', '欢迎回来！');
            return redirect()->route('users.show',[Auth::user()]);
        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }

        return;
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已经成功退出！');
        return redirect('login');
    }
}
