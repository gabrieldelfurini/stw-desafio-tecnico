<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class IngredienteController extends Controller
{
    public function index(){

        $ingredientes = Ingrediente::all();

        if($ingredientes->count() > 0){

            return response()->json([
                'status' => 200,
                'ingredientes' => $ingredientes 
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
            'codigo' => 'required|integer|unique:ingredientes,codigo',
            'descricao' => 'required|string|max:191'
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else {

            $ingrediente = Ingrediente::create([
                'codigo' => $request->codigo,
                'descricao' => $request->descricao
            ]);

            if($ingrediente){
                
                return response()->json([
                    'status' => 200,
                    'message' => "Ingrediente Criado Com Sucesso!"
                ], 200);
            }else{

                return response()->json([
                    'status' => 500,
                    'message' => "Aconteceu algo errado!"
                ], 500);
            }
        }
    }







}

