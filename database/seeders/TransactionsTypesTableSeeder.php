<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transactions_types')->insert([
            'id' => 1,
            'transaction_type' => 'deposit'
        ]);
        
        DB::table('transactions_types')->insert([
            'id' => 2,
            'transaction_type' => 'withdraw'
        ]);

        DB::table('transactions_types')->insert([
            'id' => 3,
            'transaction_type' => 'transfer_sent'
        ]);

        DB::table('transactions_types')->insert([
            'id' => 4,
            'transaction_type' => 'transfer_recived'
        ]);
    }
}
