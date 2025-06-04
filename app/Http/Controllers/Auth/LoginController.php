<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login'); // Pastikan file login.blade.php ada
    }
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

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
