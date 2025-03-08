<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// 🔽 追加
use App\Models\Todo;

class TodoController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $todos = Todo::with('user')->latest()->get();
    return response()->json($todos);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'todo' => 'required|max:255',
    ]);
    $todo = $request->user()->todos()->create($request->only('todo'));
    return response()->json($todo, 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(Todo $todo)
  {
    return response()->json($todo);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Todo $todo)
  {
    $request->validate([
      'todo' => 'required|string|max:255',
    ]);
    $todo->update($request->all());

    return response()->json($todo);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Todo $todo)
  {
    $todo->delete();
    return response()->json(['message' => 'Todo deleted successfully']);
  }
}

