<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/login');
});


Route::view('/login', 'login');
Route::view('/cadastro', 'cadastro');
Route::view('/perfil', 'perfil');
