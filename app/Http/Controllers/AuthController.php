<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Incorrect credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('token');

        $tokenModel = $token->accessToken;
        $tokenModel->expires_at = Carbon::now()->addWeeks(2);
        $tokenModel->save();

        return response()->json(['token' => $token->plainTextToken]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return view('register', ['error' => $error]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('client');

        $token = $user->createToken('token');

        $tokenModel = $token->accessToken;
        $tokenModel->expires_at = Carbon::now()->addWeeks(2);
        $tokenModel->save();

        return response()->json(['user' => $user, 'token' => $token->plainTextToken], 201);
    }

    public function viewRegister()
    {
        return view('register');
    }

}
