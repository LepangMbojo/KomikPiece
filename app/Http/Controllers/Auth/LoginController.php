<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import model User

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Cari pengguna berdasarkan email terlebih dahulu untuk memeriksa status banned mereka
        $user = User::where('email', $credentials['email'])->first();

        // Periksa apakah pengguna ada dan apakah mereka dibanned
        if ($user && $user->is_banned) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Akun Anda telah dibanned.'], 403); // 403 Forbidden
            }
            return back()->withErrors([
                'email' => 'Akun Anda telah dibanned.',
            ])->onlyInput('email');
        }

        // Lanjutkan dengan otentikasi hanya jika pengguna tidak dibanned atau tidak ada
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Respon jika requestnya AJAX
            if ($request->ajax()) {
                return response()->json(['message' => 'Login sukses']);
            }

            return redirect()->intended('/index');
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}