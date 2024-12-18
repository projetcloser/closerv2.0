<?php

namespace App\Http\Controllers\API;

use App\Models\Announcement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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
        try {
            // Log::info('Début de la méthode store.');
            $validatedData = $request->validate([
                'object' => 'required|string',
                'body' => 'required|string',
                'author' => 'required|string',
                // Ajouter d'autres règles de validation pour les autres champs
                'fichiers.*' => 'file|mimes:pdf,jpg,png|max:2048',
            ]);



            $fichiers = [];
            if ($request->hasFile('fichiers')) {
                foreach ($request->file('fichiers') as $fichier) {
                    $path = $fichier->store('annonces'); // Enregistre dans storage/app/annonces
                    $fichiers[] = $path;
                }
            }

            $announcement = Announcement::create($validatedData);

            return response()->json($announcement, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur de validation lors de la création de l\'annonce :', [
                'erreurs' => $e->errors()
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur inattendue lors de la création de l\'annonce : ' . $e->getMessage());

            return response()->json(['message' => 'Erreur serveur'], 500);
        }
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
