<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartment;
use App\Models\MasterItem;
use App\Models\MasterItemStatus;
use App\Models\TransactionInventory;
use App\Models\TransactionOutgoingItem;
use App\Models\TransactionStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionOutgoingItemController extends Controller
{
    public function index()
    {
        $outgoingItems = TransactionOutgoingItem::with(['user', 'masterItem', 'masterDepartment', 'masterItemStatus'])->get();
        return view('outgoing_items.index', compact(['outgoingItems']));
    }

    public function create()
    {
        $maxId = TransactionOutgoingItem::max('id');
        // $newId = $maxId + 1;
        $masterItems = MasterItem::all();
        $masterDepartments = MasterDepartment::all();
        $masterItemStatuses = MasterItemStatus::all();
        return view('outgoing_items.create', compact(['maxId', 'masterItems', 'masterDepartments', 'masterItemStatuses']));
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
                    'purpose' => $request->purpose[$i],
                ];
            }


            TransactionOutgoingItem::insert($data);

            $dataStock = [];
            for ($i = 0; $i < count($request->item_id); $i++) {
                $dataStock[] = [
                    'item_id' => $request->item_id[$i],
                    'code' => $request->code[$i],
                    'in' => 0,
                    'out' => $request->quantity[$i],
                    'transaction_date' => $request->transaction_date[$i],
                    'department_id' => $request->department_id[$i],
                ];

                $inventory = TransactionInventory::where('item_id', $request->item_id[$i])->where('department_id', $request->department_id[$i])->first();

                // mengecek apakah isi inventory ada
                if ($inventory && $inventory->quantity >= $request->quantity[$i]) {
                    $inventory->quantity -= $request->quantity[$i];
                    $inventory->save();
                } else {
                    // jika inventory tidak kurang
                    DB::rollBack();
                    return redirect()->route('outgoing_items.create')->with('error', 'Failed to add outgoing');
                }
            }
            TransactionStock::insert($dataStock);



            DB::commit();
            // return redirect()->back()->with('success', 'Records inserted successfully!');
            return redirect()->route('outgoing_items.index')->with('succcess', 'Penambahan berhasil');
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('outgoing_items.create')->with('error', 'Failed to add outgoing');
        }
    }

    public function destroy($id)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the procurement header and its related details
            $outgoingItem = TransactionOutgoingItem::where('id', $id)->first();

            // Check if the procurement is approved
            if ($outgoingItem) {
                // Find the related stock entry by code
                $stock = TransactionStock::where('code', $outgoingItem->code);
                if ($stock) {
                    // Delete the stock entry
                    $stock->delete();
                } else {
                    DB::rollBack();
                }

                // Update inventory quantities before deleting procurement details
                // Find the corresponding inventory record
                $inventory = TransactionInventory::where('item_id', $outgoingItem->item_id)
                    ->where('department_id', $outgoingItem->department_id)
                    ->first();

                if ($inventory) {
                    // Decrease the inventory quantity by the procurement quantity
                    $inventory->quantity += $outgoingItem->quantity;
                    $inventory->save();
                } else {
                    DB::rollBack();
                }
            }

            // Delete the incoming item
            $outgoingItem->delete();

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('outgoing_items.index')->with('success', 'Procurement deleted successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('outgoing_items.index')->with('error', 'Failed to undo');
        }
    }
}
