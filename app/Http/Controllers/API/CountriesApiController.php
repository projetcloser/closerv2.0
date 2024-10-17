<?php

namespace App\Http\Controllers\API;

use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CountriesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::where('open_close', '!=', 1)->get();
        return response()->json($countries);
    }


    /**
     * Display a listing of cities from a country.
     */
    public function showCities($id)
    {
        $cities = City::where('open_close', '!=', 1)->where('country_id', $id)->get();
        return response()->json($cities);
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
    public function show(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        //
    }
}
