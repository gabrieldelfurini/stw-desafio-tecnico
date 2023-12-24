<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Receita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReceitaController extends Controller
{
    public function index(){

        $receitas = Receita::all();

        if($receitas->count() > 0){

            return response()->json([
                'status' => 200,
                'receitas' => $receitas 
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'Nenhum registro encontrado'
            ],404);
        }
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|integer|unique:receitas,codigo',
            'descricao' => 'required|string|max:191',
            'ingredientesAdicionados' => 'required'
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else {

            $receita = Receita::create([
                'codigo' => $request->codigo,
                'descricao' => $request->descricao
            ]);

            if($receita){
                
                return response()->json([
                    'status' => 200,
                    'message' => "Receita Criada Com Sucesso!"
                ], 200);
            }else{

                return response()->json([
                    'status' => 500,
                    'message' => "Aconteceu algo errado!"
                ], 500);
            }
        }
    }

    public function show($id){

        $receita = Receita::find($id);
        if($receita){

            return response()->json([
                'status' => 200,
                'receita' => $receita
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "Receita não encontrada!"
            ], 404);
        }
    }

    public function edit($id){

        $receita = Receita::find($id);
        if($receita){

            return response()->json([
                'status' => 200,
                'receita' => $receita
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "Receita não encontrada!"
            ], 404);
        }
    }

    public function update(Request $request, int $id){

        $validator = Validator::make($request->all(), [
            'codigo' => 'required|integer', 
            'descricao' => 'required|string|max:191'
        ]);

        if($validator->fails()){

            return  response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else {

            $receita = Receita::find($id);

            if($receita){

                $receita->update([
                    'codigo' => $request->codigo,
                    'descricao' => $request->descricao
                ]);
                
                return response()->json([
                    'status' => 200,
                    'message' => "Receita Atualizada com Sucesso"
                ], 200);
            }else{

                return response()->json([
                    'status' => 404,
                    'message' => "Receita não encontrada!"
                ], 404);
            }
        }
    }

    public function destroy($id){

        $receita = Receita::find($id);

        if($receita){

            $receita->delete();
            return response()->json([
                'status' => 200,
                'message' => "Receita Excluída com Sucesso!"
            ], 200);
        }else{
            
            return response()->json([
                'status' => 404,
                'message' => "Receita não encontrada!"
            ], 404);
        }
    }
}
