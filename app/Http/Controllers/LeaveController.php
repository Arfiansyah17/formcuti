<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class LeaveController extends Controller
{
    // Tampilkan form edit untuk cuti berdasarkan ID
    public function edit($id)
    {
        $leave = Leave::findOrFail($id);
        return view('leaves.edit', compact('leave'));
    }    

    // Update data cuti berdasarkan ID
    public function update(Request $request, $id)
{
    $leave = Leave::findOrFail($id);

    // Validasi input jika diperlukan
    $request->validate([
        'full_name' => 'required|string|max:255',
        'section' => 'required|string|max:255', // Validasi untuk field section
        'duration' => 'required|integer',
        'reason' => 'required|string',
        'letter_date' => 'required|date',
        'signature1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'signature2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Update data leave
    $leave->full_name = $request->input('full_name');
    $leave->section = $request->input('section'); // Tambahkan field section
    $leave->duration = $request->input('duration');
    $leave->reason = $request->input('reason');
    $leave->letter_date = $request->input('letter_date');

    // Upload new signatures if provided
    if ($request->hasFile('signature1')) {
        $leave->signature1 = $request->file('signature1')->store('signatures', 'public');
    }

    if ($request->hasFile('signature2')) {
        $leave->signature2 = $request->file('signature2')->store('signatures', 'public');
    }

    $leave->save();

    return redirect()->route('admin.dashboard')->with('success', 'Data berhasil diperbarui');
}


    // Tampilkan semua data cuti
    public function index()
    {
        // Mengambil semua data leaves dari database
        $leaves = Leave::all();
        
        // Menghitung jumlah leaves yang disetujui
        $approvedLeaves = Leave::where('status', 'approved')->count();
        
        return view('leaves.index', compact('leaves', 'approvedLeaves'));
    }

    // Hapus data cuti berdasarkan ID
    public function destroy($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'Data berhasil dihapus!');
    }

    

    // Tampilkan form untuk membuat cuti baru
    public function create()
    
    {
        $names = [
            'Budi Santoso',
            'Siti Nurhaliza',
            'Andi Wijaya',
            'Rina Sari',
            'Dedi Kurniawan',
            'Maya Putri',
            'Rizky Ramadhan',
            'Indah Permatasari',
            'Adi Saputra',
            'Lina Mulyani'
        ];
        

        return view('leaves.create', compact('names'));
    }
   
    // Generate PDF untuk cuti berdasarkan ID
   // app/Http/Controllers/LeaveController.php
  // LeaveController.php
  public function generatePdf($id)
{
    $leave = Leave::findOrFail($id);

    // Tentukan template PDF berdasarkan section
    $template = 'pdf.leave_default'; // Default template jika section tidak dikenali

    switch ($leave->section) {
        case 'HRD':
            $template = 'pdf.leave_hrd';
            break;
        case 'IT':
            $template = 'pdf.leave_it';
            break;
        case 'Finance':
            $template = 'pdf.leave_finance';
            break;
        case 'Marketing':
            $template = 'pdf.leave_marketing';
            break;
    }

    $pdf = PDF::loadView($template, compact('leave'))
               ->setPaper([0, 0, 210, 330], 'portrait'); // Ukuran F4 dalam mm

    return $pdf->download('leave-request-' . $id . '.pdf');
}

  
   
public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'full_name' => 'required|string',
        'section' => 'required|string',
        'duration' => 'required|string',
        'reason' => 'required|string',
        'letter_date' => 'required|date',
        'signature1' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        'signature2' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
    ]);

    try {
        // Simpan file tanda tangan jika ada
        $signature1Path = null;
        $signature2Path = null;

        if ($request->hasFile('signature1')) {
            $signature1Path = $request->file('signature1')->store('signatures', 'public');
        }

        if ($request->hasFile('signature2')) {
            $signature2Path = $request->file('signature2')->store('signatures', 'public');
        }

        // Simpan data ke database
        Leave::create([
            'full_name' => $request->input('full_name'),
            'section' => $request->input('section'),
            'duration' => $request->input('duration'),
            'reason' => $request->input('reason'),
            'letter_date' => $request->input('letter_date'),
            'signature1' => $signature1Path,
            'signature2' => $signature2Path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Data berhasil disimpan.'], 200);
    } catch (\Exception $e) {
        // Tangani kesalahan dan log jika perlu
        Log::error('Error storing leave data: ' . $e->getMessage());

        return response()->json(['error' => 'Gagal menyimpan data.'], 500);
    }
}
}