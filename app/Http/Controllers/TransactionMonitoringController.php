<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartment;
use App\Models\MasterItem;
use App\Models\TransactionMonitoringForm;
use App\Models\TransactionMonitoringLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionMonitoringController extends Controller
{
    public function index()
    {
        $masterItems = MasterItem::all();
        $masterDepartments = MasterDepartment::all();
        $monitoringForms = TransactionMonitoringForm::with(['masterItem', 'masterDepartment', 'user'])->get();
        return view('monitorings.index', compact(['monitoringForms', 'masterItems', 'masterDepartments']));
    }

    public function filter(Request $request)
    {
        $itemId = $request->input('item_id');
        $departmentId = $request->input('department_id');

        $query = TransactionMonitoringForm::query();

        if ($itemId) {
            $query->where('item_id', $itemId);
        }

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        $monitorings = $query->with(['masterItem', 'masterDepartment', 'user'])->get();

        return response()->json(['monitorings' => $monitorings]);
        // akhir
    }

    public function create()
    {
        $maxId = TransactionMonitoringForm::max('id');
        $newId = $maxId + 1;
        $masterItems = MasterItem::all();
        $masterDepartments = MasterDepartment::all();
        return view('monitorings.create', compact(['newId', 'masterItems', 'masterDepartments']));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $id = $request->input('id');
            $transaction_date = $request->input('transaction_date');
            $item_id = $request->input('item_id');
            $department_id = $request->input('department_id');
            $user_id = $request->input('user_id');
            $code = $request->input('code');
            $period = $request->input('period');
            $description = $request->input('description');
            $quantity = $request->input('quantity');
            $cost = $request->input('cost');
            $status = $request->input('status');

            // Mengambil dan menyimpan file gambar jika ada
            if ($request->hasFile('photo_proof')) {
                $photo_proof_path = $request->file('photo_proof')->store('proofs', 'public');
            } else {
                $photo_proof_path = null; // atau default value
            }

            // Menyimpan data ke dalam model Monitoring
            TransactionMonitoringForm::create([
                'id' => $id,
                'transaction_date' => $transaction_date,
                'item_id' => $item_id,
                'department_id' => $department_id,
                'user_id' => $user_id,
                'code' => $code,
                'period' => $period,
                'description' => $description,
                'quantity' => $quantity,
                'cost' => $cost,
                'photo_proof' => $photo_proof_path, // Menyimpan path file, bukan isi file
                'status' => $status,
            ]);

            TransactionMonitoringLog::create([
                'transaction_date' => $transaction_date,
                'monitoring_id' => $id,
                'item_id' => $item_id,
                'department_id' => $department_id,
                'description' => $description,
                'quantity' => $quantity,
                'cost' => $cost,
                'photo_proof' => $photo_proof_path, // Menyimpan path file, bukan isi file
            ]);

            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('monitorings.index')->with('success', 'Data monitoring berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file jika terjadi kesalahan
            if (isset($photo_proof_path)) {
                Storage::disk('public')->delete($photo_proof_path);
            }

            // Redirect with error message
            return redirect()->route('monitorings.create')->with('error', 'Gagal menambahkan monitoring');
        }
        // Mengambil data input secara manual

    }

    public function detail($id)
    {
        $monitoringForm = TransactionMonitoringForm::with(['masterItem', 'masterDepartment', 'user'])->findOrFail($id);
        $monitoringLogs = TransactionMonitoringLog::with(['masterItem', 'masterDepartment', 'monitoringForm'])->where('monitoring_id', $id)->get();
        return view('monitorings.detail', compact(['monitoringForm', 'monitoringLogs', 'id']));
    }

    public function edit($id)
    {
        $monitoringForm = TransactionMonitoringForm::findOrFail($id);
        return view('monitorings.edit', compact(['monitoringForm', 'id']));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $form = TransactionMonitoringForm::findOrFail($id);
            $form->id = $request->input('id');
            $form->transaction_date = $request->input('transaction_date');
            $form->item_id = $request->input('item_id');
            $form->department_id = $request->input('department_id');
            $form->user_id = $request->input('user_id');
            $form->code = $request->input('code');
            $form->period = $request->input('period');
            $form->status = $request->input('status');
            $form->description = $request->input('description');
            $form->quantity = $request->input('quantity');
            $form->cost = $request->input('cost');
            if ($request->hasFile('photo_proof')) {
                $photo_proof_path = $request->file('photo_proof')->store('proofs', 'public');
            } else {
                $photo_proof_path = null; // atau default value
            }
            $form->photo_proof = $photo_proof_path;
            $form->save();

            TransactionMonitoringLog::create([
                'transaction_date' => $request->input('transaction_date'),
                'monitoring_id' => $id,
                'item_id' => $request->input('item_id'),
                'department_id' => $request->input('department_id'),
                'description' => $request->input('description'),
                'quantity' => $request->input('quantity'),
                'cost' => $request->input('cost'),
                'photo_proof' => $photo_proof_path, // Menyimpan path file, bukan isi file
            ]);
            DB::commit();
            return redirect()->route('monitorings.index'); // Redirect ke halaman index atau sesuai kebutuhan Anda
        } catch (\Exception $e) {
            return redirect()->route('monitorings.index');
        }
    }

    public function process(Request $request, $id)
    {
        // Validate the incoming status input
        $request->validate([
            'status' => 'required|string|max:255', // Adjust the validation rules as needed
        ]);

        // Find the record by its ID
        $form = TransactionMonitoringForm::findOrFail($id);

        // Update only the status field
        $form->update([
            'status' => $request->input('status'),
        ]);

        // Redirect with success message
        return redirect()->route('monitorings.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function postpone(Request $request, $id)
    {
        // Validate the incoming status input
        $request->validate([
            'status' => 'required|string|max:255', // Adjust the validation rules as needed
        ]);

        // Find the record by its ID
        $form = TransactionMonitoringForm::findOrFail($id);

        // Update only the status field
        $form->update([
            'status' => $request->input('status'),
        ]);

        // Redirect with success message
        return redirect()->route('monitorings.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function complete(Request $request, $id)
    {
        // Validate the incoming status input
        $request->validate([
            'status' => 'required|string|max:255', // Adjust the validation rules as needed
        ]);

        // Find the record by its ID
        $form = TransactionMonitoringForm::findOrFail($id);

        // Update only the status field
        $form->update([
            'status' => $request->input('status'),
        ]);

        // Redirect with success message
        return redirect()->route('monitorings.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function cancel(Request $request, $id)
    {
        // Validate the incoming status input
        $request->validate([
            'status' => 'required|string|max:255', // Adjust the validation rules as needed
        ]);

        // Find the record by its ID
        $form = TransactionMonitoringForm::findOrFail($id);

        // Update only the status field
        $form->update([
            'status' => $request->input('status'),
        ]);

        // Redirect with success message
        return redirect()->route('monitorings.index')->with('success', 'Status berhasil diperbarui.');
    }
}
