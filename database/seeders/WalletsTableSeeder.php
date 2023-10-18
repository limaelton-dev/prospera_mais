<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('wallets')->insert([
            'users_id' => 1,
            'name' => 'Primeira Carteira ITAU',
            'balance' => 100000.99,
            'description' => 'Primeira carteira criada com seeder',
        ]);

        DB::table('wallets')->insert([
            'users_id' => 1,
            'name' => 'Segunda Carteira BB',
            'balance' => 450000.97,
            'description' => 'Segunda carteira criada com seeder',
        ]);

        DB::table('wallets')->insert([
            'users_id' => 1,
            'name' => 'Terceira Carteira NEXT',
            'balance' => 0,
            'description' => 'Terceira carteira criada com seeder',
        ]);
    }
}
