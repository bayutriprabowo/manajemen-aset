<?php

namespace App\Http\Controllers;

use App\Models\MasterItemType;
use Illuminate\Http\Request;

class MasterItemTypeController extends Controller
{
    public function index()
    {
        $masterItemTypes = MasterItemType::all();
        return view('master_item_types.index', compact(['masterItemTypes']));
    }
}
