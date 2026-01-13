<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // REGISTAR (Cria user e devolve token)
    public function register(Request $request) {
        $dados = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create($dados); // A password é hasheada automaticamente no Laravel 11 se usares o 'casts' no model, mas por segurança vamos assumir o padrão.
        
        // Vamos garantir o hash manual para não haver dúvidas
        $user->password = Hash::make($request->password);
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    // LOGIN (Verifica e devolve token)
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // Se user não existe OU a password está errada
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        // Se passou, cria novo token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Login com sucesso!', 'token' => $token]);
    }

    // LOGOUT (Apaga os tokens)
    public function logout(Request $request) {
        // Apaga o token que foi usado neste pedido
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout efetuado']);
    }
}