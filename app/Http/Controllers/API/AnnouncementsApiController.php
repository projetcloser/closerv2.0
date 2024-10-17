<?php

namespace App\Http\Controllers\API;

use App\Models\Announcement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::where('open_close', '!=', 1)->get();
        return response()->json($announcements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'object' => 'required|string',
            'body' => 'required|string',
            'author' => 'required|string'
            // Ajouter d'autres règles de validation pour les autres champs
        ]);

        $announcement = Announcement::create($validatedData);

        return response()->json($announcement, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $announcement = Announcement::where('id', $id)->where('open_close', '!=', 1)->first();

        if (!$announcement) {
            return response()->json(['message' => 'Announcement not found or closed'], 404);
        }

        return response()->json($announcement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json(['message' => 'Announcement not found'], 404);
        }

        $validatedData = $request->validate([
            'object' => 'required|string',
            'body' => 'required|string',
            'author' => 'required|string'
            // Ajouter d'autres règles de validation si nécessaire
        ]);

        $announcement->update($validatedData);

        return response()->json($announcement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json(['message' => 'Annonce not found'], 404);
        }

        $announcement->update(['open_close' => 1]);

        return response()->json(['message' => 'Annonce marked as closed']);
    }
}
