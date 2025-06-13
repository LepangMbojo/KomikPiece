<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // <-- PASTIKAN ADA INI UNTUK MENGIMPOR MODEL USER

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

        // 1. Cari pengguna berdasarkan email
        $user = User::where('email', $credentials['email'])->first(); //

        // 2. Periksa apakah pengguna ada dan apakah dia diblokir
        if ($user && $user->is_banned) { //
            if ($request->ajax()) {
                return response()->json(['message' => 'Akun Anda telah diblokir. Silakan hubungi administrator.'], 403); // 403 Forbidden
            }

            return back()->withErrors([
                'email' => 'Akun Anda telah diblokir. Silakan hubungi administrator.',
            ])->onlyInput('email');
        }

        // 3. Jika pengguna tidak diblokir, coba proses login normal
        if (Auth::attempt($credentials)) { //
            $request->session()->regenerate();

            // Respon jika requestnya AJAX
            if ($request->ajax()) {
                return response()->json(['message' => 'Login sukses']);
            }

            return redirect()->intended('/index');
        }

        // 4. Jika login gagal (email/password salah)
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