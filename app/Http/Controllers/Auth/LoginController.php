<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 

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


        $user = User::where('email', $credentials['email'])->first();


        if ($user && $user->is_banned) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Akun Anda telah dibanned.'], 403); 
            }
            return back()->withErrors([
                'email' => 'Akun Anda telah dibanned.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

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