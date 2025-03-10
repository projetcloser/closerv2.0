<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cashflow;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CashflowController extends Controller
{
    // Récupérer tous les cashflows différents de 1 (open_close)
    public function index()
    {
        $cashflows = Cashflow::where('open_close', '!=', 1)->get();
        return response()->json($cashflows);
    }

    public function search(Request $request)
    {
        $query = Cashflow::query();

        // Rechercher par mot-clé dans certains champs
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('code', 'like', "%$keyword%")
                ->orWhere('name', 'like', "%$keyword%")
                ->orWhere('balance', 'like', "%$keyword%");
                // ->orWhere('phone', 'like', "%$keyword%")
                // ->orWhere('contact_person', 'like', "%$keyword%")
                // ->orWhere('contact_person_phone', 'like', "%$keyword%");
            });
        }
      // Ajouter d'autres filtres si nécessaire
        // ...

        $staff = $query->get();

        return response()->json($staff);
    }

    // Récupérer un cashflow spécifique
    public function show($id)
    {
        $cashflow = Cashflow::find($id);
        if (!$cashflow || $cashflow->open_close == 1) {
            return response()->json(['message' => 'Cashflow not found or closed'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($cashflow);
    }

    // Créer un nouveau cashflow
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'staff_id' => 'required',
            'balance' => 'required|integer'
        ]);

        $cashflow = Cashflow::create($request->all());

        return response()->json($cashflow, Response::HTTP_CREATED);
    }

    // Mettre à jour un cashflow spécifique
    public function update(Request $request, $id)
    {
        $cashflow = Cashflow::find($id);
        if (!$cashflow) {
            return response()->json(['message' => 'Cashflow not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'code' => 'sometimes|required|string|max:255',
            'name' => 'sometimes|required|string|max:255',
            'staff_id' => 'sometimes|required',
            'balance' => 'sometimes|required|integer'
        ]);

        $cashflow->update($request->all());

        return response()->json($cashflow);
    }

    // "Supprimer" un cashflow spécifique (mettre open_close à 1)
    public function destroy($id)
    {
        $cashflow = Cashflow::find($id);
        if (!$cashflow) {
            return response()->json(['message' => 'Cashflow not found'], Response::HTTP_NOT_FOUND);
        }

        $cashflow->update(['open_close' => 1]);

        return response()->json(['message' => 'Cashflow marked as closed']);
    }
}
