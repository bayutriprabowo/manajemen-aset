<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartment;
use App\Models\MasterItem;
use App\Models\MasterItemStatus;
use App\Models\TransactionIncomingItem;
use App\Models\TransactionInventory;
use App\Models\TransactionStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // $newId = $maxId + 1;
        $masterItems = MasterItem::all();
        $masterDepartments = MasterDepartment::all();
        $masterItemStatuses = MasterItemStatus::all();
        return view('incoming_items.create', compact(['maxId', 'masterItems', 'masterDepartments', 'masterItemStatuses']));
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            $data = [];

            for ($i = 0; $i < count($request->item_id); $i++) {
                $data[] = [
                    'code' => $request->code[$i],
                    'item_id' => $request->item_id[$i],
                    'department_id' => $request->department_id[$i],
                    'user_id' => $request->user_id[$i],
                    'quantity' => $request->quantity[$i],
                    'transaction_date' => $request->transaction_date[$i],
                    'status_id' => $request->status_id[$i],
                    'description' => $request->description[$i],
                ];
            }


            TransactionIncomingItem::insert($data);

            $dataStock = [];
            for ($i = 0; $i < count($request->item_id); $i++) {
                $dataStock[] = [
                    'item_id' => $request->item_id[$i],
                    'code' => $request->code[$i],
                    'in' => $request->quantity[$i],
                    'out' => 0,
                    'transaction_date' => $request->transaction_date[$i],
                    'department_id' => $request->department_id[$i],
                ];

                $inventory = TransactionInventory::where('item_id', $request->item_id[$i])->where('department_id', $request->department_id[$i])->first();

                // mengecek apakah isi inventory ada
                if ($inventory) {
                    $inventory->quantity += $request->quantity[$i];
                    $inventory->save();
                } else {
                    // jika inventory tidak ditemukan
                    TransactionInventory::create([
                        'item_id' => $request->item_id[$i],
                        'department_id' => $request->department_id[$i],
                        'quantity' => $request->quantity[$i],
                    ]);
                }
            }
            TransactionStock::insert($dataStock);



            DB::commit();
            // return redirect()->back()->with('success', 'Records inserted successfully!');
            return redirect()->route('incoming_items.index')->with('succcess', 'Penambahan berhasil');
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('incoming_items.create')->with('error', 'Failed to add procurement');
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
