<?php

namespace App\Http\Controllers;

use App\Models\MasterCompany;
use App\Models\MasterDepartment;
use Illuminate\Http\Request;

class MasterDepartmentController extends Controller
{
    public function index()
    {
        $departments = MasterDepartment::with(['masterCompany'])->get();
        return view('master_departments.index', compact(['departments']));
    }




    public function create()
    {
        $masterCompany = MasterCompany::all();
        return view('master_departments.create', compact(['masterCompany']));
    }

    public function store(Request $request)
    {
        $data = [];

        for ($i = 0; $i < count($request->name); $i++) {
            $data[] = [
                'name' => $request->name[$i],
                'address' => $request->address[$i],
                'department_number' => $request->department_number[$i],
                'contact_person' => $request->contact_person[$i],
                'contact_person_number' => $request->contact_person_number[$i],
                'company_id' => $request->company_id[$i],

            ];
        }

        MasterDepartment::insert($data);

        // return redirect()->back()->with('success', 'Records inserted successfully!');
        return redirect()->route('departments.index')->with('succcess', 'Penambahan berhasil');
    }
    // end create


    // edit
    public function edit($id)
    {
        $department = MasterDepartment::findOrFail($id);
        return view('master_departments.edit', compact(['department']));
    }

    public function update(Request $request, $id)
    {
        $department = MasterDepartment::findOrFail($id);
        $department->name = $request->input('name');
        $department->address = $request->input('address');
        $department->department_number = $request->input('department_number');
        $department->contact_person = $request->input('contact_person');
        $department->contact_person_number = $request->input('contact_person_number');
        $department->company_id = $request->input('company_id');
        $department->save();

        return redirect()->route('departments.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    }
    // end edit

    // delete
    public function destroy($id)
    {
        $department = MasterDepartment::findOrFail($id);
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'compeny deleted successfully');
    }
}
