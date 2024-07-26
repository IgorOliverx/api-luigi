<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        //validando credenciais
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {

            //recuperar dados do usuario
            $user = Auth::user();

            $token = $request->user()->createToken('api-token')->plainTextToken;


            return response()->json([
                'status' => true,
                'user' => $user,
                'token' => $token
            ], 201);
        }else{
            return response()->json([
               'status' => false,
               'message' => 'Credenciais incorretas'
            ], 422);
        }
    }

    public function logout(User $user): JsonResponse
    {
        try{
            $user->tokens()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Deslogado com sucesso'
            ], 200);
        }catch(Exception $error){
            return response()->json([
                'status' => false,
                'message' => 'Houve um erro ao deslogar',
                'error' => $error->getMessage(),
            ], 400);
        }
    }
}
