<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PersonalCertificate;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'cashflow_id' => 'required|exists:cashflows,id',
            'member_id' => 'required|exists:members,id',
            'personnel_id' => 'required|exists:personnels,id',
            'author' => 'string',
        ]);

        $certificate = PersonalCertificate::create($validated);
        return response()->json($certificate, 201);
    }

    public function update(Request $request, $id)
    {
        $certificate = PersonalCertificate::findOrFail($id);

        $validated = $request->validate([
            'cashflow_id' => 'exists:cashflows,id',
            'member_id' => 'exists:members,id',
            'personnel_id' => 'exists:personnels,id',
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
