<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\MasterVendor;
use App\Models\MasterVendorItem;
use Illuminate\Http\Request;

class MasterVendorItemController extends Controller
{
    public function index($id)
    {
        $vendorItems = MasterVendorItem::with('masterItems')->where('vendor_id', $id)->get();

        return view('master_vendor_items.index', compact(['vendorItems']));
    }


    public function create($id)
    {
        $masterItems = MasterItem::all();
        $masterVendor = MasterVendor::where('vendor_id', $id);
        return view('master_vendors.create', compact(['masterItems', 'masterVendor']));
    }

    public function store(Request $request)
    {
        $data = [];

        for ($i = 0; $i < count($request->name); $i++) {
            $data[] = [
                'name' => $request->name[$i],
                'address' => $request->address[$i],
                'office_number' => $request->office_number[$i],
                'owner' => $request->owner[$i],
                'owner_number' => $request->owner_number[$i],
            ];
        }

        MasterVendor::insert($data);

        // return redirect()->back()->with('success', 'Records inserted successfully!');
        return redirect()->route('vendors.index')->with('succcess', 'Penambahan berhasil');
    }
    // end create


    // edit
    public function edit($id)
    {
        $vendor = MasterVendor::findOrFail($id);
        return view('master_vendors.edit', compact(['vendor']));
    }

    public function update(Request $request, $id)
    {
        $vendor = MasterVendor::findOrFail($id);
        $vendor->name = $request->input('name');
        $vendor->address = $request->input('address');
        $vendor->office_number = $request->input('office_number');
        $vendor->owner = $request->input('owner');
        $vendor->owner_number = $request->input('owner_number');
        $vendor->save();

        return redirect()->route('vendors.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    }
    // end edit

    // delete
    public function destroy($id)
    {
        $vendor = MasterVendor::findOrFail($id);
        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', 'compeny deleted successfully');
    }
}
