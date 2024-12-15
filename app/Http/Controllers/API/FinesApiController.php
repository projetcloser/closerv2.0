<?php

namespace App\Http\Controllers\API;

use App\Models\Fine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fines = Fine::where('open_close', '!=', 1)->get();
        return response()->json($fines);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'member_id' => 'required|int',
            'object' => 'required|string',
            'amount' => 'required|string',
            'author' => 'required|string'
            // Ajouter d'autres règles de validation pour les autres champs
        ]);

        $fine = Fine::create($validatedData);

        return response()->json($fine, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $fine = Fine::where('id', $id)->where('open_close', '!=', 1)->first();

        if (!$fine) {
            return response()->json(['message' => 'Fine not found or closed'], 404);
        }

        return response()->json($fine);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $fine = Fine::find($id);

        if (!$fine) {
            return response()->json(['message' => 'Fine not found'], 404);
        }

        $validatedData = $request->validate([
            'member_id' => 'required|int',
            'object' => 'required|string',
            'amount' => 'required|string',
            'author' => 'required|string'
            // Ajouter d'autres règles de validation si nécessaire
        ]);

        $fine->update($validatedData);

        return response()->json($fine);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fine = Fine::find($id);

        if (!$fine) {
            return response()->json(['message' => 'Fine not found'], 404);
        }

        $fine->update(['open_close' => 1]);

        return response()->json(['message' => 'Fine marked as closed']);
    }
}
