<?php

namespace App\Domains\Admin\Auth\Controllers;

use App\Domains\Admin\Auth\Requests\LoginRequest;
use App\Domains\Admin\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        return view('Auth::login');
    }

    public function submitLogin(LoginRequest $request){
        $remember_me = !is_null($request->remember_me) ? true : false;

        $credentialsOnly = $request->only('email', 'password');
        if (Auth::attempt($credentialsOnly, $remember_me))
        {
            // Flash messages after login
            session()->flash('success', __('messages.login_success'));

            return response()->json([
                'success' => true,
                'redirect_url' => route('admin.dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('messages.wrong_credentials')
        ], 400);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
