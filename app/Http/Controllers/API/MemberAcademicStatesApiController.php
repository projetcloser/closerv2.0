<?php

namespace App\Http\Controllers\API;

use App\Models\MemberAcademicState;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberAcademicStatesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicStates = MemberAcademicState::where('open_close', '!=', 1)->get();
        return response()->json($academicStates);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $academicState = new MemberAcademicState();
        $academicState->member_id = $request->member_id;
        $academicState->lastname = $request->lastname;
        $academicState->firstname = $request->firstname;
        $academicState->username = $request->username;
        $academicState->email = $request->email;
        $academicState->birthday = $request->birthday;
        $academicState->gender = $request->gender;
        $academicState->address = $request->address;
        $academicState->country_id = $request->country_id;
        $academicState->city_id = $request->city_id;
        $academicState->neighborhood = $request->neighborhood;
        $academicState->phone = $request->phone;
        $academicState->biography = $request->biography;
        $academicState->avatar64 = $request->avatar64;

        $academicState->save();
        return response()->json([
            "message" => "Member Academic State added"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $academicState = MemberAcademicState::where('id', $id)->where('open_close', '!=', 1)->first();
        if (!empty($academicState)) {
            return response()->json($academicState);
        } else {
            return response()->json([
                "message" => "Member Academic State not found"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (MemberAcademicState::where('id', $id)->where('open_close', '!=', 1)->exists()) {
            $academicState = MemberAcademicState::find($id);
            $academicState->member_id = is_null($request->member_id) ? $academicState->member_id : $request->member_id;
            $academicState->lastname = is_null($request->lastname) ? $academicState->lastname : $request->lastname;
            $academicState->firstname = is_null($request->firstname) ? $academicState->firstname : $request->firstname;
            $academicState->username = is_null($request->username) ? $academicState->username : $request->username;
            $academicState->email = is_null($request->email) ? $academicState->email : $request->email;
            $academicState->birthday = is_null($request->birthday) ? $academicState->birthday : $request->birthday;
            $academicState->gender = is_null($request->gender) ? $academicState->gender : $request->gender;
            $academicState->address = is_null($request->address) ? $academicState->address : $request->address;
            $academicState->country_id = is_null($request->country_id) ? $academicState->country_id : $request->country_id;
            $academicState->city_id = is_null($request->city_id) ? $academicState->city_id : $request->city_id;
            $academicState->neighborhood = is_null($request->neighborhood) ? $academicState->neighborhood : $request->neighborhood;
            $academicState->phone = is_null($request->phone) ? $academicState->phone : $request->phone;
            $academicState->biography = is_null($request->biography) ? $academicState->biography : $request->biography;
            $academicState->avatar64 = is_null($request->avatar64) ? $academicState->avatar64 : $request->avatar64;

            $academicState->save();

            return response()->json([
                "message" => "Member Academic State updated."
            ], 404);
        } else {
            return response()->json([
                "message" => "Member Academic State not found"
            ], 404);
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (MemberAcademicState::where('id', $id)->where('open_close', '!=', 1)->exists()) {
            $academicState = MemberAcademicState::find($id);
            $academicState->open_close = 1;
            $academicState->save();
            return response()->json([
                "message" => "Member Academic State deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Member Academic State not found"
            ], 404);
        }
    }
}
