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
        $companies = Company::where('open_close', '!=', 1)->get();
        return response()->json($companies);
    }

    public function search(Request $request)
    {
        $query = Company::query();

        // Rechercher par mot-clé dans certains champs
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('social_reason', 'like', "%$keyword%")
                ->orWhere('author', 'like', "%$keyword%")
                ->orWhere('company_type', 'like', "%$keyword%")
                ->orWhere('phone', 'like', "%$keyword%")
                ->orWhere('contact_person', 'like', "%$keyword%")
                ->orWhere('contact_person_phone', 'like', "%$keyword%");
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
        $company = new Company();
        // $company->social_reason = $request->company_name;
        $company->social_reason = $request->social_reason;
        $company->author = $request->author;
        $company->company_categorie = $request->company_categorie;
        $company->company_type = $request->company_type;
        $company->email = $request->email;
        $company->nui = $request->nui;
        $company->country_id = $request->country_id;
        $company->city_id = $request->city_id;
        $company->phone = $request->phone;
        $company->contact_person = $request->contact_person;
        $company->contact_person_phone = $request->contact_person_phone;
        $company->neighborhood = $request->neighborhood;
        // $company->company_type = $request->company_type;

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
        $company = Company::where('id', $id)->where('open_close', '!=', 1)->first();
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
        if (Company::where('id', $id)->where('open_close', '!=', 1)->exists()) {
            $company = Company::find($id);
            $company->social_reason = is_null($request->social_reason) ? $company->social_reason : $request->social_reason;
            $company->author = is_null($request->author) ? $company->author : $request->author;
            $company->company_type = is_null($request->company_type) ? $company->company_type : $request->company_type;
            $company->company_categorie = is_null($request->company_categorie) ? $company->company_categorie : $request->company_categorie;
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
            ], 201);
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
        if (Company::where('id', $id)->where('open_close', '!=', 1)->exists()) {
            $company = Company::find($id);
            $company->open_close = 1;
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
