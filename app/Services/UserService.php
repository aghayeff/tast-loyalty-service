<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function __construct(
        private User $model,
    ) {}


    public function register(array $data): \Illuminate\Http\JsonResponse
    {
        $user = $this->model::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $this->responseWithToken($user);
    }


    public function login($credentials)
    {
        if (!Auth::attempt($credentials)) {
            return response()->json([
                "message" => __('auth.failed'),
            ], 401);
        }

        return $this->responseWithToken(auth()->user());
    }


    public function logout(){
        $loggedOut = auth()->user()->currentAccessToken()->delete();

        if($loggedOut){
            return response()->json([
                'message' => 'Logged out successfully',
            ]);
        }else{
            throw ValidationException::withMessages(['token' => 'Something went wrong check UserService.logout()']);
        }
    }


    private function responseWithToken($user): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('apiToken')->plainTextToken,
        ], 201);
    }
}
