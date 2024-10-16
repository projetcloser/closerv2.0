<?php

namespace App\Http\Controllers\API;

use App\Models\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembersApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::where('open_close', '!=', 1)->get();
        return response()->json($members);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $member = new Member();
        $member->matricule = $request->matricule;
        $member->lastname = $request->lastname;
        $member->firstname = $request->firstname;
        $member->gender = $request->gender;
        $member->email = $request->email;
        $member->city_id = $request->city_id;
        $member->order_number = $request->order_number;
        $member->phone = $request->phone;
        $member->phone_2 = $request->phone_2;
        $member->folder = $request->folder;
        $member->picture = $request->picture;
        $member->debt = $request->debt;
        $member->group_id = $request->group_id;

        $member->save();
        return response()->json([
            "message" => "Member added"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $member = Member::where('id', $id)->where('open_close', '!=', 1)->first();
        if (!empty($member)) {
            return response()->json($member);
        } else {
            return response()->json([
                "message" => "Member not foud"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (Member::where('id', $id)->where('open_close', '!=', 1)->exists()) {
            $member = Member::find($id);
            $member->matricule = is_null($request->matricule) ? $member->matricule : $request->matricule;
            $member->lastname = is_null($request->lastname) ? $member->lastname : $request->lastname;
            $member->firstname = is_null($request->firstname) ? $member->firstname : $request->firstname;
            $member->gender = is_null($request->gender) ? $member->gender : $request->gender;
            $member->email = is_null($request->email) ? $member->email : $request->email;
            $member->city_id = is_null($request->city_id) ? $member->city_id : $request->city_id;
            $member->order_number = is_null($request->order_number) ? $member->order_number : $request->order_number;
            $member->phone = is_null($request->phone) ? $member->phone : $request->phone;
            $member->phone_2 = is_null($request->phone_2) ? $member->phone_2 : $request->phone_2;
            $member->folder = is_null($request->folder) ? $member->folder : $request->folder;
            $member->picture = is_null($request->picture) ? $member->picture : $request->picture;
            $member->debt = is_null($request->debt) ? $member->debt : $request->debt;
            $member->group_id = is_null($request->group_id) ? $member->group_id : $request->group_id;

            $member->save();

            return response()->json([
                "message" => "Member updated."
            ], 404);
        } else {
            return response()->json([
                "message" => "Member not found"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Member::where('id', $id)->where('open_close', '!=', 1)->exists()) {
            $member = Member::find($id);
            $member->open_close = 1;
            $member->save();
            return response()->json([
                "message" => "Member deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Member not found"
            ], 404);
        }
    }
}
