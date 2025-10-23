<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Support\Facades\DB; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{

    public function profil()
    {
        $user = Auth::user();
    
        // Pastikan hanya siswa yang bisa akses
        if ($user->role != 'siswa') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    
        // Ambil data siswa berdasarkan relasi user
        $siswa = $user->siswa;
    
        // Ambil kelas dari relasi siswa
        $kelas = $siswa ? $siswa->kelas : null;
    
        return view('siswa.profil.profil_siswa', compact('user', 'siswa', 'kelas'));
    }
    




    public function edit()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        return view('siswa.profil.edit', compact('user', 'siswa'));
    }

    public function updateProfilSiswa(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        $request->validate([
            'username' => 'string|max:255',
            'nis' => 'string|max:20',
            'nisn' => 'string|max:20',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Pastikan Anda menggunakan email yang berbeda.'
        ]);

        // Update data pada tabel 'users'
        $user->username = $request->username;
        $user->email = $request->email ?: null;

        $user->save();

        // Update data pada tabel 'siswa'
        $siswa->nis = $request->nis;
        $siswa->nisn = $request->nisn;
        $siswa->alamat = $request->alamat;
        $siswa->telepon = $request->telepon;

        // Proses upload foto jika ada file yang diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && file_exists(public_path('images/profil_siswa/' . $user->foto))) {
                unlink(public_path('images/profil_siswa/' . $user->foto));
            }

            // Simpan foto baru ke folder public/images/profil_siswa
            $fileName = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->move(public_path('images/profil_siswa'), $fileName);
            $user->foto = $fileName;
            $user->save(); // Simpan nama foto ke tabel 'users'
        }

        // Simpan data siswa
        $siswa->save();

        return redirect()->route('siswa.profil_siswa')->with('success', 'Profil berhasil diperbarui.');
    }


    // ================================================================================================================
// ================================================================================================================

    public function showProfilGuru()
    {
        $userId = Auth::id();

        // Query untuk mendapatkan data guru yang sesuai dengan user yang sedang login
        $guruData = DB::table('users')
            ->join('guru', 'user_id', '=', 'guru.user_id')
            ->select(
                'user_id as user_id',
                'users.username as nama',
                'users.email',
                'guru.nip',
                'guru.alamat',
                'guru.tgl_lahir',
                'guru.telepon',
                'guru.gender',
                'guru.jabatan',
                'users.foto' // Menambahkan kolom foto
            )
            ->where('users.role', 'guru')
            ->where('user_id', $userId)
            ->first();

        return view('guru.profil.profil_guru', compact('guruData'));
    }


    public function updateProfilGuru(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'email' => 'nullable|string|email|max:255', // ubah ke nullable
            'alamat' => 'required|string',
            'tgl_lahir' => 'required|date',
            'telepon' => 'required|string|max:20',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'jabatan' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $userData = User::find($id);
        $guruData = Guru::where('user_id', $id)->first();

        if (!$userData || !$guruData) {
            return redirect()->route('guru.profil')
                ->with('error', 'Data guru atau user tidak ditemukan');
        }

        // Update data di tabel users
        $userData->username = $request->username;
        $userData->email = $request->email;

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($userData->foto && file_exists(public_path('images/profil_guru/' . $userData->foto))) {
                unlink(public_path('images/profil_guru/' . $userData->foto));
            }

            // Simpan foto baru ke folder public/images/profil_guru
            $fileName = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->move(public_path('images/profil_guru'), $fileName);
            $userData->foto = $fileName;
        }

        $userData->save();

        // Update data di tabel guru
        $guruData->nip = $request->nip;
        $guruData->alamat = $request->alamat;
        $guruData->tgl_lahir = $request->tgl_lahir;
        $guruData->telepon = $request->telepon;
        $guruData->gender = $request->gender;
        $guruData->jabatan = $request->jabatan;
        $guruData->save();

        return redirect()->route('guru.profil.profil_guru')
            ->with('success', 'Profil berhasil diperbarui');
    }

}
