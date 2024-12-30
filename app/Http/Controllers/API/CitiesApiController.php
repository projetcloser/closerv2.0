<?php

namespace App\Http\Controllers\API;

use App\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CitiesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::where('open_close', '!=', 1)->get();
        return response()->json($cities);
    }

    public function search(Request $request)
    {
        $query = City::query();

        // Rechercher par mot-clé dans certains champs
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%");
                // ->orWhere('author', 'like', "%$keyword%")
                // ->orWhere('company_type', 'like', "%$keyword%")
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


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
    }
}
