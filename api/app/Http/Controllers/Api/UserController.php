<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class UserController extends Controller
{
    private readonly User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->user->orderBy('id', 'desc')->get();

        return response()->json([
           'status' => 'true',
           'users' => $users,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        //Iniciando a transação com o Facade DB
            DB::beginTransaction();
        try{
            $dados = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            $password = $dados['password'];
            $dados['password'] = Hash::make($password);

            $this->user->create($dados);

            DB::commit();
            return response()->json([
                'status' => 'true',
                'message' => 'Usuário cadastrado com sucesso!',
                'user' => $dados
            ], 201);

        }catch (Exception $error){
            DB::rollBack();

            return response()->json([
                'status' => 'false',
                'message' => 'Não foi possível cadastrar o usuário',
                'error' => $error->getMessage(),
            ], 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'status' => 'true',
            'user' => $user
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        DB::beginTransaction();
        try{
            $dados = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

           $user = $this->user->where('id', $user->id)->update($dados);
            DB::commit();

            return response()->json([
               'status' => 'true',
               'message' => 'Usuário atualizado com sucesso!',
            ], 200);
        }catch (\Exception $error){
            DB::rollBack();

            return response()->json([
                'status' => 'false',
                'message' => 'Não foi possível atualizar o usuário!',
                'error' => $error->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try{
            $user = $this->user->find($id);
            $user->delete();

            DB::commit();

            return response()->json([
                'status' => 'true',
                'message' => 'Usuário deletado com sucesso!',
            ], 200);
        }catch (\Exception $error){
            DB::rollBack();

            return response()->json([
                'status' => 'false',
                'message' => 'Não foi possível deletar o usuário!',
                'error' => $error->getMessage(),
            ], 400);
        }
    }
}
