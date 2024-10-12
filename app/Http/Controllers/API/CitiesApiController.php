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
