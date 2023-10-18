<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\Wallets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Wallets::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = Wallets::create([
            'users_id' => $request->users_id,
            'name' => $request->name,
            'balance' => $request->balance,
            'description' => $request->description
        ]);
        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $wallet_id)
    {
        $wallet = Wallets::with('transactions')->find($wallet_id);
        
        return response()->json($wallet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Wallets $wallet, Request $request)
    {
        $wallet->fill($request->only(['name', 'description']));
        $wallet->save();

        return $wallet;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $wallet_id)
    {
        Wallets::destroy($wallet_id);
        return response()->noContent();
    }

    public function withdraw(int $wallet_id, Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'string|max:255'
        ]);

        DB::beginTransaction();

        try {

            $wallet = Wallets::find($wallet_id);

            if(!$wallet) {
                return response()->json(['error' => 'Wallet not found'], 404);
            }

            (float)$current_balance = $wallet->balance;
            (float)$amount = $request->amount ?? 0;

            if($amount < $current_balance && $amount > 0) {
                Transactions::create([
                    'wallets_id' => $wallet_id,
                    'previous_balance' => $current_balance,
                    'transaction_type' => 2,
                    'amount' => $amount,
                    'transaction_date' => date('Y-m-d'),
                    'description' => $request->description
                ]);
                
                $wallet->balance -= $amount;
                $wallet->save();

                DB::commit();

                return response()->json(
                    [
                        'message' => 'Successful withdrawal', 
                        'data' => $wallet
                    ], 
                    200
                );
            }

            DB::rollBack();

            return response()->json(['message' => 'Insufficient funds'], 422);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Server error', $e], 500);
        } 
    }

    public function deposit(int $wallet_id, Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'string|max:255'
        ]);

        DB::beginTransaction();
        
        $wallet = Wallets::find($wallet_id);

        if(!$wallet) {
            return response()->json(['error' => 'Wallet not found'], 404);
        }

        try{
            Transactions::create([
                'wallets_id' => $wallet_id,
                'previous_balance' => $wallet->balance,
                'transaction_type' => 1,
                'amount' => $request->amount,
                'transaction_date' => date('Y-m-d'),
                'description' => $request->description
            ]);
    
            $wallet->balance += $request->amount;
            $wallet->save();
            
            DB::commit();

            return response()->json(['message' => 'Deposit made successfully', $wallet], 201);

        } catch(\Exception $e) {
            return response()->json(['message' => 'Server error', $e], 500);
        }
    } 
}
