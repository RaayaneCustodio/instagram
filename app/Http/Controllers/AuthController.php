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

        // Verifica se o usuário está ativo (Blindagem extra)
        if (!$usuario->ativo) {
            auth('api')->logout();
            return response()->json([
                "status"   => "erro",
                "codigo"   => "CONTA_DESATIVADA",
                "mensagem" => "Esta conta foi excluída ou desativada."
            ], 401);
        }

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

    public function logout(Request $request)
    {
        try {

            auth('api')->logout();

            return response()->json([
                "status"   => "sucesso",
                "codigo"   => "OPERACAO_SUCESSO",
                "mensagem" => "Logout realizado com sucesso",
                "dados"    => new \stdClass()
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "status"   => "erro",
                "codigo"   => "TOKEN_INVALIDO",
                "mensagem" => "Não foi possível realizar o logout ou o token já expirou."
            ], 401);
        }
    }
}
