<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PersonalCertificate;
use Illuminate\Http\Request;
use App\Http\Controllers\API\Response;
use Illuminate\Support\Facades\Log;
class PersonalCertificateController extends Controller
{
    public function index()
    {
        // Affiche uniquement les enregistrements dont open_close != 1
        $certificates = PersonalCertificate::where('open_close', '!=', 1)->get();
        return response()->json($certificates);
    }

    public function show($id)
    {
        // Trouver le certificat personnel par son ID
        $personalCertificate = PersonalCertificate::findOrFail($id);
        if (!$personalCertificate|| $personalCertificate->open_close == 1) {
            return response()->json(['message' => 'Cashflow not found or closed'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($personalCertificate);
    }

    public function store(Request $request)
    {
        try {

            // $validated = $request->validate([
            //     'cashflow_id' => 'required|exists:cashflows,id',
            //     'member_id' => 'required|exists:members,id',
            //     'author' => 'string',
            // ]);

            // $certificate = PersonalCertificate::create($validated);
            // return response()->json([
            //     "message" => "personnel Attestation added"
            // ], 201);



            $personnelAttestation = new PersonalCertificate();
            $personnelAttestation->member_id = $request->member_id;
            // $personnelAttestation->cashflow_id = $request->cashflow_id;
            $personnelAttestation->ref_dem_part = $request->ref_dem_part;
            $personnelAttestation->certification_date = $request->certification_date;
            // $personnelAttestation->year = $request->year;
            $personnelAttestation->object = $request->object;
            $personnelAttestation->author = $request->author;

            $personnelAttestation->save();

            return response()->json([
                'code' => 200,
                'message' => ' création de l\'attestation du personnel',
                'body' => [],
            ]);


        } catch (\Illuminate\Validation\ValidationException $e) {
            // Enregistrer les erreurs de validation dans les logs
            Log::error('Erreur de validation lors de la création du certificat du personnel :', [
                'erreurs' => $e->errors()
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Enregistrer d'autres types d'erreurs dans les logs
            Log::error('Erreur inattendue lors de la création du certificat du personnel : ' . $e->getMessage());

            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $certificate = PersonalCertificate::findOrFail($id);

        $validated = $request->validate([
            'cashflow_id' => 'exists:cashflows,id',
            'member_id' => 'exists:members,id',
            'author' => 'string',
        ]);

        $certificate->update($validated);
        return response()->json($certificate);
    }

    public function destroy($id)
    {
        $certificate = PersonalCertificate::findOrFail($id);
        $certificate->update(['open_close' => 1]);

        return response()->json(['message' => 'Personal Certificate archived']);
    }
}
