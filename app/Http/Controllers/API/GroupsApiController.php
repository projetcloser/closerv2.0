<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::where('open_close', '!=', 1)->get();
        return response()->json($groups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'label' => 'required|string'
            // Ajouter d'autres règles de validation pour les autres champs
        ]);

        $group = Group::create($validatedData);

        return response()->json($group, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $group = Group::where('id', $id)->where('open_close', '!=', 1)->first();

        if (!$group) {
            return response()->json(['message' => 'Group not found or closed'], 404);
        }

        return response()->json($group);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        $validatedData = $request->validate([
            'label' => 'required|string'
            // Ajouter d'autres règles de validation si nécessaire
        ]);

        $group->update($validatedData);

        return response()->json($group);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        $group->update(['open_close' => 1]);

        return response()->json(['message' => 'Group marked as closed']); //
    }
}
