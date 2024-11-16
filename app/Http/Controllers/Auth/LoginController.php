<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(){
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $request->validate([
           'email' => 'required|email',
           'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            return redirect()->intended('/')
                    ->withSuccess('Signed in successfully!');
        }

        return redirect("login")->withError("Login details are not correct");
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect("/");
    }
}
