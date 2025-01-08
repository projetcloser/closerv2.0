<?php

namespace App\Http\Controllers\API;

use App\Models\Debt;
use App\Http\Controllers\Controller;
use App\Models\Cotisation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DebtsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $debts = Debt::where('open_close', '!=', 1)->get();
        return response()->json($debts);
    }

    public function getUserDette(){
        
    }

    public function search(Request $request)
    {
        $query = Debt::query();

        // Rechercher par mot-clé dans certains champs
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('ref_ing_cost', 'like', "%$keyword%")
                ->orWhere('amount', 'like', "%$keyword%")
                ->orWhere('pay', 'like', "%$keyword%")
                ->orWhere('author', 'like', "%$keyword%")
                ->orWhere('status', 'like', "%$keyword%");
                // ->orWhere('contact_person_phone', 'like', "%$keyword%");
            });
        }



        // Ajouter d'autres filtres si nécessaire
        // ...

        $staff = $query->get();

        return response()->json($staff);
    }

    /**
     * Display a listing ot the resource from on member
     */
    public function indexOfOneMember($memberId)
    {
        $debts = Debt::where('open_close', '!=', 1)->where('member_id', $memberId)->get();
        return response()->json($debts);
    }

    /**
     * Store a newly created resource in storage.
     */

      // Calculer et enregistrer les dettes pour l'année en cours
    public function calculateDebts()
    {
        $currentYear = now()->year;
        $annualContribution = 60000;

        $cotisations = Cotisation::all()->groupBy('member_id');

        foreach ($cotisations as $memberId => $memberCotisations) {
            $currentYearCotisations = $memberCotisations->filter(function ($cotisation) use ($currentYear) {
                return $cotisation->pay_year && date('Y', strtotime($cotisation->pay_year)) == $currentYear;
            });

            $totalPaid = $currentYearCotisations->sum('pay');

            if ($totalPaid < $annualContribution) {
                $debtAmount = $annualContribution - $totalPaid;

                $dette = Debt::firstOrNew([
                    'member_id' => $memberId,
                    'year' => $currentYear,
                ]);
                $dette->total_amount += $debtAmount;
                $dette->status = 'impayée';
                $dette->save();
            }
        }

        return response()->json(['message' => 'Les dettes ont été calculées avec succès.']);
    }
    public function store(Request $request)
    {
        $request->validate([
            'cashflow_id' => 'required|exists:cashflows,id',
            'pay_year' => 'required|date',
            'ref_ing_cost' => 'required|string|max:255',
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|integer',
            'pay' => 'required|integer',
            'author' => 'required|string|max:255',
            'status' => 'sometimes|string|default:OK',
            'personnel_id' => 'required|exists:personnels,id',
            'open_close' => 'sometimes|boolean|default:0',
        ]);

        $debt = Debt::create($request->all());

        return response()->json($debt, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $debt = Debt::find($id);
        if (!$debt || $debt->open_close == 1) {
            return response()->json(['message' => 'Debt not found or closed'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($debt);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $debt = Debt::find($id);
        if (!$debt) {
            return response()->json(['message' => 'Debt not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'cashflow_id' => 'sometimes|required|exists:cashflows,id',
            'pay_year' => 'sometimes|required|date',
            'ref_ing_cost' => 'sometimes|required|string|max:255',
            'member_id' => 'sometimes|required||exists:members,id',
            'amount' => 'sometimes|required|integer',
            'pay' => 'sometimes|required|integer',
            'author' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|string|default:OK',
            'personnel_id' => 'sometimes|required|exists:personnels,id',
            'open_close' => 'sometimes|boolean|default:0',
        ]);

        $debt->update($request->all());

        return response()->json($debt);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $debt = Debt::find($id);
        if (!$debt) {
            return response()->json(['message' => 'Debt not found'], Response::HTTP_NOT_FOUND);
        }

        $debt->update(['open_close' => 1]);

        return response()->json(['message' => 'Debt marked as closed']);
    }
}
