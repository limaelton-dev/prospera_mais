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
        DB::trable('transactions_types')->create([
            'id' => 1,
            'transaction_type' => 'deposit'
        ]);
        
        DB::trable('transactions_types')->create([
            'id' => 2,
            'transaction_type' => 'withdraw'
        ]);

        DB::trable('transactions_types')->create([
            'id' => 3,
            'transaction_type' => 'transfer_sent'
        ]);

        DB::trable('transactions_types')->create([
            'id' => 4,
            'transaction_type' => 'transfer_recived'
        ]);
    }
}
