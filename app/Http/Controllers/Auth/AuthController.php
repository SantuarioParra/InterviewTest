<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Services\Auth\AuthService;
use App\Http\Requests\Auth\AuthSingupRequest;



class AuthController extends Controller
{
    private $authService;
    public function __construct(AuthService $myService)
    {
        $this->authService = $myService;
    }

    public function login(AuthLoginRequest $request)
    {
        return $this->authService->logIn($request->validated());
    }

    /**
     * @param AuthSingupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signUp(AuthSingupRequest $request)
    {
        return $this->authService->userRegister($request->validated());
    }

    public function logOut()
    {
        return $this->authService->logOut();
    }

    public function user(){
        return $this->authService->user();
    }
}
