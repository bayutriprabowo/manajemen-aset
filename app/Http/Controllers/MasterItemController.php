<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\MasterItemType;
use Illuminate\Http\Request;

class MasterItemController extends Controller
{
    public function index()
    {
        $items = MasterItem::with(['masterItemType'])->get();
        return view('master_items.index', compact(['items']));
    }


    public function create()
    {
        $masterItemTypes = MasterItemType::all();
        return view('master_items.create', compact(['masterItemTypes']));
    }

    public function store(Request $request)
    {
        $data = [];

        for ($i = 0; $i < count($request->name); $i++) {
            $data[] = [
                'barcode' => $request->barcode[$i],
                'name' => $request->name[$i],
                'price' => $request->price[$i],
                'type_id' => $request->type_id[$i],
            ];
        }

        MasterItem::insert($data);

        // return redirect()->back()->with('success', 'Records inserted successfully!');
        return redirect()->route('items.index')->with('succcess', 'Penambahan berhasil');
    }
    // end create


    // edit
    public function edit($id)
    {
        $masterItemTypes = MasterItemType::all();
        $item = MasterItem::findOrFail($id);
        return view('master_items.edit', compact(['item']));
    }

    public function update(Request $request, $id)
    {
        $item = MasterItem::findOrFail($id);
        $item->barcode = $request->input('barcode');
        $item->name = $request->input('name');
        $item->price = $request->input('price');
        $item->type_id = $request->input('type_id');
        $item->save();

        return redirect()->route('items.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    }
    // end edit

    // delete
    public function destroy($id)
    {
        $item = MasterItem::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')->with('success', 'compeny deleted successfully');
    }
}
