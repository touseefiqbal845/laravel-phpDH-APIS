<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * User Registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $user
        ], 201);
    }

    /**
     * User Login
     */
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ], 200);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    /**
     * Check Authenticated User
     */
    public function checkAuth(Request $request)
    {
        return response()->json(['user' => $request->user()], 200);
    }

    /**
     * Request Password Reset
     */
    public function resetPasswordRequest(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 400);
        }

        $token = Str::random(60);
        $user->reset_password_token = $token;
        $user->save();

        $resetLink = url("/reset-password?token={$token}&email={$user->email}");
        Mail::raw("Click here to reset your password: {$resetLink}", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Reset Password Request');
        });

        return response()->json(['message' => 'Password reset link sent successfully'], 200);
    }

    /**
     * Reset Password
     */
    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email)
            ->where('reset_password_token', $request->token)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid token or email'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->reset_password_token = null;
        $user->save();

        Mail::raw("Your password has been reset successfully.", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Reset Success');
        });

        return response()->json(['message' => 'Password reset successfully'], 200);
    }
}
