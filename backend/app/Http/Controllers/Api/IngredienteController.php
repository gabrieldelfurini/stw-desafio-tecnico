<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class IngredienteController extends Controller
{
    public function index()
    {

        $ingredientes = Ingrediente::all();

        if ($ingredientes->count() > 0) {

            return response()->json([
                'status' => 200,
                'ingredientes' => $ingredientes
            ], 200);
        } else {

            return response()->json([
                'status' => 404,
                'message' => 'Nenhum registro encontrado'
            ], 404);
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'codigo' => 'required|integer|unique:ingredientes,codigo',
            'descricao' => 'required|string|max:191'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {

            $ingrediente = Ingrediente::create([
                'codigo' => $request->codigo,
                'descricao' => $request->descricao
            ]);

            if ($ingrediente) {

                return response()->json([
                    'status' => 200,
                    'message' => "Ingrediente Criado Com Sucesso!"
                ], 200);
            } else {

                return response()->json([
                    'status' => 500,
                    'message' => "Aconteceu algo errado!"
                ], 500);
            }
        }
    }

    public function show($id)
    {

        $ingrediente = Ingrediente::find($id);
        if ($ingrediente) {

            return response()->json([
                'status' => 200,
                'ingrediente' => $ingrediente
            ], 200);
        } else {

            return response()->json([
                'status' => 404,
                'message' => "Ingrediente não encontrado!"
            ], 404);
        }
    }

    public function edit($id)
    {

        $ingrediente = Ingrediente::find($id);
        if ($ingrediente) {

            return response()->json([
                'status' => 200,
                'ingrediente' => $ingrediente
            ], 200);
        } else {

            return response()->json([
                'status' => 404,
                'message' => "Ingrediente não encontrado!"
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {

        $validator = Validator::make($request->all(), [
            'codigo' => 'required|integer',
            'descricao' => 'required|string|max:191'
        ]);

        if ($validator->fails()) {

            return  response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {

            $ingrediente = Ingrediente::find($id);

            if ($ingrediente) {

                $ingrediente->update([
                    'codigo' => $request->codigo,
                    'descricao' => $request->descricao
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Ingrediente Atualizado com Sucesso"
                ], 200);
            } else {

                return response()->json([
                    'status' => 404,
                    'message' => "Ingrediente não encontrado!"
                ], 404);
            }
        }
    }

    public function destroy($id)
    {

        $ingrediente = Ingrediente::find($id);

        if ($ingrediente) {

            $ingrediente->delete();
            return response()->json([
                'status' => 200,
                'message' => "Ingrediente Excluído com Sucesso!"
            ], 200);
        } else {

            return response()->json([
                'status' => 404,
                'message' => "Ingrediente não encontrado!"
            ], 404);
        }
    }
}

//Comecei a mexer a partir daqui
