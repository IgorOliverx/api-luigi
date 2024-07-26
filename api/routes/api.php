<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//rota publica
Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::post('/login', [LoginController::class, 'login'])->name('login');


//rota restrita
Route::group(['middleware' => ['auth:sanctum']], function(){

    //logout
    Route::post('/logout/{user}', [LoginController::class, 'logout']);

    //Criar usuário
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    //Listar usuários individualmente
    Route::post('/users/{user}', [UserController::class, 'show'])->name('users.show');

    //Atualizar usuário
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    //Deletar usuário
    Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');

});
