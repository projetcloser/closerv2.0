<?php

namespace App\Http\Controllers\API;

use App\Models\Fine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FinesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $idPerso = $request->query('id_perso');
        $idRole = $request->query('id_role');
        if ($idPerso && $idRole == 1) {
            $fines = Fine::where('member_id', $idPerso)->where('open_close', '!=', 1)->get();
            return response()->json($fines);
        } else {
            $fines = Fine::where('open_close', '!=', 1)->get();
            return response()->json($fines);
        }
    }
    public function getUserAmende() {}

    public function search(Request $request)
    {
        $query = Fine::query();

        // Rechercher par mot-clé dans certains champs
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('object', 'like', "%$keyword%")
                    ->orWhere('amount', 'like', "%$keyword%")
                    ->orWhere('member_id', 'like', "%$keyword%")
                    // ->orWhere('start_date', 'like', "%$keyword%")
                    // ->orWhere('end_date', 'like', "%$keyword%")
                    ->orWhere('author', 'like', "%$keyword%");
            });
        }



        // Ajouter d'autres filtres si nécessaire
        // ...

        $staff = $query->get();

        return response()->json($staff);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'member_id' => 'required|int',
                'object' => 'required|string',
                'amount' => 'required',
                'author' => 'required|string'
                // Ajouter d'autres règles de validation pour les autres champs
            ]);

            $fine = Fine::create($validatedData);

            return response()->json($fine, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur de validation lors de la création de l\'annonce :', [
                'erreurs' => $e->errors()
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur inattendue lors de la création de l\'annonce : ' . $e->getMessage());

            return response()->json(['message' => 'Erreur serveur'], 500);
        }
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
        try {
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur de validation lors de la création de l\'annonce :', [
                'erreurs' => $e->errors()
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur inattendue lors de la création de l\'annonce : ' . $e->getMessage());

            return response()->json(['message' => 'Erreur serveur'], 500);
        }
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
