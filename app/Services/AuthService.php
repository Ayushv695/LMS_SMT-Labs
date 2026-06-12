<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService{

    public function register(array $data){
        try{
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            return response()->json([
                'status' => true,
                'message '=> 'User register successfully',
                'data' => $user
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message '=> $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function login(array $data){

        $user = User::where('email',$data['email'])->first();

        if(!$user || !Hash::check($data['password'],$user->password)){
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
                'data' => []
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'Bearer',
            'data' => $user,
        ]);

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'User logout successfully',
            'data' => []
        ]);
    }
}