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
        $vendor = MasterVendor::findOrFail($id);
        $vendorItems = MasterVendorItem::with('masterItem')->where('vendor_id', $id)->get();
        return view('master_vendor_items.index', compact(['vendorItems', 'id', 'vendor']));
    }


    public function create($id)
    {
        //$masterItems = MasterItem::all();
        // Get the item IDs associated with the specific vendor_id
        $existingItemIds = MasterVendorItem::where('vendor_id', $id)
            ->pluck('item_id')
            ->toArray();

        // Get MasterItems where their IDs are not in the existing item IDs
        $masterItems = MasterItem::whereNotIn('id', $existingItemIds)->get();

        $vendor = MasterVendor::findOrFail($id);
        return view('master_vendor_items.create', compact(['masterItems', 'id', 'vendor']));
    }

    public function store(Request $request, $id)
    {
        $data = [];

        for ($i = 0; $i < count($request->item_id); $i++) {
            $data[] = [
                'vendor_id' => $id,
                'item_id' => $request->item_id[$i],
            ];
        }

        MasterVendorItem::insert($data);

        // return redirect()->back()->with('success', 'Records inserted successfully!');
        return redirect()->route('vendor_items.index', $id)->with('succcess', 'Penambahan berhasil');
    }
    // end create

    // delete
    public function destroy($id, $vendorId)
    {
        $vendorItem = MasterVendorItem::findOrFail($id);
        $vendorItem->delete();

        return redirect()->route('vendor_items.index', $vendorId)->with('success', 'compeny deleted successfully');
    }
}
