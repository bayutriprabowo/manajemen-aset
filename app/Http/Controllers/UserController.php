<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['masterRole', 'masterCompany'])->get();
        return view('users.index', compact(['users'])); // Mengirim data ke view
    }
}
