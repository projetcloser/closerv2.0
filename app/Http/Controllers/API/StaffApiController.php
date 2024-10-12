<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffApiController extends Controller
{
    // Afficher la liste des personnels où open_close != 1
    public function index()
    {
        $personnels = Staff::where('open_close', '!=', 1)->get();
        return response()->json($personnels);
    }

    // Afficher un personnel spécifique où open_close != 1
    public function show($id)
    {
        $personnel = Staff::where('id', $id)->where('open_close', '!=', 1)->first();

        if (!$personnel) {
            return response()->json(['message' => 'Personnel not found or closed'], 404);
        }

        return response()->json($personnel);
    }

    // Créer un nouveau personnel
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'statut' => 'required|string',
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'email' => 'required|email|unique:personnels',
            'phone' => 'required|string',
            // Ajouter d'autres règles de validation pour les autres champs
        ]);

        $personnel = Staff::create($validatedData);

        return response()->json($personnel, 201);
    }

    // Mettre à jour un personnel
    public function update(Request $request, $id)
    {
        $personnel = Staff::find($id);

        if (!$personnel) {
            return response()->json(['message' => 'Personnel not found'], 404);
        }

        $validatedData = $request->validate([
            'statut' => 'sometimes|string',
            'lastname' => 'sometimes|string',
            'firstname' => 'sometimes|string',
            'email' => 'sometimes|email|unique:personnels,email,' . $personnel->id,
            'phone' => 'sometimes|string',
            // Ajouter d'autres règles de validation si nécessaire
        ]);

        $personnel->update($validatedData);

        return response()->json($personnel);
    }

    // "Supprimer" un personnel en mettant à jour le champ open_close à 1
    public function destroy($id)
    {
        $personnel = Staff::find($id);

        if (!$personnel) {
            return response()->json(['message' => 'Personnel not found'], 404);
        }

        $personnel->update(['open_close' => 1]);

        return response()->json(['message' => 'Personnel marked as closed']);
    }
}
