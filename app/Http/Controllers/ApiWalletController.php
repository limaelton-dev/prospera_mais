<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\Wallets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Authenticatable $user)
    {
        $user_wallets = Wallets::where('users_id', $user->id)->get();

        if ($user_wallets->isEmpty()) {
            return response()->json(['message' => 'No wallets for this user'], 404);
        }
        
        return response()->json($user_wallets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Authenticatable $user)
    {
        //aqui, ainda preciso verificar se o usuário é admin
        $response = Wallets::create([
            'users_id' => $user->id,
            'name' => $request->name,
            'balance' => $request->balance,
            'description' => $request->description
        ]);
        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $wallet_id, Authenticatable $user)
    {
        $wallet = Wallets::where('users_id', $user->id)
                        ->with('transactions')
                        ->find($wallet_id);

        if (!$wallet) {
            return response()->json(['message' => 'No wallet found'], 404);
        }
        
        return response()->json($wallet, 200);
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
    public function destroy(int $wallet_id, Authenticatable $user)
    {
        //fazer validação dos dados!!
        if (!$user) {
            return response()->json(['error_message' => 'Unauthenticated user'], 401);
        }

        $wallet = Wallets::find($wallet_id)->where('users_id', $user->id);

        if(!$wallet) {
            return response()->json(['error_message' => 'No wallet found']);
        }

        $wallet->delete();
        $wallet->save();

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
            return response()->json(['message' => 'Server error'], 500);
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
            DB::rollBack();
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function transfer(int $wallet_id, Request $request)
    {
        dd($user->tokenCan('is_admin'));

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'to_wallet_id' => 'required|numeric|min:0.01',
            'description' => 'string|max:255'
        ]);

        DB::beginTransaction();

        $from_wallet = Wallets::find($wallet_id);
        $to_wallet = Wallets::find($request->to_wallet_id);

        if(!$from_wallet) {
            return response()->json(['message' => 'from_wallet_id not found'], 404);
        }

        if(!$to_wallet) {
            return response()->json(['message' => 'to_wallet_id not found'], 404);
        }

        if($request->amount < $from_wallet->balance)
        {
            try {
                Transactions::create([
                    'wallets_id' => $wallet_id,
                    'previous_balance' => $from_wallet->balance,
                    'transaction_type' => 3,
                    'amount' => $request->amount,
                    'transaction_date' => date('Y-m-d'),
                    'description' => $request->description
                ]);

                $from_wallet->balance -= $request->amount;
                $from_wallet->save();

                Transactions::create([
                    'wallets_id' => $to_wallet->id,
                    'previous_balance' => $to_wallet->balance,
                    'transaction_type' => 4,
                    'amount' => $request->amount,
                    'transaction_date' => date('Y-m-d'),
                    'description' => $request->description
                ]);

                $to_wallet->balance += $request->amount;
                $to_wallet->save();

                DB::commit();
                return response()->json(['message' => 'Transfer was successful', $from_wallet], 200);

            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => 'Server error'], 500);
            }
        }

        DB::rollBack();
        return response()->json(['message' => 'Insufficient funds'], 422);

    }
}
