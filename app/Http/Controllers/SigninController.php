<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SigninController extends Controller
{
    public function index()
    {
        return view("admin.signin");
    }

    public function authentication(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            if(Auth::user()->status == 'active'){
                if (Auth::viaRemember()) {
                    return redirect('admin')->with('success-login', 'Wellcome Back!');
                } else {
                    return redirect('admin')->with('success-login', 'Wellcome Back!');
                }
            }else{
                Auth::logout();
                return redirect()->route('account.disabled');
            }
        } else {
            return redirect('sign-in')->with('error', 'Email atau password salah.')->onlyInput('email');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/sign-in');
    }
}
