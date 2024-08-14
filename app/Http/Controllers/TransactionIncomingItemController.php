<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartment;
use App\Models\MasterItem;
use App\Models\MasterItemStatus;
use App\Models\TransactionIncomingItem;
use Illuminate\Http\Request;

class TransactionIncomingItemController extends Controller
{
    public function index()
    {
        $incomingItems = TransactionIncomingItem::with(['user', 'masterItem', 'masterDepartment', 'masterItemStatus'])->get();
        return view('incoming_items.index', compact(['incomingItems']));
    }



    public function create()
    {
        $maxId = TransactionIncomingItem::max('id');
        $newId = $maxId + 1;
        $masterItems = MasterItem::all();
        $masterDepartments = MasterDepartment::all();
        $masterItemStatuses = MasterItemStatus::all();
        return view('incoming_items.create', compact(['maxId', 'masterItems', 'masterDepartments', 'masterItemStatuses']));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $dataHeader = [];
            $dataDetails = [];

            $dataHeader[] = [
                'id' => $request->id_header,
                'transaction_date' => $request->transaction_date,
                'status' => $request->status,
                'code' => $request->code,
                'description' => $request->description,
                'total' => $request->total,

            ];

            for ($i = 0; $i < count($request->item_id); $i++) {
                $dataDetails[] = [
                    'item_id' => $request->item_id[$i],
                    'quantity' => $request->quantity[$i],
                    'price' => $request->price[$i],
                    'subtotal' => $request->subtotal[$i],
                    'header_id' => $request->header_id[$i],
                    'department_id' => $request->department_id[$i],
                ];
            }


            TransactionItemProcurementHeader::insert($dataHeader);
            TransactionItemProcurementDetail::insert($dataDetails);
            DB::commit();
            // return redirect()->back()->with('success', 'Records inserted successfully!');
            return redirect()->route('procurements.index')->with('succcess', 'Penambahan berhasil');
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('procurements.create')->with('error', 'Failed to add procurement');
        }
    }

    public function destroy($id)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the procurement header and its related details
            $procurementHeader = TransactionItemProcurementHeader::findOrFail($id);
            $procurementDetails = TransactionItemProcurementDetail::where('header_id', $id)->get();

            // Check if the procurement is approved
            if ($procurementHeader->status == 'approved') {
                // Find the related stock entry by code
                $stock = TransactionStock::where('code', $procurementHeader->code);
                if ($stock) {
                    // Delete the stock entry
                    $stock->delete();
                }

                // Update inventory quantities before deleting procurement details
                foreach ($procurementDetails as $detail) {
                    // Find the corresponding inventory record
                    $inventory = TransactionInventory::where('item_id', $detail->item_id)
                        ->where('department_id', $detail->department_id)
                        ->first();

                    if ($inventory) {
                        // Decrease the inventory quantity by the procurement quantity
                        $inventory->quantity -= $detail->quantity;
                        $inventory->save();
                    } else {
                        // If inventory record does not exist, roll back the transaction
                        DB::rollBack();
                        return redirect()->route('procurements.index')->with('error', 'Failed to update inventory');
                    }
                }
            }

            // Delete the procurement details
            TransactionItemProcurementDetail::where('header_id', $id)->delete();

            // Delete the procurement header
            $procurementHeader->delete();

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('procurements.index')->with('success', 'Procurement deleted successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('procurements.index')->with('error', 'Failed to delete procurement');
        }
    }
}
