<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $service;

    public function __construct(AuthService $service){
        $this->service = $service;
    }

    public function register(RegisterRequest $request){
        return $this->service->register($request->validated());
    }

    public function login(LoginRequest $request){
        return $this->service->login($request->validated());
    }
    public function logout(Request $request){
        return $this->service->logout($request);
    }
}
