<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartment;
use App\Models\MasterItem;
use App\Models\MasterItemStatus;
use App\Models\TransactionInventory;
use App\Models\TransactionItemMovementHeader;
use App\Models\TransactionItemProcurementHeader;
use Illuminate\Http\Request;

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
}
