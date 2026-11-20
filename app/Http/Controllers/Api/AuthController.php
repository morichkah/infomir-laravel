<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registration(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $data['role_id'] = Role::query()
            ->where('slug', Role::READER)
            ->value('id');

        $user = User::create($data);

        return response()->json([
            'message' => 'Регистрация успешна',
            'user' => $user
        ], 201);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->attempt($credentials)) {
            return response()->json(['message' => 'Неверный email или пароль'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Успешный вход',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->tokens()->delete();
        }

        return response()->json(['message' => 'Выход выполнен']);
    }
}