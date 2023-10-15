<?php

namespace App\Http\Controllers;

use App\Models\Wallets;
use Illuminate\Http\Request;

class ApiFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
