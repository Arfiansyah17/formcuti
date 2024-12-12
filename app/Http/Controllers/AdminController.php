<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Leave;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        $captcha = Str::random(6); // Generate random 6-character CAPTCHA
        Session::put('captcha', $captcha); // Store it in the session
        return view('admin.login', compact('captcha'));
    }

    public function index()
    {
        $leaves = Leave::all();
        
        // Menghitung tanggal berakhir cuti untuk setiap leave dengan validasi
        foreach ($leaves as $leave) {
            if (is_numeric($leave->duration)) {
                $leave->end_date = Carbon::parse($leave->letter_date)
                    ->addDays($leave->duration - 1)
                    ->format('Y-m-d');
            } else {
                $leave->end_date = null; // Handle error or set a default value
            }
        }

        $totalLeaves = $leaves->count();

        return view('admin.dashboard', compact('leaves', 'totalLeaves'));
    }

    public function dashboard()
    {
        $leaves = Leave::all();

        // Menghitung tanggal berakhir cuti untuk setiap leave dengan validasi
        foreach ($leaves as $leave) {
            if (is_numeric($leave->duration)) {
                $leave->end_date = Carbon::parse($leave->letter_date)
                    ->addDays($leave->duration - 1)
                    ->format('Y-m-d');
            } else {
                $leave->end_date = null; // Handle error or set a default value
            }
        }

        $approvedLeaves = Leave::where('status', 'approved')->count();
        $pendingLeaves = Leave::where('status', 'pending')->count();
        $totalLeaves = Leave::count();

        return view('admin.dashboard', compact('leaves', 'approvedLeaves', 'pendingLeaves', 'totalLeaves'));
    }

    public function generatePdf($id)
    {
        try {
            $leave = Leave::findOrFail($id);
            $pdf = PDF::loadView('pdf.leaves', ['leave' => $leave]);
            return $pdf->stream('Surat_Cuti_' . $leave->full_name . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menghasilkan PDF'], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required',
        ]);

        if ($request->input('captcha') !== Session::get('captcha')) {
            return redirect()->route('admin.login')->withErrors('Captcha is incorrect.');
        }

        Session::forget('captcha');

        $credentials = $request->only('username', 'password');

        if ($credentials['username'] === 'admin' && $credentials['password'] === 'onlyadmin') {
            Auth::loginUsingId(1); // Pastikan ID 1 adalah admin yang terdaftar
            if (Auth::check()) {
                return redirect()->route('admin.dashboard');
            } else {
                dd('Login failed');
            }
        }

        return redirect()->route('admin.login')->withErrors('Username or password is incorrect.');
    }

    public function showDashboard()
    {
        $leaves = Leave::all();

        // Menghitung tanggal berakhir cuti untuk setiap leave dengan validasi
        foreach ($leaves as $leave) {
            if (is_numeric($leave->duration)) {
                $leave->end_date = Carbon::parse($leave->letter_date)
                    ->addDays($leave->duration - 1)
                    ->format('Y-m-d');
            } else {
                $leave->end_date = null; // Handle error or set a default value
            }
        }

        $totalLeaves = $leaves->count();
        return view('admin.dashboard', compact('leaves', 'totalLeaves'));
    }
}
?>
