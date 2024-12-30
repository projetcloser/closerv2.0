<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cotisation;
use App\Models\Debt;
use App\Models\Member;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CotisationController extends Controller
{
    // Récupérer toutes les cotisations différentes de 1 (open_close)
    public function index()
    {
        $cotisations = Cotisation::where('open_close', '!=', 1)->get();
        return response()->json($cotisations);
    }

    //     private function generateRefIngCost()
    // {
    //     // Exemple simple de génération de référence
    //     $lastId = Cotisation::max('id') + 1;
    //     return 'RC' . str_pad($lastId, 3, '0', STR_PAD_LEFT);
    // }

    // Récupérer une cotisation spécifique

    public function search(Request $request)
    {
        $query = Cotisation::query();

        // Recherche par mot-clé dans certains champs
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('pay_year', 'like', "%$keyword%")
                  ->orWhere('ref_ing_cost', 'like', "%$keyword%")
                  ->orWhere('amount', 'like', "%$keyword%")
                  ->orWhere('pay', 'like', "%$keyword%");
            });
        }

        // Recherche par membre (clé étrangère)
        if ($request->filled('member_id')) {
            $query->where('member_id', $request->input('member_id'));
        }

        // Recherche par cashflow (clé étrangère)
        if ($request->filled('cashflow_id')) {
            $query->where('cashflow_id', $request->input('cashflow_id'));
        }

        // Recherche par statut (optionnel)
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Recherche par état open/close
        if ($request->filled('open_close')) {
            $query->where('open_close', $request->input('open_close'));
        }

        // Charger les relations nécessaires pour les clés étrangères
        $cotisations = $query->with(['member', 'cashflow'])->get();

        return response()->json($cotisations);
    }
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
        try {
            $data = $request->all();

            // Assigner des valeurs par défaut si elles ne sont pas présentes dans la requête
            $data['status'] = $data['status'] ?? 'OK';
            $data['open_close'] = $data['open_close'] ?? 0;

            // // Générer la référence avant la validation
            // $refIngCost = $this->generateRefIngCost();

            // // Injecter `ref_ing_cost` dans les données de la requête
            // $data = $request->all();
            // $data['ref_ing_cost'] = $refIngCost;

            $request->validate([
                'cashflow_id' => 'required|exists:cashflows,id',
                'pay_year' => 'required',
                'ref_ing_cost' => 'required|string|max:255',
                'member_id' => 'required|exists:members,id',
                'amount' => 'required|integer',
                'pay' => 'required|integer',
                'author' => 'required|string|max:255',
                // 'status' => 'sometimes|string|default:OK',
                // 'staff_id' => 'required',
                // 'personnel_id' => 'required|exists:personnels,id',
                // 'open_close' => 'sometimes|boolean|default:0',
            ]);

            $cotisation = Cotisation::create($request->all());

            return response()->json($cotisation, Response::HTTP_CREATED);
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

    // CotisationController.php
    public function verifierCotisationAnnuelle()
    {
        $anneeCourante = now()->year;
        $utilisateurs = Member::all();

        foreach ($utilisateurs as $user) {
            // Vérifie si l'utilisateur a une cotisation pour l'année en cours
            $cotisation = Cotisation::where('member_id', $user->id)
                                    ->where('pay_year', $anneeCourante)
                                    ->first();

            if (!$cotisation || $cotisation->statut === 'non payé') {
                // Vérifie si une dette existe déjà pour cette année
                $dette = Debt::where('member_id', $user->id)
                            ->where('pay_year', $anneeCourante)
                            ->first();

                if ($dette) {
                    // Cumule la dette si elle existe déjà
                    $dette->amount += 60000;
                    $dette->save();
                } else {
                    // Crée une nouvelle dette
                    Debt::create([
                        'member_id' => $user->id,
                        'amount' => 60000,
                        'annee' => $anneeCourante
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Vérification des cotisations terminée.']);
    }


    // Mettre à jour une cotisation spécifique
    public function update(Request $request, $id)
    {
        try {
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
                // 'status' => 'sometimes|string|default:OK',
                // 'personnel_id' => 'sometimes|required|exists:personnels,id',
                'staff_id' => 'sometimes|required|exists:staffs,id',
                // 'open_close' => 'sometimes|boolean|default:0',
            ]);

            $cotisation->update($request->all());

            return response()->json($cotisation);
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
