<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (Gate::allows('access-admin', $user)) {
                return redirect()->route('admin.dashboard.index');
            } else {
                return redirect()->route('frontend.home.index');
            }
        } else {
            return redirect()->route('frontend.home.login')->withErrors([
                'login_error' => 'Xảy ra lỗi',
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('frontend.home.index');
    }
}
