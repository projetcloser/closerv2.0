<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Company;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function companies()
    {
        $companies = Company::get();
        return view('companies.companies')->with(compact('companies'));
    }

    public function addEditCompany(Request $req, $id = null)
    {
        if ($id == "") {
            $title = "Ajouter une entreprise";
            $company = new Company();
        } else {
            $title = "Modifier une entreprise";
        }

        if ($req->isMethod('post')) {
            $data = $req->all();
            // echo "<pre>";
            // print_r($data);
            // die;


            $company->social_reason = $data['company_name'];
            $company->author = $data['author'];
            $company->type = $data['company_type'];
            $company->email = $data['email'];
            $company->nui = $data['nui'];
            $company->country_id = $data['country'];
            $company->city_id = $data['city_select'];
            $company->phone = $data['phone'];
            $company->contact_person = $data['contact_person'];
            $company->contact_person_phone = $data['contact_person_phone'];
            $company->neighborhood = $data['neighborhood'];

            $company->save();

            //Session::flash('success_message', 'Site "' . $site->name . '" enregistré !');
            return redirect('companies/add-edit-company');
        }
        $cities = City::get();
        return view('companies.add_edit_company')->with(compact('cities'));
    }

    public function selectCitiesSearch(Request $request)
    {
        $cities = [];

        if ($request->get('query')) {
            $search = $request->get('query');
            // echo "<br>" . $search . "<br>";
            $cities = City::select("id", "name")
                ->where('name', 'ILIKE', "%$search%")
                ->get();
        }
        return response()->json($cities);
    }
}
