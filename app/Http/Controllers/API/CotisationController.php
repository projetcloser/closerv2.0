<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cotisation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CotisationController extends Controller
{
    // Récupérer toutes les cotisations différentes de 1 (open_close)
    public function index()
    {
        $cotisations = Cotisation::where('open_close', '!=', 1)->get();
        return response()->json($cotisations);
    }

    // Récupérer une cotisation spécifique
    public function show($id)
    {
        $cotisation = Cotisation::find($id);
        if (!$cotisation || $cotisation->open_close == 1) {
            return response()->json(['message' => 'Cotisation not found or closed'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($cotisation);
    }

    // Créer une nouvelle cotisation
    public function store(Request $request)
    {
        $request->validate([
            'cashflow_id' => 'required|exists:cashflows,id',
            'pay_year' => 'required|date',
            'ref_ing_cost' => 'required|string|max:255',
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|integer',
            'pay' => 'required|integer',
            'author' => 'required|string|max:255',
            'status' => 'sometimes|string|default:OK',
            'personnel_id' => 'required|exists:personnels,id',
            'open_close' => 'sometimes|boolean|default:0',
        ]);

        $cotisation = Cotisation::create($request->all());

        return response()->json($cotisation, Response::HTTP_CREATED);
    }

    // Mettre à jour une cotisation spécifique
    public function update(Request $request, $id)
    {
        $cotisation = Cotisation::find($id);
        if (!$cotisation) {
            return response()->json(['message' => 'Cotisation not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'cashflow_id' => 'sometimes|required|exists:cashflows,id',
            'pay_year' => 'sometimes|required|date',
            'ref_ing_cost' => 'sometimes|required|string|max:255',
            'member_id' => 'sometimes|required||exists:members,id',
            'amount' => 'sometimes|required|integer',
            'pay' => 'sometimes|required|integer',
            'author' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|string|default:OK',
            'personnel_id' => 'sometimes|required|exists:personnels,id',
            'open_close' => 'sometimes|boolean|default:0',
        ]);

        $cotisation->update($request->all());

        return response()->json($cotisation);
    }

    // "Supprimer" une cotisation spécifique (mettre open_close à 1)
    public function destroy($id)
    {
        $cotisation = Cotisation::find($id);
        if (!$cotisation) {
            return response()->json(['message' => 'Cotisation not found'], Response::HTTP_NOT_FOUND);
        }

        $cotisation->update(['open_close' => 1]);

        return response()->json(['message' => 'Cotisation marked as closed']);
    }
}
