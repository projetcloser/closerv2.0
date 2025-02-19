<?php

namespace App\Http\Controllers\API;

use App\Models\Stamp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StampApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $idPerso = $request->query('id_perso');
        $idRole = $request->query('id_role');

        if ($idPerso && $idRole == 1) {
            $stamps = Stamp::where('member_id', $idPerso)->where('open_close', '!=', 1)->get();
            return response()->json($stamps);
        } else {
            $stamps = Stamp::where('open_close', '!=', 1)->get();
            return response()->json($stamps);
        }
    }

    public function search(Request $request)
    {
        $query = Stamp::query();

        // Rechercher par mot-clé dans certains champs
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('author', 'like', "%$keyword%")
                    ->orWhere('phone', 'like', "%$keyword%")
                    ->orWhere('year', 'like', "%$keyword%")
                    ->orWhere('receipt_number', 'like', "%$keyword%")
                    ->orWhere('member_id', 'like', "%$keyword%")
                    ->orWhere('city_id', 'like', "%$keyword%");
            });
        }

        // Rechercher par statut (optionnel)
        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
        }

        // Rechercher par genre (optionnel)
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
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
            $stamp = new Stamp();
            $stamp->member_id = $request->member_id;
            $stamp->receipt_number = $request->receipt_number;
            $stamp->status = $request->status;
            $stamp->author = $request->author;
            $stamp->city_id = $request->city_id;
            $stamp->phone = $request->phone;
            $stamp->year = $request->year;

            $stamp->save();
            return response()->json([
                "message" => "Stamp added"
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur de validation lors de la création de la cotisation :', [
                'erreurs' => $e->errors()
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur inattendue lors de la création de la cotisation : ' . $e->getMessage());

            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stamp = Stamp::where('id', $id)->where('open_close', '!=', 1)->first();
        if (!empty($stamp)) {
            return response()->json($stamp);
        } else {
            return response()->json([
                "message" => "Stamp not foud"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            if (Stamp::where('id', $id)->where('open_close', '!=', 1)->exists()) {
                $stamp = Stamp::find($id);
                $stamp->receipt_number = is_null($request->receipt_number) ? $stamp->receipt_number : $request->receipt_number;
                // $stamp->step = is_null($request->step) ? $stamp->step : $request->step;
                $stamp->author = is_null($request->author) ? $stamp->author : $request->author;
                $stamp->city_id = is_null($request->city_id) ? $stamp->city_id : $request->city_id;
                $stamp->phone = is_null($request->phone) ? $stamp->phone : $request->phone;
                $stamp->year = is_null($request->year) ? $stamp->year : $request->year;

                $stamp->save();

                return response()->json([
                    "message" => "Stamp updated."
                ], 404);
            } else {
                return response()->json([
                    "message" => "Stamp not found"
                ], 404);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur de validation lors de la création de la cotisation :', [
                'erreurs' => $e->errors()
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur inattendue lors de la création de la cotisation : ' . $e->getMessage());

            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Stamp::where('id', $id)->where('open_close', '!=', 1)->exists()) {
            $stamp = Stamp::find($id);
            $stamp->open_close = 1;
            $stamp->save();

            return response()->json([
                "message" => "Stamp deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Stamp not found"
            ], 404);
        }
    }
}
