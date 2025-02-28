<?php

// 🔽 追加
use App\Models\Todo;
use App\Models\User;

// 🔽一覧取得のテスト
it('displays todos', function () {
  // ユーザを作成
  $user = User::factory()->create();

  // ユーザを認証
  $this->actingAs($user);

  // Todoを作成
  $todo = Todo::factory()->create();

  // GETリクエスト
  $response = $this->get('/todos');

  // レスポンスにTodoの内容と投稿者名が含まれていることを確認
  $response->assertStatus(200);
  $response->assertSee($todo->todo);
  $response->assertSee($todo->user->name);
});

// 作成画面のテスト
it('displays the create todo page', function () {
  // テスト用のユーザーを作成
  $user = User::factory()->create();

  // ユーザーを認証（ログイン）
  $this->actingAs($user);

  // 作成画面にアクセス
  $response = $this->get('/todos/create');

  // ステータスコードが200であることを確認
  $response->assertStatus(200);
});

// 作成処理のテスト
it('allows authenticated users to create a todo', function () {
  // ユーザを作成
  $user = User::factory()->create();

  // ユーザを認証
  $this->actingAs($user);

  // Todoを作成
  $todoData = ['todo' => 'This is a test todo.'];

  // POSTリクエスト
  $response = $this->post('/todos', $todoData);

  // データベースに保存されたことを確認
  $this->assertDatabaseHas('todos', $todoData);

  // レスポンスの確認
  $response->assertStatus(302);
  $response->assertRedirect('/todos');
});

// 詳細画面のテスト
it('displays a todo', function () {
  // ユーザを作成
  $user = User::factory()->create();

  // ユーザを認証
  $this->actingAs($user);

  // Todoを作成
  $todo = Todo::factory()->create();

  // GETリクエスト
  $response = $this->get("/todos/{$todo->id}");

  // レスポンスにTodoの内容が含まれていることを確認
  $response->assertStatus(200);
  $response->assertSee($todo->todo);
  $response->assertSee($todo->created_at->format('Y-m-d H:i'));
  $response->assertSee($todo->updated_at->format('Y-m-d H:i'));
  $response->assertSee($todo->todo);
  $response->assertSee($todo->user->name);
});

// 編集画面のテスト
it('displays the edit todo page', function () {
  // テスト用のユーザーを作成
  $user = User::factory()->create();

  // ユーザーを認証（ログイン）
  $this->actingAs($user);

  // Todoを作成
  $todo = Todo::factory()->create(['user_id' => $user->id]);

  // 編集画面にアクセス
  $response = $this->get("/todos/{$todo->id}/edit");

  // ステータスコードが200であることを確認
  $response->assertStatus(200);

  // ビューにTodoの内容が含まれていることを確認
  $response->assertSee($todo->todo);
});

// 更新処理のテスト
it('allows a user to update their todo', function () {
  // ユーザを作成
  $user = User::factory()->create();

  // ユーザを認証
  $this->actingAs($user);

  // Todoを作成
  $todo = Todo::factory()->create(['user_id' => $user->id]);

  // 更新データ
  $updatedData = ['todo' => 'Updated todo content.'];

  // PUTリクエスト
  $response = $this->put("/todos/{$todo->id}", $updatedData);

  // データベースが更新されたことを確認
  $this->assertDatabaseHas('todos', $updatedData);

  // レスポンスの確認
  $response->assertStatus(302);
  $response->assertRedirect("/todos/{$todo->id}");
});

// 削除処理のテスト
it('allows a user to delete their todo', function () {
  // ユーザを作成
  $user = User::factory()->create();

  // ユーザを認証
  $this->actingAs($user);

  // Todoを作成
  $todo = Todo::factory()->create(['user_id' => $user->id]);

  // DELETEリクエスト
  $response = $this->delete("/todos/{$todo->id}");

  // データベースから削除されたことを確認
  $this->assertDatabaseMissing('todos', ['id' => $todo->id]);

  // レスポンスの確認
  $response->assertStatus(302);
  $response->assertRedirect('/todos');
});