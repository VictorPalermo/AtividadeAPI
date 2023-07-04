<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TaskController extends Controller
{
    public function index() // Lista todas as tarefas.
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $taskData = [
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'status' => $request->status,
        ];
    
        DB::table('tasks')->insert($taskData );
    
        return response()->json([
            'status' => 'success',
            'message' => 'Registro inserido com sucesso',
        ], 200);
    }

    public function show($id)
    {
        $task = Task::find($id);
 
        if ($task) {
            return response()->json($task);
        } else {
            return response()->json(['error' => 'Tarefa não encontrada'], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        $taskData = DB::table('tasks')->where('id', $id)->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'status' => $request->status,
        ]);
    
        if ($taskData) {
            return response()->json($request);
        }
    }

    public function destroy(Task $id) // Exclui uma tarefa.
    {
        $id->delete();
        return response()->json(['status' => 'success',
        'message' => 'Registro inserido com sucesso',], 204); // O código de status HTTP 204 significa "No Content".
    }
}