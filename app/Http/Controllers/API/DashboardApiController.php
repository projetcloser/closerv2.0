<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Cotisation;
use App\Models\CompanyAttestation;
use App\Models\Debt;
use App\Models\Stamp;
use App\Models\PersonalCertificate;
use App\Models\Staff;
use App\Models\Company;

class DashboardApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Membres
        $totalMembers = Member::where('open_close', '!=', 1)->count();
        $membersWithNoDebt = Member::where('debt', 0)->where('open_close', '!=', 1)->count();
        $membersWithDebt = Member::where('debt', '!=', 0)->where('open_close', '!=', 1)->count();

        // Cotisations
        $totalCotisations = Cotisation::where('status', 3)->where('open_close', '!=', 1)->sum('amount');

        // Attestations d'entreprise
        $totalCompanyCotisations = CompanyAttestation::where('status', 3)->where('open_close', '!=', 1)->count() * 1000; // Successful attestations * 1000
        $totalCompanyAttestations = CompanyAttestation::where('status', 3)->where('open_close', '!=', 1)->count(); // Successful attestations
        $totalCompanyAttestationsAsk = CompanyAttestation::where('status', 1)->where('open_close', '!=', 1)->count(); // Pending attestations
        $totalCompanyAttestationsFailed = CompanyAttestation::where('status', 4)->where('open_close', '!=', 1)->count(); // Failed attestations

        // Dettes
        $totalDebts = Debt::where('open_close', '!=', 1)->sum('amount');

        // Cachets
        $stampsStatus1 = Stamp::where('status', 1)->where('open_close', '!=', 1)->count();
        $stampsStatus2 = Stamp::where('status', 2)->where('open_close', '!=', 1)->count();
        $stampsStatus3 = Stamp::where('status', 3)->where('open_close', '!=', 1)->count();
        $stampsStatus4 = Stamp::where('status', 4)->where('open_close', '!=', 1)->count();


        // Attestations à usage personnel
        $personalCertificates = PersonalCertificate::where('open_close', '!=', 1)->count();
        $personalCertificatesSuccess = PersonalCertificate::where('status', 3)->where('open_close', '!=', 1)->count();

        // Personnels
        $totalStaffs = Staff::where('open_close', '!=', 1)->count();

        // Entreprises
        $totalCompanies = Company::where('open_close', '!=', 1)->count();

        return response()->json([
            'members' => [
                'total' => $totalMembers,
                'no_debt' => $membersWithNoDebt,
                'with_debt' => $membersWithDebt,
            ],
            'cotisations' => [
                'total' => $totalCotisations,
            ],
            'company_attestations' => [
                'total_cotisations' => $totalCompanyCotisations,
                'total_attestations' => $totalCompanyAttestations,
                'ask_attestations' => $totalCompanyAttestationsAsk,
                'failed_attestations' => $totalCompanyAttestationsFailed,
            ],
            'debts' => [
                'total' => $totalDebts,
            ],
            'stamps' => [
                'status_1' => $stampsStatus1,
                'status_2' => $stampsStatus2,
                'status_3' => $stampsStatus3,
                'status_4' => $stampsStatus4,
            ],
            'personal_certificates' => [
                'total' => $personalCertificates,
                'total_success' => $personalCertificates,
            ],
            'staffs' => [
                'total' => $totalStaffs,
            ],
            'companies' => [
                'total' => $totalCompanies,
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
