<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $school_id = $request->school_id ?? null;

        if (!$school_id) {
            return response()->json(['error' => 'Specify School id'], Response::HTTP_BAD_REQUEST);
        }

        $school = School::find($school_id);
        if (!$school) {
            return response()->json(['error' => 'School not found'], Response::HTTP_BAD_REQUEST);
        }

        if ($school->Email_Exists_within_School($request->email)) {
            return response()->json(['error' => 'Email already registered within this school'], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'school_id' => $school->id,
        ]);

        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'message' => 'user created',
            'user' => $user,
            'token' => $token,
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']) + ['school_id' => $request->school_id];
        if (!Auth::attempt($credentials)) {
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
