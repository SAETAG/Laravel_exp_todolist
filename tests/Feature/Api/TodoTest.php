<?php

use App\Models\Todo;
use App\Models\User;

// 作成のテスト
it('allows authenticated users to create a todo', function () {
  $user = User::factory()->create();
  $token = $user->createToken('test_token')->plainTextToken;

  $data = ['todo' => 'This is a new todo'];

  $response = $this->postJson('/api/todos', $data, [
    'Authorization' => 'Bearer ' . $token
  ]);

  $response->assertStatus(201);
  $response->assertJson(['todo' => 'This is a new todo']);
});

// 一覧取得のテスト
it('displays a list of todos', function () {
  $user = User::factory()->create();
  $token = $user->createToken('test_token')->plainTextToken;

  Todo::factory()->count(3)->create();

  $response = $this->getJson('/api/todos', [
    'Authorization' => 'Bearer ' . $token
  ]);

  $response->assertStatus(200);
  $response->assertJsonCount(3);
});

// 詳細取得のテスト
it('displays a specific todo', function () {
  $user = User::factory()->create();
  $token = $user->createToken('test_token')->plainTextToken;

  $todo = Todo::factory()->create();

  $response = $this->getJson('/api/todos/' . $todo->id, [
    'Authorization' => 'Bearer ' . $token
  ]);

  $response->assertStatus(200);
  $response->assertJson(['id' => $todo->id]);
});

// 更新のテスト
it('allows a user to update their todo', function () {
  $user = User::factory()->create();
  $token = $user->createToken('test_token')->plainTextToken;

  $todo = Todo::factory()->create(['user_id' => $user->id]);

  $data = ['todo' => 'Updated todo content'];

  $response = $this->putJson('/api/todos/' . $todo->id, $data, [
    'Authorization' => 'Bearer ' . $token
  ]);

  $response->assertStatus(200);
  $response->assertJson(['todo' => 'Updated todo content']);
});

// 削除のテスト
it('allows a user to delete their todo', function () {
  $user = User::factory()->create();
  $token = $user->createToken('test_token')->plainTextToken;

  $todo = Todo::factory()->create(['user_id' => $user->id]);

  $response = $this->deleteJson('/api/todos/' . $todo->id, [], [
    'Authorization' => 'Bearer ' . $token
  ]);

  $response->assertStatus(200);
  $response->assertJson(['message' => 'Todo deleted successfully']);
});

