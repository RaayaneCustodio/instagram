<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'usuario' => 'required',
            'senha'   => 'required',
        ]);

        if ($validator->fails()) {
            request()->merge(['detalhes_tecnicos' => $validator->errors()->toArray()]);
            return response()->json([
                "status"   => "erro",
                "codigo"   => "DADOS_INVALIDOS",
                "mensagem" => "Usuário e senha são obrigatórios."
            ], 405);
        }

        $credentials = [
            'usuario'  => $request->usuario,
            'password' => $request->senha
        ];

        if (!$token = auth('api')->attempt($credentials)) {
            request()->merge(['detalhes_tecnicos' => ['login' => 'Credenciais inválidas.']]);
            return response()->json([
                "status"   => "erro",
                "codigo"   => "NAO_AUTORIZADO",
                "mensagem" => "Usuário ou senha inválidos."
            ], 401);
        }

        $usuario = auth('api')->user();

        return response()->json([
            "status"   => "sucesso",
            "codigo"   => "LOGIN_SUCESSO",
            "mensagem" => "Login realizado com sucesso",
            "dados"    => [
                "token"   => $token,
                "usuario" => [
                    "id"    => (string)$usuario->id,
                    "nome"  => $usuario->nome,
                    "email" => $usuario->email
                ]
            ]
        ], 200);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            "status"   => "sucesso",
            "codigo"   => "LOGOUT_REALIZADO",
            "mensagem" => "Logout realizado com sucesso"
        ], 200);
    }
}
