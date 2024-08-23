<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartment;
use App\Models\MasterItem;
use App\Models\TransactionInventory;
use App\Models\TransactionStock;
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
        $item_id = $request->input('item_id');
        $department_id = $request->input('department_id');

        $query = TransactionInventory::query();

        if ($item_id) {
            $query->where('item_id', $item_id);
        }

        if ($department_id) {
            $query->where('department_id', $department_id);
        }

        $inventories = $query->with(['masterItem', 'masterDepartment'])->get();

        return response()->json(['inventories' => $inventories]);
    }
}
