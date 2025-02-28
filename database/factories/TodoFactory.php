<?php

namespace Database\Factories;

// 🔽 2行追加
use App\Models\Todo;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    // 🔽 追加
    protected $model = Todo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        // 🔽 追加
        return [
        'user_id' => User::factory(), // UserモデルのFactoryを使用してユーザを生成
        'todo' => $this->faker->text(200) // ダミーのテキストデータ
        ];
    }

}
