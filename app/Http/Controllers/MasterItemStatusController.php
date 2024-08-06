<?php

namespace App\Http\Controllers;

use App\Models\MasterItemStatus;
use Illuminate\Http\Request;

class MasterItemStatusController extends Controller
{
    public function index()
    {
        $itemStatuses = MasterItemStatus::all();
        return view('master_item_statuses.index', compact(['itemStatuses']));
    }


    public function create()
    {
        return view('master_item_statuses.create');
    }

    public function store(Request $request)
    {
        $data = [];

        for ($i = 0; $i < count($request->description); $i++) {
            $data[] = [
                'description' => $request->description[$i],
            ];
        }

        MasterItemStatus::insert($data);

        // return redirect()->back()->with('success', 'Records inserted successfully!');
        return redirect()->route('item_statuses.index')->with('succcess', 'Penambahan berhasil');
    }
    // end create


    // edit
    public function edit($id)
    {

        $itemStatus = MasterItemStatus::findOrFail($id);
        return view('master_item_statuses.edit', compact(['itemStatus']));
    }

    public function update(Request $request, $id)
    {
        $itemStatus = MasterItemStatus::findOrFail($id);
        $itemStatus->description = $request->input('description');
        $itemStatus->save();

        return redirect()->route('item_statuses.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    }
    // end edit

    // delete
    public function destroy($id)
    {
        $itemStatus = MasterItemStatus::findOrFail($id);
        $itemStatus->delete();

        return redirect()->route('item_statuses.index')->with('success', 'compeny deleted successfully');
    }
}
