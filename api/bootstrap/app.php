<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //Lançar uma excecao quando houver erro de autenticacao
        $exceptions->render(function (AuthenticationException $e){
            //retornar mensagem de erro e status code 401
            return response()->json([
               'status' => false,
                'message' => 'Token de Autenticação inválido',
            ]);
        });

    })->create();
