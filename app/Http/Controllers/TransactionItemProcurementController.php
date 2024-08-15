<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartment;
use App\Models\MasterItem;
use App\Models\MasterVendor;
use App\Models\TransactionInventory;
use App\Models\TransactionItemProcurementDetail;
use App\Models\TransactionItemProcurementHeader;
use App\Models\TransactionStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;
use Ramsey\Uuid\Type\Integer;

class TransactionItemProcurementController extends Controller
{
    public function index()
    {
        $procurementHeaders = TransactionItemProcurementHeader::with(['masterVendor', 'user'])->get();
        return view('procurements.index', compact(['procurementHeaders']));
    }



    public function create()
    {
        $maxId = TransactionItemProcurementHeader::max('id');
        $newId = $maxId + 1;
        $masterItems = MasterItem::all();
        $masterDepartments = MasterDepartment::all();
        $masterVendors = MasterVendor::all();
        return view('procurements.create', compact(['newId', 'masterItems', 'masterDepartments', 'masterVendors']));
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
                'vendor_id' => $request->vendor_id,
                'user_id' => $request->user_id,

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


    // end create


    // edit
    // public function edit($id)
    // {
    //     $vendor = MasterVendor::findOrFail($id);
    //     return view('master_vendors.edit', compact(['vendor']));
    // }

    // public function update(Request $request, $id)
    // {
    //     $vendor = MasterVendor::findOrFail($id);
    //     $vendor->name = $request->input('name');
    //     $vendor->address = $request->input('address');
    //     $vendor->office_number = $request->input('office_number');
    //     $vendor->owner = $request->input('owner');
    //     $vendor->owner_number = $request->input('owner_number');
    //     $vendor->save();

    //     return redirect()->route('vendors.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    // }
    // end edit

    // delete
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

    public function detail($id)
    {
        $procurementHeader = TransactionItemProcurementHeader::with(['masterVendor', 'user'])->findOrFail($id);
        $procurementDetails = TransactionItemProcurementDetail::with(['masterItem', 'masterDepartment'])->where('header_id', $id)->get();
        return view('procurements.detail', compact(['procurementHeader', 'procurementDetails']));
    }

    public function approve(Request $request, $id)
    {
        $procurementHeader = TransactionItemProcurementHeader::findOrFail($id);




        $procurementDetails = TransactionItemProcurementDetail::where('header_id', $id)->get();

        foreach ($procurementDetails as $detail) {
            DB::beginTransaction();

            try {
                $procurementHeader->status = $request->input('status');
                $procurementHeader->save();

                $dataDetails = [];

                $dataDetails[] = [
                    'item_id' => $detail->item_id,
                    'code' => $procurementHeader->code,
                    'in' => $detail->quantity,
                    'out' => 0,
                    'transaction_date' => $procurementHeader->transaction_date,
                    'department_id' => $detail->department_id,
                ];
                TransactionStock::insert($dataDetails);

                $inventory = TransactionInventory::where('item_id', $detail->item_id)->where('department_id', $detail->department_id)->first();

                // mengecek apakah isi inventory ada
                if ($inventory) {
                    $inventory->quantity += $detail->quantity;
                    $inventory->save();
                } else {
                    // jika inventory tidak ditemukan
                    TransactionInventory::create([
                        'item_id' => $detail->item_id,
                        'department_id' => $detail->department_id,
                        'quantity' => $detail->quantity,
                    ]);
                }

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



        return redirect()->route('procurements.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    }

    public function reject(Request $request, $id)
    {
        $procurementHeader = TransactionItemProcurementHeader::findOrFail($id);

        DB::beginTransaction();
        try {
            // Update the status of the procurement header
            $procurementHeader->status = $request->input('status');
            $procurementHeader->save();

            // Check if the status is 'rejected'
            if ($procurementHeader->status == 'rejected') {
                // Find the related stock entry by code
                $stock = TransactionStock::where('code', $procurementHeader->code);
                if ($stock) {
                    // Delete the stock entry
                    $stock->delete();
                }

                // Get the details of the procurement
                $procurementDetails = TransactionItemProcurementDetail::where('header_id', $id)->get();
                foreach ($procurementDetails as $detail) {
                    // Find the corresponding inventory record
                    $inventory = TransactionInventory::where('item_id', $detail->item_id)
                        ->where('department_id', $detail->department_id)
                        ->first();
                    if ($inventory) {
                        // Decrease the inventory quantity by the rejected procurement quantity
                        $inventory->quantity -= $detail->quantity;
                        $inventory->save();
                    } else {
                        // If inventory record does not exist, roll back the transaction
                        DB::rollBack();
                        return redirect()->route('procurements.index')->with('error', 'Failed to update inventory');
                    }
                }
            }

            // Commit the transaction
            DB::commit();
            return redirect()->route('procurements.index')->with('success', 'Procurement rejected successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();
            return redirect()->route('procurements.index')->with('error', 'Failed to reject procurement');
        }
    }
}
