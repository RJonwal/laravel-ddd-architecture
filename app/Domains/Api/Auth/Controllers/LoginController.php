<?php

namespace App\Domains\Api\Auth\Controllers;

use App\Domains\Admin\User\Resource\UserResource;
use App\Domains\Api\Auth\Requests\LoginRequest;
use App\Http\Controllers\APIController;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends APIController
{
    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        if(!$token){
            return $this->apiError(trans('messages.wrong_credentials'));
        }
        
        $userResource = new UserResource(auth()->user());
        return $this->apiSuccess(['access_token' => $token, 'user' => $userResource], trans('messages.login_success'));
    }
}
