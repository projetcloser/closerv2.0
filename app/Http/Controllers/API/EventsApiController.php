<?php

namespace App\Http\Controllers\API;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class EventsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('open_close', '!=', 1)->paginate(10);
        return response()->json($events);
    }

    public function search(Request $request)
    {
        $query = Event::query();

        // Rechercher par mot-clé dans certains champs
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%$keyword%")
                ->orWhere('place', 'like', "%$keyword%")
                ->orWhere('participants', 'like', "%$keyword%")
                ->orWhere('price', 'like', "%$keyword%")
                ->orWhere('end_date', 'like', "%$keyword%")
                ->orWhere('author', 'like', "%$keyword%");
            });
        }


        $event = $query->get();

        return response()->json($event);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'place' => 'required|string',
                // 'participants' => 'required|string',
                'price' => 'required|int',
                'start_date' => 'required|string',
                'end_date' => 'required|string',
                'author' => 'required|string',
                // Ajouter d'autres règles de validation pour les autres champs
            ]);

            $event = Event::create($validatedData);

            return response()->json($event, 201);
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Enregistrer les erreurs de validation dans les logs
                Log::error('Erreur de validation lors de la création de la cotisation :', [
                    'erreurs' => $e->errors()
                ]);

                return response()->json(['errors' => $e->errors()], 422);
            } catch (\Exception $e) {
                // Enregistrer d'autres types d'erreurs dans les logs
                Log::error('Erreur inattendue lors de la création de la cotisation : ' . $e->getMessage());

                return response()->json(['message' => 'Erreur serveur'], 500);
            }
    }

        public function incrementParticipant($id)
    {
        try {

            $userId = auth()->id(); // Récupérer l'ID de l'utilisateur connecté
            $event = Event::findOrFail($id);

            // Vérifier si l'utilisateur a déjà participé
            $alreadyParticipated = DB::table('event_participants')
                ->where('event_id', $id)
                ->where('user_id', $userId)
                ->exists();

            if ($alreadyParticipated) {
                return response()->json(['message' => 'Vous avez déjà participé.'], 403);
            }

            $evenement = Event::findOrFail($id);
            $evenement->participants += 1;
            $evenement->save();

              // Enregistrer la participation
            DB::table('event_participants')->insert([
                'event_id' => $id,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        return response()->json($evenement, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur d\'incrementation :', [
                'erreurs' => $e->errors()
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur d\'incrementation: ' . $e->getMessage());

            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

        public function decrementParticipant($id)
    {
        try {
            $evenement = Event::findOrFail($id);
            $userId = auth()->id(); // Récupère l'utilisateur connecté

            // Vérifie si l'utilisateur a participé
            $alreadyParticipated = DB::table('event_participants')
                ->where('event_id', $id)
                ->where('user_id', $userId)
                ->exists();

            if (!$alreadyParticipated) {
                return response()->json(['message' => 'Vous ne participez pas à cet événement'], 403);
            }

             // Vérifie que les participants ne soient pas négatifs
            if ($evenement->participants <= 0) {
                return response()->json(['message' => 'Impossible de retirer la participation. Aucun participant.'], 400);
            }

            $evenement->participants -= 1;
            $evenement->save();

             // Supprime la participation de l'utilisateur
            DB::table('event_participants')
            ->where('event_id', $id)
            ->where('user_id', $userId)
            ->delete();

            return response()->json($evenement, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur de non participation :', [
                'erreurs' => $e->errors()
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur de non participation  : ' . $e->getMessage());

            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $events = Event::whereId($id)->where('open_close', '!=', 1)->first();
        if (!empty($events)) {
            return response()->json($events);
        } else {
            return response()->json([
                "message" => "Event not foud"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if (!empty($event)) {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'place' => 'required|string',
                'participants' => 'required|string',
                'price' => 'required|int',
                'start_date' => 'required|string',
                'end_date' => 'required|string',
                'author' => 'required|string',
                // Ajouter d'autres règles de validation si nécessaire
            ]);

            $event->update($validatedData);

            return response()->json([
                "message" => "Event updated."
            ], 201);
        } else {
            return response()->json([
                "message" => "Event not found"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Event::whereId($id)->where('open_close', '!=', 1)->exists()) {
            $company = Event::find($id);
            $company->open_close = 1;
            $company->save();
            return response()->json([
                "message" => "Event deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Event not found"
            ], 404);
        }
    }
}
