<?php

namespace App\Http\Controllers;

use App\Models\MasterItemType;
use Illuminate\Http\Request;

class MasterItemTypeController extends Controller
{
    public function index()
    {
        $itemTypes = MasterItemType::all();
        return view('master_item_types.index', compact(['itemTypes']));
    }




    public function create()
    {
        return view('master_item_types.create');
    }

    public function store(Request $request)
    {
        $data = [];

        for ($i = 0; $i < count($request->name); $i++) {
            $data[] = [
                'name' => $request->name[$i],

            ];
        }

        MasterItemType::insert($data);

        // return redirect()->back()->with('success', 'Records inserted successfully!');
        return redirect()->route('item_types.index')->with('succcess', 'Penambahan berhasil');
    }
    // end create


    // edit
    public function edit($id)
    {
        $itemType = MasterItemType::findOrFail($id);
        return view('master_item_types.edit', compact(['itemType']));
    }

    public function update(Request $request, $id)
    {
        $itemType = MasterItemType::findOrFail($id);
        $itemType->name = $request->input('name');
        $itemType->save();

        return redirect()->route('item_types.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    }
    // end edit

    // delete
    public function destroy($id)
    {
        $itemType = MasterItemType::findOrFail($id);
        $itemType->delete();

        return redirect()->route('item_types.index')->with('success', 'User deleted successfully');
    }
}
