<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class StaffApiController extends Controller
{
    // Afficher la liste des personnels où open_close != 1
    public function index()
    {
        $personnels = Staff::where('open_close', '!=', 1)->paginate(10);
        return response()->json($personnels);
    }




public function search(Request $request)
{
    $query = Staff::query();

    // Rechercher par mot-clé dans certains champs
    if ($request->filled('keyword')) {
        $keyword = $request->input('keyword');
        $query->where(function ($q) use ($keyword) {
            $q->where('lastname', 'like', "%$keyword%")
              ->orWhere('firstname', 'like', "%$keyword%")
              ->orWhere('email', 'like', "%$keyword%")
              ->orWhere('phone', 'like', "%$keyword%");
        });
    }

    // Rechercher par statut (optionnel)
    if ($request->filled('statut')) {
        $query->where('statut', $request->input('statut'));
    }

    // Rechercher par genre (optionnel)
    if ($request->filled('gender')) {
        $query->where('gender', $request->input('gender'));
    }

    // Ajouter d'autres filtres si nécessaire
    // ...

    $staff = $query->get();

    return response()->json($staff);
}


    // Afficher un personnel spécifique où open_close != 1
    public function show($id)
    {
        $personnel = Staff::where('id', $id)->where('open_close', '!=', 1)->first();

        if (!$personnel) {
            return response()->json(['message' => 'Personnel not found or closed'], 404);
        }

        return response()->json($personnel);
    }

    // Créer un nouveau personnel
    public function store(Request $request)
    {
        try {
            $Staff = new Staff();
            // if($request->hasFile('attachment_file')){
            //     // recuperer l'image
            // $getImage = $request->getSchemeAndHttpHost(). '/assets/img' .time().'.'.$request->path->extension();
            // $request->path->move(public_path('/assets/'),$getImage);
            // }
            $Staff->lastname = $request->lastname;
            $Staff->firstname = $request->firstname;
            $Staff->email = $request->email;
            $Staff->date_card_validity = $request->date_card_validity;
            $Staff->phone = $request->phone;
            $Staff->phone_2 = $request->phone_2;
            $Staff->father_name = $request->father_name;
            $Staff->mother_name = $request->mother_name;
            $Staff->birthday = $request->birthday;
            $Staff->place_birth = $request->place_birth;
            $Staff->profession = $request->position;
            $Staff->gender = $request->gender;
            $Staff->contract_type = $request->contract_type;
            $Staff->marital_status = $request->marital_status;
            $Staff->position = $request->position;
            $Staff->num_children = $request->num_children;
            $Staff->city_id = $request->city_id;
            $Staff->country_id = $request->country_id;
            $Staff->author = $request->author;
            $Staff->position = $request->position;
            // $Staff->attachment_file = $getImage;

            //  Gestion de l'upload du fichier
             if ($request->hasFile('attachment_file')) {
                $filePath = $request->file('attachment_file')->store('attachments', 'public');
                $validatedData['attachment_file'] = $filePath;
            }


            $Staff->save();
            $validated = $request;
            if($validated){
                // return response()->json($profile, 201);
                  // return response()->json(['errors' => $e->errors()], 422);
                  return response()->json([
                    'code' => 200,
                    'message' => ' création du personnel',
                    'body' => [],
                ]);

            }else{
                return redirect()->back()->with('success', 'personnel non enregistrer.');
            }
            // $personnel = Staff::create($validatedData);

            // return response()->json($personnel, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur de validation lors de la création du personnel :', [
                'erreurs' => $e->errors()
            ]);

            Log::info('Données reçues dans la requête :', $request->all());
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur inattendue lors de la création du personnel : ' . $e->getMessage());
            Log::info('Données reçues dans la requête :', $request->all());

            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    // Mettre à jour un personnel
    public function update(Request $request, $id)
    {
        try {
            $personnel = Staff::find($id);

            if (!$personnel) {
                return response()->json(['message' => 'Personnel not found'], 404);
            }

            $validatedData = $request->validate([
                'statut' => 'sometimes',
                'lastname' => 'sometimes|string',
                'firstname' => 'sometimes|string',
                'email' => 'sometimes|email|unique:personnels,email,' . $personnel->id,
                'phone' => 'sometimes|string',
                // Ajouter d'autres règles de validation si nécessaire
            ]);

            $personnel->update($validatedData);

            return response()->json($personnel);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur de validation lors de la création de l attestation d\'entreprise :', [
                'erreurs' => $e->errors()
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur inattendue lors de la création de l attestation d\'entreprise : ' . $e->getMessage());

            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    // "Supprimer" un personnel en mettant à jour le champ open_close à 1
    public function destroy($id)
    {
        $personnel = Staff::find($id);

        if (!$personnel) {
            return response()->json(['message' => 'Personnel not found'], 404);
        }

        $personnel->update(['open_close' => 1]);

        return response()->json(['message' => 'Personnel marked as closed']);
    }
}
