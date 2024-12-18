<?php

namespace App\Http\Controllers\API;

use App\Models\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\API\Storage;

use function Psy\debug;

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




    public function search(Request $request)
    {
        $query = Member::query();

        // Rechercher par mot-clé dans certains champs
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('lastname', 'like', "%$keyword%")
                ->orWhere('firstname', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%")
                ->orWhere('matricule', 'like', "%$keyword%")
                ->orWhere('phone', 'like', "%$keyword%")
                ->orWhere('phone_2', 'like', "%$keyword%");
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $member = new Member();

            // Initialiser les variables de fichiers avec une valeur par défaut
            // $fileName = null;
            // $fileName2 = null;

            // if ($request->hasFile('folder')) {
            //     $file = $request->file('folder');
            //     $fileName = time() . '.' . $file->getClientOriginalExtension();
            //     $file->move('assets', $fileName);
            //     $member->folder = $fileName;
            // }

            // if ($request->hasFile('picture')) {
            //     $file2 = $request->file('picture');
            //     $fileName2 = time() . '.' . $file2->getClientOriginalExtension();
            //     $file2->move('assets', $fileName2);
            //     $member->picture = $fileName2;
            // }

            // Handle picture upload

            $picturePath = null;

            if ($request->hasFile('picture')) {
                $picturePath = $request->file('picture')->store('members/pictures', 'public');
                // $validated['picture'] = $picturePath;
            }

            // Handle folder files
            $folderPaths = null;
            if ($request->hasFile('folder')) {
                foreach ($request->file('folder') as $file) {
                    $folderPaths = $file->store('members/files', 'public');
                }
                // $validated['folder'] = json_encode($folderPaths);
            }


            $member->matricule = $request->matricule;
            $member->lastname = $request->lastname;
            $member->firstname = $request->firstname;
            $member->gender = $request->gender;
            $member->email = $request->email;
            $member->city_id = $request->city_id;
            $member->order_number = $request->order_number;
            $member->phone = $request->phone;
            $member->phone_2 = $request->phone_2;
            // $member->folder = $request->folder;
            // $member->picture = $request->picture;
            $member->author = $request->author;
            $member->group_id = $request->group_id;
            $member->folder = $folderPaths;
            $member->picture = $picturePath;


            $member->save();
            $validated = $request;
            if($validated){

                  return response()->json([
                    'code' => 200,
                    'message' => ' création du membre',
                    'body' => [],
                ]);

            }else{
                return redirect()->back()->with('success', 'membre non enregistrer.');
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur de validation lors de la création du membre :', [
                'erreurs' => $e->errors()
            ]);

            // return response()->json(['errors' => $e->errors()], 422);
            return response()->json([
                'code' => 402,
                'message' => 'Erreur de validation lors de la création du membre',
                'body' => [],
            ]);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur inattendue lors de la création du membre: ' . $e->getMessage());

            // return response()->json(['message' => 'Erreur serveur'], 500);
            return response()->json([
                'code' => 500,
                'message' => 'erreur seveur',
                'body' => [],
            ]);
        }
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
            // Storage::delete(['public/' . $member->picture, 'public/' . $member->folder]);
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
