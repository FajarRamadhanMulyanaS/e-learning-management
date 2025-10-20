<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }
    public function showChangePasswordForm2()
    {
        return view('auth.change-password2');
    }

    public function updatePasswordadmin(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        // Periksa apakah password lama benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        // Perbarui password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('auth.change-password2')->with('success', 'Password berhasil diubah');
    }


    public function updatePasswordSiswa(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        // Periksa apakah password lama benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        // Perbarui password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('auth.change-password')->with('success', 'Password berhasil diubah');
    }

    public function updatePasswordGuru(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        // Periksa apakah password lama benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        // Perbarui password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('auth.change-password')->with('success', 'Password berhasil diubah');
    }


    // ===============================================================================================================



    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        User::create($request->all());
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus');
    }
}
