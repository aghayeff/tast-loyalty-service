<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
        $this->middleware('auth:sanctum')->only(['logout']);
    }

    public function register(StoreUserRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->userService->register($request->all());
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->userService->login($request->all());
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        return $this->userService->logout();
    }
}
