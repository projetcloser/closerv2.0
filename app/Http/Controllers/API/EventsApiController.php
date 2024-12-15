<?php

namespace App\Http\Controllers\API;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('open_close', '!=', 1)->get();
        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'place' => 'required|string',
            'participants' => 'required|string',
            'price' => 'required|int',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'author' => 'required|string',
            // Ajouter d'autres règles de validation pour les autres champs
        ]);

        $event = Event::create($validatedData);

        return response()->json($event, 201);
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
