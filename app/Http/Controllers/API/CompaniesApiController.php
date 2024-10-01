<?php

namespace App\Http\Controllers\API;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompaniesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::where('status', '<>', 0)->get();
        return response()->json($companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $company = new Company();
        $company->social_reason = $request->company_name;
        $company->author = $request->author;
        $company->type = $request->company_type;
        $company->email = $request->email;
        $company->nui = $request->nui;
        $company->country_id = $request->country_id;
        $company->city_id = $request->city_id;
        $company->phone = $request->phone;
        $company->contact_person = $request->contact_person;
        $company->contact_person_phone = $request->contact_person_phone;
        $company->neighborhood = $request->neighborhood;
        $company->company_type = $request->company_type;

        $company->save();

        return response()->json([
            "message" => "Company added"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = Company::where('id', $id)->where('status', '<>', 0)->first();
        if (!empty($company)) {
            return response()->json($company);
        } else {
            return response()->json([
                "message" => "Compny not foud"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Company::where('id', $id)->where('status', '<>', 0)->exists()) {
            $company = Company::find($id);
            $company->social_reason = is_null($request->company_name) ? $company->social_reason : $request->company_name;
            $company->author = is_null($request->author) ? $company->author : $request->author;
            $company->type = is_null($request->company_type) ? $company->type : $request->company_type;
            $company->email = is_null($request->email) ? $company->email : $request->email;
            $company->nui = is_null($request->nui) ? $company->nui : $request->nui;
            $company->country_id = is_null($request->country_id) ? $company->country_id : $request->country_id;
            $company->city_id = is_null($request->city_id) ? $company->city_id : $request->city_id;
            $company->phone = is_null($request->phone) ? $company->phone : $request->phone;
            $company->contact_person = is_null($request->contact_person) ? $company->contact_person : $request->contact_person;
            $company->contact_person_phone = is_null($request->contact_person_phone) ? $company->contact_person_phone : $request->contact_person_phone;
            $company->neighborhood = is_null($request->neighborhood) ? $company->neighborhood : $request->neighborhood;
            $company->company_type = is_null($request->company_type) ? $company->company_type : $request->company_type;

            $company->save();

            return response()->json([
                "message" => "Company updated."
            ], 404);
        } else {
            return response()->json([
                "message" => "Company not found"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Company::where('id', $id)->where('status', '<>', 0)->exists()) {
            $company = Company::find($id);
            $company->status = 0;
            $company->save();
            return response()->json([
                "message" => "Company deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Company not found"
            ], 404);
        }
    }
}
