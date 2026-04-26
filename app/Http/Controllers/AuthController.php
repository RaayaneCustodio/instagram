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
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"   => "erro",
                "codigo"   => "DADOS_INVALIDOS",
                "mensagem" => "E-mail e senha são obrigatórios."
            ], 405);
        }


        $credentials = [
            'email'    => $request->email,
            'password' => $request->senha
        ];

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                "status"   => "erro",
                "codigo"   => "NAO_AUTORIZADO",
                "mensagem" => "E-mail ou senha inválidos."
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
}
