<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        // Login sebagai admin atau pengguna umum dengan email
        if (filter_var($request->identifier, FILTER_VALIDATE_EMAIL)) {
            if (Auth::attempt(['email' => $request->identifier, 'password' => $request->password])) {
                return $this->redirectBasedOnRole();
            }
        }

        // Login sebagai guru menggunakan NIP atau email
        $guru = Guru::where('nip', $request->identifier)
            ->orWhereHas('user', function($query) use ($request) {
                $query->where('email', $request->identifier);
            })->first();

        if ($guru && Auth::validate(['id' => $guru->user_id, 'password' => $request->password])) {
            Auth::loginUsingId($guru->user_id);
            return redirect()->route('guru.index');
        }

        // Login sebagai siswa menggunakan NIS atau email
        $siswa = Siswa::where('nis', $request->identifier)
            ->orWhereHas('user', function($query) use ($request) {
                $query->where('email', $request->identifier);
            })->first();

        if ($siswa && Auth::validate(['id' => $siswa->user_id, 'password' => $request->password])) {
            Auth::loginUsingId($siswa->user_id);
            return redirect()->route('siswa.index');
        }

        // Jika login gagal
        return back()->withErrors(['identifier' => 'Email/NIP/NIS atau password salah.']);
    }

    protected function redirectBasedOnRole()
    {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role == 'guru') {
            return redirect()->route('guru.index');
        } elseif (Auth::user()->role == 'siswa') {
            return redirect()->route('siswa.index');
        }

        return redirect('/home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('status', 'Anda telah logout.');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
