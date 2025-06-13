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
            'rol' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            if ($request->rol === 'admin') {
                return view('registerAdmin', ['error' => $error]);
            } else {
                return view('register', ['error' => $error]);
            }
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->rol === 'admin') {
            $user->assignRole('admin');
        } else {
            $user->assignRole('client');
        }

        return view('welcome');
    }

    public function viewRegister()
    {
        return view('register');
    }

    public function viewRegisterAdmin()
    {
        return view('registerAdmin');
    }


}
