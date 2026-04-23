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
        $validator = Validator::make($request->all(), [
            'nome' => 'required|min:3|max:60|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|min:10|max:35|unique:usuarios,email',
            'usuario'   => 'required|min:3|max:30|unique:usuarios,usuario|regex:/^[a-z0-9_]+$/',
            'senha'     => 'required|min:8|max:24',
            'biografia' => 'required|min:5|max:120',
        ]);
    }
}
