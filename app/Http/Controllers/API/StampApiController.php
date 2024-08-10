<?php

namespace App\Http\Controllers\API;

use App\Models\Stamp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StampApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stamps = Stamp::where('status', '<>', 0)->get();
        return response()->json($stamps);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $stamp = new Stamp();
        $stamp->member_id = $request->member_id;
        $stamp->receipt_number = $request->receipt_number;
        $stamp->step = $request->step;
        $stamp->author = $request->author;
        $stamp->city_id = $request->city_id;
        $stamp->phone = $request->phone;
        $stamp->year = $request->year;

        $stamp->save();
        return response()->json([
            "message" => "Stamp added"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stamp = Stamp::where('id', $id)->where('status', '<>', 0)->first();
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
        if (Stamp::where('id', $id)->where('status', '<>', 0)->exists()) {
            $stamp = Stamp::find($id);
            $stamp->receipt_number = is_null($request->receipt_number) ? $stamp->matricule : $request->receipt_number;
            $stamp->step = is_null($request->step) ? $stamp->step : $request->step;
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Stamp::where('id', $id)->where('status', '<>', 0)->exists()) {
            $stamp = Stamp::find($id);
            $stamp->status = 0;
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
