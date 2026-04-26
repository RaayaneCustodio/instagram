<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function store(Request $request)
    {

        $regras = [
            'nome'      => 'required|min:3|max:60|regex:/^[a-zA-Z\s]+$/',
            'email'     => 'required|email|min:10|max:35|unique:usuarios,email',
            'usuario'   => 'required|min:3|max:30|unique:usuarios,usuario|regex:/^[a-z0-9_]+$/',
            'senha'     => 'required|min:8|max:24',
            'biografia' => 'required|max:150',
        ];

        $mensagens = [
            'required'       => 'O campo :attribute é obrigatorio.',
            'email.unique'   => 'Este e-mail já está sendo utilizado.',
            'usuario.unique' => 'Este nome de usuário já está em uso.',
            'nome.regex'     => 'O nome deve conter apenas letras.',
            'usuario.regex'  => 'O usuário deve conter apenas letras minúsculas, números e underline.',
            'senha.min'      => 'A senha deve ter no mínimo 8 caracteres.',
            'email.email'    => 'Por favor, informe um endereço de e-mail válido.',
        ];


        $validator = Validator::make($request->all(), $regras, $mensagens);

        if ($validator->fails()) {

            request()->merge(['detalhes_tecnicos' => $validator->errors()->toArray()]);

            return response()->json([
                "status"   => "erro",
                "codigo"   => "DADOS_INVALIDOS",
                "mensagem" => "Um ou mais campos não atendem aos requisitos de segurança."
            ], 405);
        }

        try {

            $usuario = Usuario::create([
                'nome'      => $request->nome,
                'email'     => $request->email,
                'usuario'   => $request->usuario,
                'senha'     => Hash::make($request->senha),
                'biografia' => $request->biografia,
                'foto'      => $request->foto ?? null,
                'ativo'     => true
            ]);

            return response()->json([
                "status"   => "sucesso",
                "codigo"   => "USUARIO_CRIADO",
                "mensagem" => "Usuário cadastrado com sucesso",
                "dados"    => [
                    "id"      => (string)$usuario->id,
                    "nome"    => $usuario->nome,
                    "usuario" => $usuario->usuario
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status"   => "erro",
                "codigo"   => "ERRO_INTERNO",
                "mensagem" => "Erro ao processar o cadastro no servidor."
            ], 500);
        }
    }
}
