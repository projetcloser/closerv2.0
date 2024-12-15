<?php

namespace App\Http\Controllers\API;

use App\Models\CompanyAttestation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyAttestationApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyAttestations = CompanyAttestation::where('open_close', '!=', 1)->get();
        return response()->json($companyAttestations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $companyAttestation = new CompanyAttestation();
        $companyAttestation->member_id = $request->member_id;
        $companyAttestation->payment_amount = $request->payment_amount;
        $companyAttestation->cash_register_id = $request->cash_register_id;
        $companyAttestation->year = $request->year;
        $companyAttestation->company_id = $request->company_id;
        $companyAttestation->motif = $request->motif;

        $companyAttestation->save();
        return response()->json([
            "message" => "Company Attestation added"
        ], 201);
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
        if (CompanyAttestation::where('id', $id)->where('open_close', '!=', 1)->exists()) {
            $companyAttestation = CompanyAttestation::find($id);
            $companyAttestation->member_id = is_null($request->member_id) ? $companyAttestation->member_id : $request->member_id;
            $companyAttestation->payment_amount = is_null($request->payment_amount) ? $companyAttestation->payment_amount : $request->payment_amount;
            $companyAttestation->cash_register_id = is_null($request->cash_register_id) ? $companyAttestation->cash_register_id : $request->cash_register_id;
            $companyAttestation->year = is_null($request->year) ? $companyAttestation->year : $request->year;
            $companyAttestation->company_id = is_null($request->company_id) ? $companyAttestation->company_id : $request->company_id;
            $companyAttestation->motif = is_null($request->motif) ? $companyAttestation->motif : $request->motif;

            $companyAttestation->save();

            return response()->json([
                "message" => "Company Attestation updated."
            ], 404);
        } else {
            return response()->json([
                "message" => "Company Attestation not found"
            ], 404);
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
