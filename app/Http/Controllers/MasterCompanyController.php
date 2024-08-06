<?php

namespace App\Http\Controllers;

use App\Models\MasterCompany;
use Illuminate\Http\Request;

class MasterCompanyController extends Controller
{
    public function index()
    {
        $companies = MasterCompany::all();
        return view('master_companies.index', compact(['companies']));
    }




    public function create()
    {
        return view('master_companies.create');
    }

    public function store(Request $request)
    {
        $data = [];

        for ($i = 0; $i < count($request->name); $i++) {
            $data[] = [
                'name' => $request->name[$i],
                'address' => $request->address[$i],
                'company_number' => $request->company_number[$i],
                'contact_person' => $request->contact_person[$i],
                'contact_person_number' => $request->contact_person_number[$i],
            ];
        }

        MasterCompany::insert($data);

        // return redirect()->back()->with('success', 'Records inserted successfully!');
        return redirect()->route('companies.index')->with('succcess', 'Penambahan berhasil');
    }
    // end create


    // edit
    public function edit($id)
    {
        $company = MasterCompany::findOrFail($id);
        return view('master_companies.edit', compact(['company']));
    }

    public function update(Request $request, $id)
    {
        $company = MasterCompany::findOrFail($id);
        $company->name = $request->input('name');
        $company->address = $request->input('address');
        $company->company_number = $request->input('department_number');
        $company->contact_person = $request->input('contact_person');
        $company->contact_person_number = $request->input('contact_person_number');
        $company->save();

        return redirect()->route('companies.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    }
    // end edit

    // delete
    public function destroy($id)
    {
        $company = MasterCompany::findOrFail($id);
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'compeny deleted successfully');
    }
}
