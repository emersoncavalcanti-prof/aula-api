<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProdutoController extends Controller
{
    public function index()
    {
        return Produto::all();
    }

    public function store(Request $request)
    {
        // Validação dos dados de entrada
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'descricao' => 'nullable|string',
            'quantidade' => 'required|integer',
        ]);

        $produto = Produto::create($request->all());
        return response()->json($produto, Response::HTTP_OK);
    }

    public function show($id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($produto, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], Response::HTTP_NOT_FOUND);
        }

        // Validação dos dados de entrada
        $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'preco' => 'sometimes|required|numeric',
            'descricao' => 'nullable|string',
            'quantidade' => 'sometimes|required|integer',
        ]);

        $produto->update($request->all());
        return response()->json($produto, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], Response::HTTP_NOT_FOUND);
        }
        $produto->delete();
        return response()->json(['message' => 'Produto deletado com sucesso'], Response::HTTP_OK);
    }
}
