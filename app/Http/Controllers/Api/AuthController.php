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
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // --- INÍCIO DA DEPURAÇÃO ---

        // Passo 1: Tentamos encontrar o utilizador pelo 'admins_user' (que é o nosso campo de email)
        $user = \App\Models\User::where('admins_user', $credentials['email'])->first();

        // Passo 2: Verificamos se o utilizador foi encontrado
        if (!$user) {
            // Se não encontrámos o utilizador, o problema está aqui.
            return response()->json(['message' => 'DEBUG: Utilizador não encontrado com este email.'], 401);
        }

        // Passo 3: Verificamos se a senha corresponde à hash no banco
        if (!\Hash::check($credentials['password'], $user->getAuthPassword())) {
            // Se a senha não bate certo, o problema está aqui.
            return response()->json(['message' => 'DEBUG: A senha está incorreta.'], 401);
        }

        // --- FIM DA DEPURAÇÃO ---

        // Se passou nos dois testes, o login é válido
        Auth::login($user);
        $request->session()->regenerate();
        return response()->json($user);
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