<?php

namespace App\Http\Controllers;

use App\Models\MasterCompany;
use App\Models\MasterRole;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // create
    public function index()
    {
        $users = User::with(['masterRole', 'masterCompany'])->get();
        return view('users.index', compact(['users'])); // Mengirim data ke view
    }



    public function create()
    {
        $masterRole = MasterRole::all();
        $masterCompany = MasterCompany::all();
        return view('users.create', compact(['masterRole', 'masterCompany']));
    }

    public function store(Request $request)
    {
        $data = [];

        for ($i = 0; $i < count($request->name); $i++) {
            $data[] = [
                'nip' => $request->nip[$i],
                'name' => $request->name[$i],
                'email' => $request->email[$i],
                'password' => Hash::make($request->password[$i]),
                'address' => $request->address[$i],
                'position' => $request->position[$i],
                'company_id' => $request->company_id[$i],
                'role_id' => $request->role_id[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        User::insert($data);

        // return redirect()->back()->with('success', 'Records inserted successfully!');
        return redirect()->route('users.index')->with('succcess', 'Penambahan berhasil');
    }
    // end create


    // edit
    public function edit($id)
    {
        $masterCompany = MasterCompany::all();
        $masterRole = MasterRole::all();
        $user = User::findOrFail($id);
        return view('users.edit', compact(['user', 'masterCompany', 'masterRole']));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->nip = $request->input('nip');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password')) {
            $user->password = $request->input('password');
        }
        $user->address = $request->input('address');
        $user->position = $request->input('position');
        $user->company_id = $request->input('company_id');
        $user->role_id = $request->input('role_id');

        $user->save();

        return redirect()->route('users.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
    }
    // end edit
}
