<?php

namespace App\Http\Controllers\API;

use App\Models\CompanyAttestation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompanyAttestationApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $idPerso = $request->query('id_perso');
        $idRole = $request->query('id_role');

        if ($idPerso && $idRole == 1) {

            $companyAttestations = CompanyAttestation::where('member_id', $idPerso)->where('open_close', '!=', 1)->where('status', 1)
                ->get();
            return response()->json($companyAttestations);
        } else {
            $companyAttestations = CompanyAttestation::where('open_close', '!=', 1)->where('status', 1)
                ->get();
            return response()->json($companyAttestations);
        }
    }

    public function GetAttestBuy(Request $request)
    {
        $idPerso = $request->query('id_perso');
        $idRole = $request->query('id_role');

        if ($idPerso && $idRole == 1) {

            $companyAttestations = CompanyAttestation::where('member_id', $idPerso)->where('open_close', '!=', 1)->where('status', 3)
                ->get();
            return response()->json($companyAttestations);
        } else {
            $companyAttestations = CompanyAttestation::where('open_close', '!=', 1)->where('status', 3)
                ->get();
            return response()->json($companyAttestations);
        }
    }

    public function search(Request $request)
    {
        $query = CompanyAttestation::query();

        // Rechercher par mot-clé dans certains champs
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('member_id', 'like', "%$keyword%")
                    ->orWhere('company_id', 'like', "%$keyword%")
                    ->orWhere('motif', 'like', "%$keyword%")
                    ->orWhere('payment_amount', 'like', "%$keyword%");
            });
        }

        // Rechercher par statut (optionnel)
        if ($request->filled('year')) {
            $query->where('year', $request->input('year'));
        }

        // Rechercher par genre (optionnel)
        if ($request->filled('motif')) {
            $query->where('motif', $request->input('motif'));
        }


        // Rechercher par genre (optionnel)
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->input('company_id'));
        }

        // Rechercher par genre (optionnel)
        if ($request->filled('member_id')) {
            $query->where('member_id', $request->input('member_id'));
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
            $companyAttestation = new CompanyAttestation();
            $companyAttestation->member_id = $request->member_id;
            $companyAttestation->payment_amount = $request->payment_amount;
            $companyAttestation->cashflow_id = $request->cashflow_id;
            $companyAttestation->ref_dem_part = $request->ref_dem_part;
            $companyAttestation->year = $request->year;
            $companyAttestation->company_id = $request->company_id;
            $companyAttestation->motif = $request->motif;
            $companyAttestation->author = $request->author;

            $companyAttestation->save();
            return response()->json([
                "message" => "Company Attestation added"
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur de validation lors de la création de l attestation d\'entreprise :', [
                'erreurs' => $e->errors()
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur inattendue lors de la création de l attestation d\'entreprise : ' . $e->getMessage());

            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $companyAttestation = CompanyAttestation::where('id', $id)->where('open_close', '!=', 1)->first();
        if (!empty($companyAttestation)) {
            return response()->json($companyAttestation);
        } else {
            return response()->json([
                "message" => "Company Attestation not foud"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            if (CompanyAttestation::where('id', $id)->where('open_close', '!=', 1)->exists()) {
                $companyAttestation = CompanyAttestation::find($id);
                $companyAttestation->member_id = is_null($request->member_id) ? $companyAttestation->member_id : $request->member_id;
                $companyAttestation->payment_amount = is_null($request->payment_amount) ? $companyAttestation->payment_amount : $request->payment_amount;
                $companyAttestation->ref_dem_part = is_null($request->ref_dem_part) ? $companyAttestation->ref_dem_part : $request->ref_dem_part;
                $companyAttestation->cashflow_id = is_null($request->cashflow_id) ? $companyAttestation->cashflow_id : $request->cashflow_id;
                $companyAttestation->year = is_null($request->year) ? $companyAttestation->year : $request->year;
                $companyAttestation->company_id = is_null($request->company_id) ? $companyAttestation->company_id : $request->company_id;
                $companyAttestation->motif = is_null($request->motif) ? $companyAttestation->motif : $request->motif;
                $companyAttestation->author = is_null($request->author) ? $companyAttestation->author : $request->author;

                $companyAttestation->save();

                return response()->json([
                    "message" => "Company Attestation updated."
                ], 404);
            } else {
                return response()->json([
                    "message" => "Company Attestation not found"
                ], 404);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur de validation lors de la création de l attestation d\'entreprise :', [
                'erreurs' => $e->errors()
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur inattendue lors de la création de l attestation d\'entreprise : ' . $e->getMessage());

            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (CompanyAttestation::where('id', $id)->where('open_close', '!=', 1)->exists()) {
            $companyAttestation = CompanyAttestation::find($id);
            $companyAttestation->open_close = 1;
            $companyAttestation->save();
            return response()->json([
                "message" => "Company Attestation deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Company Attestation not found"
            ], 404);
        }
    }
}
