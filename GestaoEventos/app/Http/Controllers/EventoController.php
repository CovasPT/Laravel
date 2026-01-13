<?php

namespace App\Http\Controllers;

use App\Models\Evento; // <--- Importante: Importar o Modelo!
use Illuminate\Http\Request;

class EventoController extends Controller
{
    // 1. LISTAR TODOS OS EVENTOS (GET)
    public function index()
    {
        // <---------------- Alterado por gemini: Eloquent ORM em ação
        // Em vez de "SELECT * FROM eventos", basta isto:
        return Evento::all();
    }

    // 2. CRIAR UM NOVO EVENTO (POST)
    public function store(Request $request)
    {
        // <---------------- Alterado por gemini: Validação automática
        // Se falhar, o Laravel envia logo erro 422 e para aqui. Não precisas de 'if/else'.
        $dadosValidados = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_hora' => 'required|date',
            'local' => 'required|string',
            'palestrante' => 'required|string',
            'status' => 'in:agendada,realizada,cancelada' // Só aceita estes valores
        ]);

        // Criar e salvar na BD numa só linha
        $evento = Evento::create($dadosValidados);

        return response()->json([
            'message' => 'Evento criado com sucesso!',
            'data' => $evento
        ], 201);
    }

    /**
     * Display the specified resource.
     */
public function show(string $id)
    {
        // <---------------- Alterado por gemini: Procura pelo ID
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json(['message' => 'Evento não encontrado'], 404);
        }

        return $evento;
    }

    // 4. ATUALIZAR EVENTO (PUT /api/eventos/{id})
    public function update(Request $request, string $id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json(['message' => 'Evento não encontrado'], 404);
        }

        // Validamos apenas o que vier no pedido (sometimes)
        $dados = $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'descricao' => 'nullable|string',
            'data_hora' => 'sometimes|date',
            'local' => 'sometimes|string',
            'palestrante' => 'sometimes|string',
            'status' => 'sometimes|in:agendada,realizada,cancelada'
        ]);

        // <---------------- Alterado por gemini: O Laravel atualiza só os campos que mudaram
        $evento->update($dados);

        return $evento;
    }

    // 5. APAGAR EVENTO (DELETE /api/eventos/{id})
    public function destroy(string $id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json(['message' => 'Evento não encontrado'], 404);
        }

        $evento->delete();

        return response()->json(['message' => 'Evento apagado com sucesso!'], 200);
    }
}