<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartment;
use App\Models\MasterItem;
use App\Models\TransactionInventory;
use App\Models\TransactionStock;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionStockController extends Controller
{
    public function index()
    {
        $masterItems = MasterItem::all();
        $masterDepartments = MasterDepartment::all();
        $inventories = TransactionInventory::with(['masterItem', 'masterDepartment'])->get();
        return view('stocks.index', compact(['inventories', 'masterItems', 'masterDepartments']));
    }

    public function filter(Request $request)
    {
        $itemId = $request->input('item_id');
        $departmentId = $request->input('department_id');

        $query = TransactionInventory::query();

        if ($itemId) {
            $query->where('item_id', $itemId);
        }

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        $inventories = $query->with(['masterItem', 'masterDepartment'])->get();

        return response()->json(['inventories' => $inventories]);
    }

    public function generatePDF(Request $request)
    {
        $itemId = $request->input('item_id_stock');
        $departmentId = $request->input('department_id_stock');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = TransactionStock::with(['masterItem', 'masterDepartment']);

        if ($itemId) {
            $query->where('item_id', $itemId);
        }
        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }
        $closingBalance = 0;
        $closingBalanceAll = TransactionStock::where('item_id', $itemId)->where('department_id', $departmentId)->whereDate('transaction_date', '<', $startDate)
            ->get();
        foreach ($closingBalanceAll as $closing) {
            $closingBalance += $closing->in - $closing->out;
        }

        if ($startDate && $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate])->get();
        }

        $transactions = $query->get();
        $item = MasterItem::where('id', $itemId)->first();
        $department = MasterDepartment::where('id', $departmentId)->first();
        $data = [
            'title' => 'Kartu Stok',
            'transactions' => $transactions,
            'itemName' => $item->name,
            'departmentName' => $department->name,
            'closingBalance' => $closingBalance,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        $pdf = Pdf::loadView('stocks.generate_pdf', $data);
        return $pdf->download('report_stock.pdf');
    }
}
