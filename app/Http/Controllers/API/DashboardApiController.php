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
use App\Models\Fine;

class DashboardApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $idPerso = $request->query('id_perso'); // Récupérer l'ID du membre depuis la requête
        $idRole = $request->query('id_role');

        // Vérifiez si un id_perso est fourni

        if ($idPerso && $idRole == 1) {
            //cotisation
            $totalCotisationsAmount = Cotisation::where('status', 3)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->sum('amount');

            $totalCotisationsNoAmount = Cotisation::where('status', '!=', 3)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->sum('amount');

            //nombre total des cotisations status = 3 and member_id = idPerso
            // $memberCotisationsTotal = Cotisation::where('status', 3)
            //     ->where('member_id', $idPerso) // Filtrer par ID membre
            //     ->where('open_close', '!=', 1)
            //     ->count();
            //nombre total des cotisations
            $totalCotisations = Cotisation::where('open_close', '!=', 1)
                ->where('member_id', $idPerso)
                ->sum('amount');

            /**************Attestion entreprise ***************/
            //Attestation entreprise status 3 : Successful attestations
            $totalCompanyAttestations = CompanyAttestation::where('status', 3)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();
            //Attestation entreprise total * 1000
            $totalCompanyCotisations = CompanyAttestation::where('status', 3)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count() * 1000;
            //Attestation entreprise status 1 : Pending attestations
            $totalCompanyAttestationsAsk = CompanyAttestation::where('status', 1)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();
            //Attestation entreprise status 4 : Failed attestations
            $totalCompanyAttestationsFailed = CompanyAttestation::where('status', 4)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();



            //Attestation personnel
            $personalCertificatesSuccess = PersonalCertificate::where('status', 3)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();
            //Attestation personnel total
            $personalCertificates = PersonalCertificate::where('open_close', '!=', 1)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->count();


            //Cachet status 3 : Successful stamps
            $stampsStatus4 = Stamp::where('status', 4)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();
            //Cachet status 4 : Failed stamps
            $stampsStatus3 = Stamp::where('status', 3)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();
            //Cachet status 2 : Pending stamps
            $stampsStatus2 = Stamp::where('status', 2)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();
            //Cachet status 1 : Non payé stamps
            $stampsStatus1 = Stamp::where('status', 1)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();


            //Dette
            $totalNbDebts = Debt::where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();
            $totalDebtsPaid = Debt::where('status', '3')
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();
            $totalDebtsNotPaid = Debt::where('status', '1')
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();
            $totalDebtsAmount = Debt::where('member_id', $idPerso) // Filtrer par ID membres
                ->where('open_close', '!=', 1)
                ->sum('amount');
            $totalDebtsAmountPaid = Debt::where('status', '3')
                ->where('member_id', $idPerso) // Filtrer par ID membres
                ->where('open_close', '!=', 1)
                ->sum('amount');
            $totalDebtsAmountNotPaid = Debt::where('status', '1')
                ->where('member_id', $idPerso) // Filtrer par ID membres
                ->where('open_close', '!=', 1)
                ->sum('amount');

            //Amende
            $totalNbFines = Fine::where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();
            $totalFinesPaid = Fine::where('status', 1)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();
            $totalFinesNotPaid = Fine::where('status', 0)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->count();
            $totalFinesAmount = Fine::where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->sum('amount');
            $totalFinesAmountPaid = Fine::where('status', 1)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->sum('amount');
            $totalFinesAmountNotPaid = Fine::where('status', 0)
                ->where('member_id', $idPerso) // Filtrer par ID membre
                ->where('open_close', '!=', 1)
                ->sum('amount');
        } else {
            // Cotisations percues
            $totalCotisationsAmount = Cotisation::where('status', 3)->where('open_close', '!=', 1)->sum('amount');
            $totalCotisationsNoAmount = Cotisation::where('status', '!=', 3)->where('open_close', '!=', 1)->sum('amount');
            $totalCotisations = Cotisation::where('open_close', '!=', 1)->sum('amount');
            //nombre total des cotisations status = 3
            // $memberCotisationsTotal = Cotisation::where('status', 3)->where('open_close', '!=', 1)->count();
            //nombre total des cotisations
            // $totalCotisations = Cotisation::where('open_close', '!=', 1)->count();



            // Attestations d'entreprise
            $totalCompanyCotisations = CompanyAttestation::where('status', 3)->where('open_close', '!=', 1)->count() * 1000; // Successful attestations * 1000
            $totalCompanyAttestations = CompanyAttestation::where('status', 3)->where('open_close', '!=', 1)->count(); // Successful attestations
            $totalCompanyAttestationsAsk = CompanyAttestation::where('open_close', '!=', 1)->count(); // Pending attestations
            $totalCompanyAttestationsFailed = CompanyAttestation::where('status', 4)->where('open_close', '!=', 1)->count(); // Failed attestations

            // Dettes
            $totalNbDebts = Debt::where('open_close', '!=', 1)->count();
            $totalDebtsPaid = Debt::where('status', '3')->where('open_close', '!=', 1)->count();
            $totalDebtsNotPaid = Debt::where('status', '1')->where('open_close', '!=', 1)->count();
            $totalDebtsAmount = Debt::where('open_close', '!=', 1)->sum('amount');
            $totalDebtsAmountPaid = Debt::where('status', '3')->where('open_close', '!=', 1)->sum('amount');
            $totalDebtsAmountNotPaid = Debt::where('status', '1')->where('open_close', '!=', 1)->sum('amount');

            // Cachets
            $stampsStatus1 = Stamp::where('status', 1)->where('open_close', '!=', 1)->count();
            $stampsStatus2 = Stamp::where('status', 2)->where('open_close', '!=', 1)->count();
            $stampsStatus3 = Stamp::where('status', 3)->where('open_close', '!=', 1)->count();
            $stampsStatus4 = Stamp::where('status', 4)->where('open_close', '!=', 1)->count();

            // Attestations à usage personnel
            $personalCertificates = PersonalCertificate::where('open_close', '!=', 1)->count();
            $personalCertificatesSuccess = PersonalCertificate::where('status', 3)->where('open_close', '!=', 1)->count();

            // Amende
            $totalNbFines = Fine::where('open_close', '!=', 1)->count();
            $totalFinesPaid = Fine::where('status', 1)->where('open_close', '!=', 1)->count();
            $totalFinesNotPaid = Fine::where('status', 0)->where('open_close', '!=', 1)->count();
            $totalFinesAmount = Fine::where('open_close', '!=', 1)->sum('amount');
            $totalFinesAmountPaid = Fine::where('status', 1)->where('open_close', '!=', 1)->sum('amount');
            $totalFinesAmountNotPaid = Fine::where('status', 0)->where('open_close', '!=', 1)->sum('amount');
        }
        // Membres
        $totalMembers = Member::where('open_close', '!=', 1)->count();
        $membersWithNoDebt = Member::where('debt', 0)->where('open_close', '!=', 1)->count();
        $membersWithDebt = Member::where('debt', '!=', 0)->where('open_close', '!=', 1)->count();






        // Personnels
        $totalStaffs = Staff::where('open_close', '!=', 1)->count();

        // Entreprises
        $totalCompanies = Company::where('open_close', '!=', 1)->count();
        //companies dont le company_categorie =


        return response()->json([
            'members' => [
                'total' => number_format($totalMembers, 0, ',', ' '),
                'no_debt' => number_format($membersWithNoDebt, 0, ',', ' '),
                'with_debt' => number_format($membersWithDebt, 0, ',', ' '),
            ],
            'cotisations' => [
                'total_attendue' => number_format($totalCotisations, 0, ',', ' '), // Formate les milliers
                'total_percue' => number_format($totalCotisationsAmount, 0, ',', ' '),
                'total_non_percue' => number_format($totalCotisationsNoAmount, 0, ',', ' '),
            ],
            'company_attestations' => [
                'total_percevoir' => number_format($totalCompanyCotisations, 0, ',', ' '),
                'total_paye' => number_format($totalCompanyAttestations, 0, ',', ' '),
                'total_demande' => number_format($totalCompanyAttestationsAsk, 0, ',', ' '),
                'failed_attestations' => number_format($totalCompanyAttestationsFailed, 0, ',', ' '),
            ],
            'debts' => [
                'total_nb_dette' => $totalNbDebts,
                'total_paye' => number_format($totalDebtsPaid, 0, ',', ' '),
                'total_non_paye' => number_format($totalDebtsNotPaid, 0, ',', ' '),
                'total_dette' => number_format($totalDebtsAmount, 0, ',', ' '),
                'total_percue' => number_format($totalDebtsAmountPaid, 0, ',', ' '),
                'total_percevoir' => number_format($totalDebtsAmountNotPaid, 0, ',', ' '),
            ],
            'stamps' => [
                'status_1' => number_format($stampsStatus1, 0, ',', ' '),
                'status_2' => number_format($stampsStatus2, 0, ',', ' '),
                'status_3' => number_format($stampsStatus3, 0, ',', ' '),
                'status_4' => number_format($stampsStatus4, 0, ',', ' '),
            ],
            'personal_certificates' => [
                'total_demande' => number_format($personalCertificates, 0, ',', ' '),
                'total_success' => number_format($personalCertificates, 0, ',', ' '),
            ],
            'fines' => [
                'total_nb_amende' => number_format($totalNbFines, 0, ',', ' '),
                'total_paye' => number_format($totalFinesPaid, 0, ',', ' '),
                'total_non_paye' => number_format($totalFinesNotPaid, 0, ',', ' '),
                'total_amende' => number_format($totalFinesAmount, 0, ',', ' '),
                'total_percue' => number_format($totalFinesAmountPaid, 0, ',', ' '),
                'total_percevoir' => number_format($totalFinesAmountNotPaid, 0, ',', ' '),
            ],
            'staffs' => [
                'total' => number_format($totalStaffs, 0, ',', ' '),
            ],
            'companies' => [
                'total' => number_format($totalCompanies, 0, ',', ' '),
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
