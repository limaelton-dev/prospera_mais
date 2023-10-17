<?php

namespace App\Http\Controllers;

use App\Models\Wallets;
use Illuminate\Http\Request;

class ApiFinanceController extends Controller
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
        $wallet = Wallets::find($wallet_id);
        
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
}
