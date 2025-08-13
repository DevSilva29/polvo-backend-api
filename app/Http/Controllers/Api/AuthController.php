<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string', // No React, o campo é 'email'
            'password' => 'required|string',
        ]);

        // O Laravel vai procurar o 'email' na coluna 'admins_user'
        if (Auth::attempt(['admins_user' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            // Retorna os dados do utilizador logado
            return response()->json(Auth::user());
        }

        return response()->json([
            'message' => 'As credenciais fornecidas estão incorretas.'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout efetuado com sucesso.']);
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}