<?php

namespace App\Http\Controllers;

use App\Models\MasterCompany;
use App\Models\MasterDepartment;
use App\Models\MasterSection;
use Illuminate\Http\Request;

class MasterSectionController extends Controller
{
    public function index()
    {
        $sections = MasterSection::with(['masterCompany', 'masterDepartment'])->get();
        return view('master_sections.index', compact(['sections']));
    }




    public function create()
    {
        $masterDepartment = MasterDepartment::all();
        $masterCompany = MasterCompany::all();
        return view('master_sections.create', compact(['masterCompany', 'masterDepartment']));
    }

    public function store(Request $request)
    {
        $data = [];

        for ($i = 0; $i < count($request->name); $i++) {
            $data[] = [
                'name' => $request->name[$i],
                'address' => $request->address[$i],
                'section_number' => $request->department_number[$i],
                'contact_person' => $request->contact_person[$i],
                'contact_person_number' => $request->contact_person_number[$i],
                'company_id' => $request->company_id[$i],
                'department_id' => $request->department_id[$i],

            ];
        }

        MasterSection::insert($data);

        // return redirect()->back()->with('success', 'Records inserted successfully!');
        return redirect()->route('sections.index')->with('succcess', 'Penambahan berhasil');
    }
    // end create


    // edit
    public function edit($id)
    {
        $section = MasterSection::findOrFail($id);
        $masterCompany = MasterCompany::with('masterDepartment')->get();
        return view('master_sections.edit', compact(['section', 'masterCompany']));
    }

    public function update(Request $request, $id)
    {
        $section = MasterSection::findOrFail($id);
        $section->name = $request->input('name');
        $section->save();

        return redirect()->route('sections.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    }
    // end edit

    // delete
    public function destroy($id)
    {
        $section = MasterSection::findOrFail($id);
        $section->delete();

        return redirect()->route('sections.index')->with('success', 'compeny deleted successfully');
    }
}
