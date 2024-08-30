<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartment;
use App\Models\MasterItem;
use App\Models\TransactionDepreciation;
use App\Models\TransactionItemProcurementDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionDepreciationController extends Controller
{
    public function index()
    {
        $depreciations = TransactionDepreciation::with(['masterItem', 'masterDepartment', 'user'])->get();
        return view('depreciations.index', compact(['depreciations']));
    }

    public function create()
    {
        $maxId = TransactionDepreciation::max('id');
        // $newId = $maxId + 1;
        $masterItems = MasterItem::all();
        $masterDepartments = MasterDepartment::all();
        return view('depreciations.create', compact(['maxId', 'masterItems', 'masterDepartments']));
    }
    public function getPrice(Request $request)
    {
        $procurementDate = $request->procurement_date;
        $itemId = $request->item_id;
        $departmentId = $request->department_id;

        // Query menggunakan Eloquent
        $procurement = TransactionItemProcurementDetail::with(['procurementHeader'])
            ->whereHas('procurementHeader', function ($query) use ($procurementDate) {
                $query->where('transaction_date', $procurementDate);
            })
            ->where('item_id', $itemId)
            ->where('department_id', $departmentId)
            ->first();

        if ($procurement) {
            $price = $procurement->price;
        } else {
            $price = null;
        }

        return response()->json(['price' => $price]);
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            $data = [];

            for ($i = 0; $i < count($request->item_id); $i++) {
                $data[] = [
                    'procurement_date' => $request->procurement_date[$i],
                    'item_id' => $request->item_id[$i],
                    'department_id' => $request->department_id[$i],
                    'user_id' => $request->user_id[$i],
                    'price' => $request->price[$i],
                    'useful_life' => $request->useful_life[$i],
                    'residual_value' => $request->residual_value[$i],
                    'depreciation_value' => $request->depreciation_value[$i],
                ];
            }


            TransactionDepreciation::insert($data);


            DB::commit();
            // return redirect()->back()->with('success', 'Records inserted successfully!');
            return redirect()->route('depreciations.index')->with('succcess', 'Penambahan berhasil');
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('depreciations.create')->with('error', 'Failed to add outgoing');
        }
    }

    public function destroy($id)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the procurement header and its related details
            $outgoingItem = TransactionDepreciation::where('id', $id)->first();

            // Delete the incoming item
            $outgoingItem->delete();

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('depreciations.index')->with('success', 'Procurement deleted successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();

            // Redirect with error message
            return redirect()->route('depreciations.index')->with('error', 'Failed to undo');
        }
    }
}
