<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\TransactionItemProcurementDetail;
use App\Models\TransactionItemProcurementHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;
use Ramsey\Uuid\Type\Integer;

class TransactionItemProcurementController extends Controller
{
    public function index()
    {
        $procurementHeaders = TransactionItemProcurementHeader::all();
        return view('procurements.index', compact(['procurementHeaders']));
    }



    public function create()
    {
        $maxId = TransactionItemProcurementHeader::max('id');
        $newId = $maxId + 1;
        $masterItems = MasterItem::all();
        return view('procurements.create', compact(['newId', 'masterItems']));
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
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the procurement header and its related details
            $procurementHeader = TransactionItemProcurementHeader::findOrFail($id);
            $procurementDetails = TransactionItemProcurementDetail::where('header_id', $id);

            // Delete details first
            $procurementDetails->delete();

            // Delete the header
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
        $procurementHeader = TransactionItemProcurementHeader::findOrFail($id);
        $procurementDetails = TransactionItemProcurementDetail::with('masterItem')->where('header_id', $id)->get();
        return view('procurements.detail', compact(['procurementHeader', 'procurementDetails']));
    }

    public function approve(Request $request, $id)
    {
        $sprocurementHeader = TransactionItemProcurementHeader::findOrFail($id);
        $sprocurementHeader->status = $request->input('status');
        $sprocurementHeader->save();

        return redirect()->route('procurements.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    }

    public function reject(Request $request, $id)
    {
        $sprocurementHeader = TransactionItemProcurementHeader::findOrFail($id);
        $sprocurementHeader->status = $request->input('status');
        $sprocurementHeader->save();

        return redirect()->route('procurements.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    }
}
