<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Mail::to($request->email)->send(new WelcomeMail($user));

        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'message' => 'user created',
            'user' => $user,
            'token' => $token,
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }
        /**  @var User $user */
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        $cookie = cookie('token', $token, 60 * 24);
        return response(['Message' => 'Logged in', 'user' => $user, 'token' => $token], Response::HTTP_OK)->withCookie($cookie);
    }

    public function logout()
    {
        /**  @var User $user */
        $user = Auth::user();
        $user->tokens()->delete();
        $cookie = Cookie::forget('token');
        return response(['message' => 'Logged out'], Response::HTTP_OK)->withCookie($cookie);
    }
}
