<?php

namespace App\Http\Controllers\api\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stancl\Tenancy\Database\Models\Tenant;

class AuthController extends Controller
{
    public function register(SignupRequest $request)
    {
        
        $data = $request->validated();
        /** @var User $user */
        $emailCheck = User::where('email', $data['email'])->first();
        if ($emailCheck) {
            return response([
                'status' => 422,
                'msg' => "This email already exists"
            ]);
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => User::STATUS_PENDING,
        ]);

        // $token = $user->createToken('main')->plainTextToken;
        // Auth::login($user);

        $userdata = Auth::user();
        return response(
            [
                'status' => 200,
                "msg" => 'User registered successfully. Waiting for admin approval.',
                // 'token' => $token,
                'user' => $userdata,
            ]
        );
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(
                [
                    'msg' => "Invalid credentials",
                    'status' => 422,
                ]
            );
        }

        if ($user->status != User::STATUS_APPROVED) {
            return response(
                [
                    'msg' => "Your account is not approved yet",
                    'status' => 422,
                ]
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token_type' => 'Bearer',
            'status' => 200,
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
