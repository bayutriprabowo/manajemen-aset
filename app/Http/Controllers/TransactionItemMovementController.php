<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartment;
use App\Models\MasterItem;
use App\Models\MasterItemStatus;
use App\Models\TransactionInventory;
use App\Models\TransactionItemMovementDetail;
use App\Models\TransactionItemMovementHeader;
use App\Models\TransactionItemProcurementHeader;
use App\Models\TransactionStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionItemMovementController extends Controller
{
    public function index()
    {
        $movementHeaders = TransactionItemMovementHeader::with(['masterDepartmentFrom', 'masterDepartmentTo', 'masterStatus', 'user'])->get();
        return view('movements.index', compact(['movementHeaders']));
    }

    public function create()
    {
        $maxId = TransactionItemMovementHeader::max('id');
        $newId = $maxId + 1;
        $masterItems = MasterItem::all();
        $masterDepartments = MasterDepartment::all();
        $masterStatuses = MasterItemStatus::all();
        $inventories = TransactionInventory::all();
        return view('movements.create', compact(['inventories', 'newId', 'masterItems', 'masterDepartments', 'masterStatuses']));
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            $dataHeader = [];
            $dataDetails = [];

            $dataHeader[] = [
                'id' => $request->id_header,
                'user_id' => $request->user_id,
                'transaction_date' => $request->transaction_date,
                'code' => $request->code,
                'department_id_from' => $request->department_id_from,
                'department_id_to' => $request->department_id_to,
                'status' => $request->status,
                'purpose' => $request->purpose,
                'status_id' => $request->status_id,
                'description' => $request->description,
            ];

            for ($i = 0; $i < count($request->item_id); $i++) {
                $dataDetails[] = [
                    'item_id' => $request->item_id[$i],
                    'stock' => $request->stock[$i],
                    'quantity' => $request->quantity[$i],
                    'header_id' => $request->header_id[$i],
                ];
            }


            TransactionItemMovementHeader::insert($dataHeader);
            TransactionItemMovementDetail::insert($dataDetails);
            DB::commit();
            // return redirect()->back()->with('success', 'Records inserted successfully!');
            return redirect()->route('movements.index')->with('succcess', 'Penambahan berhasil');
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('movements.create')->with('error', 'Failed to add procurement');
        }
    }

    public function destroy($id)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the procurement header and its related details
            $movementHeader = TransactionItemMovementHeader::findOrFail($id);
            $movementDetails = TransactionItemMovementDetail::where('header_id', $id)->get();

            // Check if the procurement is approved
            if ($movementHeader->status == 'approved') {
                // Find the related stock entry by code
                $stock = TransactionStock::where('code', $movementHeader->code);
                if ($stock) {
                    // Delete the stock entry
                    $stock->delete();
                }

                // Update inventory quantities before deleting procurement details
                foreach ($movementDetails as $detail) {
                    // Find the corresponding inventory record
                    $inventoryFrom = TransactionInventory::where('item_id', $detail->item_id)
                        ->where('department_id', $movementHeader->department_id_from)
                        ->first();
                    $inventoryTo = TransactionInventory::where('item_id', $detail->item_id)
                        ->where('department_id', $movementHeader->department_id_to)
                        ->first();

                    if ($inventoryFrom && $inventoryTo) {
                        // Decrease the inventory quantity by the procurement quantity
                        $inventoryFrom->quantity += $detail->quantity;
                        $inventoryFrom->save();
                        $inventoryTo->quantity -= $detail->quantity;
                        $inventoryTo->save();
                    } else {
                        // If inventory record does not exist, roll back the transaction
                        DB::rollBack();
                        return redirect()->route('movements.index')->with('error', 'Failed to update inventory');
                    }
                }
            }

            // Delete the procurement details
            TransactionItemMovementDetail::where('header_id', $id)->delete();

            // Delete the procurement header
            $movementHeader->delete();

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('movements.index')->with('success', 'Procurement deleted successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('movements.index')->with('error', 'Failed to delete procurement');
        }
    }

    public function detail($id)
    {
        $movementHeader = TransactionItemMovementHeader::with(['masterDepartmentFrom', 'masterDepartmentTo', 'masterStatus', 'user'])->findOrFail($id);
        $movementDetails = TransactionItemMovementDetail::with(['masterItem'])->where('header_id', $id)->get();
        return view('movements.detail', compact(['movementHeader', 'movementDetails']));
    }

    public function approve(Request $request, $id)
    {
        $movementHeader = TransactionItemMovementHeader::findOrFail($id);

        $movementDetails = TransactionItemMovementDetail::where('header_id', $id)->get();

        foreach ($movementDetails as $detail) {
            DB::beginTransaction();

            try {
                $movementHeader->status = $request->input('status');
                $movementHeader->save();

                $dataDetailsFrom = [];
                $dataDetailsTo = [];

                $dataDetailsFrom[] = [
                    'item_id' => $detail->item_id,
                    'code' => $movementHeader->code,
                    'in' => 0,
                    'out' => $detail->quantity,
                    'transaction_date' => $movementHeader->transaction_date,
                    'department_id' => $movementHeader->department_id_from,
                ];

                $dataDetailsTo[] = [
                    'item_id' => $detail->item_id,
                    'code' => $movementHeader->code,
                    'in' => $detail->quantity,
                    'out' => 0,
                    'transaction_date' => $movementHeader->transaction_date,
                    'department_id' => $movementHeader->department_id_to,
                ];
                TransactionStock::insert($dataDetailsFrom);
                TransactionStock::insert($dataDetailsTo);

                $inventoryFrom = TransactionInventory::where('item_id', $detail->item_id)->where('department_id', $movementHeader->department_id_from)->first();
                $inventoryTo = TransactionInventory::where('item_id', $detail->item_id)->where('department_id', $movementHeader->department_id_to)->first();

                // mengecek apakah isi inventory ada
                if ($inventoryFrom && $inventoryTo) {
                    $inventoryFrom->quantity -= $detail->quantity;
                    $inventoryFrom->save();
                    $inventoryTo->quantity += $detail->quantity;
                    $inventoryTo->save();
                } else {
                    // jika inventory tidak ditemukan
                    $inventoryFrom->quantity -= $detail->quantity;
                    $inventoryFrom->save();

                    TransactionInventory::create([
                        'item_id' => $detail->item_id,
                        'department_id' => $movementHeader->department_id_to,
                        'quantity' => $detail->quantity,
                    ]);
                }

                DB::commit();
                // return redirect()->back()->with('success', 'Records inserted successfully!');
                return redirect()->route('movements.index')->with('succcess', 'Penambahan berhasil');
            } catch (\Exception $e) {
                // Rollback the transaction if something went wrong
                DB::rollBack();

                // Redirect with error message
                return redirect()->route('movements.create')->with('error', 'Failed to add procurement');
            }
        }

        return redirect()->route('movements.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    }

    public function reject(Request $request, $id)
    {
        $movementHeader = TransactionItemMovementHeader::findOrFail($id);

        DB::beginTransaction();
        try {
            // Update the status of the procurement header
            $movementHeader->status = $request->input('status');
            $movementHeader->save();

            // Check if the status is 'rejected'
            if ($movementHeader->status == 'rejected') {
                // Find the related stock entry by code
                $stock = TransactionStock::where('code', $movementHeader->code);
                if ($stock) {
                    // Delete the stock entry
                    $stock->delete();
                }

                // Get the details of the procurement
                $movementDetails = TransactionItemMovementDetail::where('header_id', $id)->get();
                foreach ($movementDetails as $detail) {
                    // Find the corresponding inventory record
                    $inventoryFrom = TransactionInventory::where('item_id', $detail->item_id)->where('department_id', $movementHeader->department_id_from)->first();
                    $inventoryTo = TransactionInventory::where('item_id', $detail->item_id)->where('department_id', $movementHeader->department_id_to)->first();

                    // mengecek apakah isi inventory ada
                    if ($inventoryFrom && $inventoryTo) {
                        $inventoryFrom->quantity += $detail->quantity;
                        $inventoryFrom->save();
                        $inventoryTo->quantity -= $detail->quantity;
                        $inventoryTo->save();
                    } else {
                        // jika inventory tidak ditemukan
                        DB::rollBack();
                        return redirect()->route('movements.index')->with('error', 'Failed to update inventory');
                    }
                }
            }

            // Commit the transaction
            DB::commit();
            return redirect()->route('movements.index')->with('success', 'Procurement rejected successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();
            return redirect()->route('movements.index')->with('error', 'Failed to reject procurement');
        }
    }
}
