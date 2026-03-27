<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return response()->json($users, Response::HTTP_OK);
    }

    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Invalid credentials'
                ]
                , Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken($request->email)->plainTextToken;
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Login successful',
                'token' => $token
            ]
            , Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Logout successful'
            ]
            , Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(6)->letters()->numbers()->symbols()->uncompromised()->mixedCase()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Registration successful',
                'user' => $user
            ]
            , Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'User not found'
                ]
                , Response::HTTP_NOT_FOUND);
        }
        return response()->json($user, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'User not found'
                ]
                , Response::HTTP_NOT_FOUND);
        }

        // Validate the request data
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => ['required', 'confirmed', Password::min(6)->letters()->numbers()->symbols()->uncompromised()->mixedCase()],
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'User updated successfully',
                'user' => $user
            ]
            , Response::HTTP_OK);
    }

    public function validarToken(Request $request)
    {
        $user = $request->user();
        
        if ($user) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Token is valid',
                    'user' => $user
                ]
                , Response::HTTP_OK);
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Invalid token'
                ]
                , Response::HTTP_UNAUTHORIZED);
        }
    }
}
