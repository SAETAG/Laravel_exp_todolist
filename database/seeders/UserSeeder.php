<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// 🔽 2行追加
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'ハナヒゲウツボ',
            'email' => 'hanahige@example.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => 'ミナミハコフグ',
            'email' => 'minami@example.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => 'タテジマキンチャクダイ',
            'email' => 'tatejima@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
