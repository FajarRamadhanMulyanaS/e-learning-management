<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa; // <-- Pastikan di-import
use App\Models\Kelas; // <-- Pastikan di-import
use App\Models\Guru;  // <-- Pastikan di-import
use App\Models\Course; // <-- Tambahkan ini (berdasarkan index() lama Anda)
use App\Models\Mapel; // <-- Tambahkan ini (alternatif jika Course tidak ada)
use App\Imports\SiswaImport;
use App\Imports\GuruImport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; // <-- Tambahkan ini untuk update
use Maatwebsite\Excel\Facades\Excel; // <-- Tambahkan ini jika belum ada (untuk import)
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini jika belum ada


class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     */
    public function index()
    {
        // Ambil data ringkasan untuk dashboard
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru = User::where('role', 'guru')->count();
        // Coba ambil dari Mapel jika Course tidak ada
        $totalMataPelajaran = Mapel::count(); // Atau gunakan Course::count() jika model itu ada

        return view('admin.dashboard', compact('totalSiswa', 'totalGuru', 'totalMataPelajaran'));
    }

    // ... (method profil, editProfil, updateProfil, downloadTemplate, importSiswa, importGuru TIDAK BERUBAH) ...

     /**
     * !! METHOD BARU DITAMBAHKAN KEMBALI !!
     * Tampilkan daftar guru
     */
    public function listGuru()
    {
        // Ambil user yang rolenya 'guru' beserta relasi 'guru' (untuk NIP, dll)
        $users = User::where('role', 'guru')->with('guru')->get();
        return view('admin.guru.index', compact('users'));
    }

    /**
     * Menyimpan data guru baru
     * (Saya ambil dari kode Anda sebelumnya)
     */
     public function storeGuru(Request $request)
     {
         // Validasi input
         $request->validate([
             'nip' => 'required|string|max:50|unique:guru,nip',
             'username' => 'required|string|max:255|unique:users,username',
             'alamat' => 'required|string|max:255',
             'tgl_lahir' => 'required|string|max:30', // Sebaiknya tipe date
             'telepon' => 'required|string|max:20',
             'gender' => 'required|in:Laki-laki,Perempuan',
             'jabatan' => 'required|string|max:50',
         ]);

         DB::beginTransaction();
         try {
             // Simpan guru sebagai user dengan role guru
             $user = User::create([
                 'username' => $request->username,
                 'password' => bcrypt('123456'), // default password
                 'role' => 'guru',
                 // Tambahkan foto default jika perlu
                 // 'foto' => 'images/default_guru.png'
             ]);

             // Pastikan user_id terkait dengan guru
             Guru::create([ // <-- Pastikan nama model Guru benar (G besar)
                 'user_id' => $user->id, // Menghubungkan guru dengan user
                 'nip' => $request->nip,
                 'telepon' => $request->telepon,
                 'gender' => $request->gender,
                 'alamat' => $request->alamat,
                 'tgl_lahir' => $request->tgl_lahir,
                 'jabatan' => $request->jabatan,
             ]);

             DB::commit();
             return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan'); // Gunakan route()

         } catch (\Exception $e) {
             DB::rollBack();
             Log::error('Error saat admin menambah guru: ' . $e->getMessage());
              if (str_contains($e->getMessage(), 'Duplicate entry')) {
                 if (str_contains($e->getMessage(), 'guru_nip_unique')) {
                    return redirect()->back()->withErrors(['nip' => 'NIP sudah terdaftar.'])->withInput();
                 }
                 if (str_contains($e->getMessage(), 'users_username_unique')) {
                    return redirect()->back()->withErrors(['username' => 'Username sudah terdaftar.'])->withInput();
                 }
              }
             return redirect()->back()->withErrors(['error' => 'Gagal menambahkan data guru. Terjadi kesalahan.'])->withInput();
         }
     }


     /**
      * Memperbarui data guru
      * (Saya ambil dari kode Anda sebelumnya, dengan perbaikan parameter $id)
      */
     public function updateGuru(Request $request, $id) // <-- Parameter sudah $id
     {
        // Validasi input
        $request->validate([
            // Gunakan Rule::unique untuk mengabaikan ID saat ini
            'nip' => ['required','string','max:50', Rule::unique('guru')->ignore($id, 'user_id')],
            'username' => ['required','string','max:255', Rule::unique('users')->ignore($id)],
            'telepon' => 'required|string|max:20',
            'gender' => 'required|string|in:Laki-laki,Perempuan', // Sebaiknya ENUM di DB
            'alamat' => 'required|string|max:255', // Naikkan max length jika perlu
            'tgl_lahir' => 'required|string|max:30', // Sebaiknya tipe date
            'jabatan' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();
        try {
            // Cari data user dan guru berdasarkan id user
            $user = User::where('role', 'guru')->findOrFail($id); // <-- Gunakan $id
            $guru = Guru::where('user_id', $id)->firstOrFail();   // <-- Gunakan $id

            // Update data user
            $user->username = $request->username;
             if ($request->hasFile('foto')) {
                 // Hapus foto lama jika ada dan bukan default
                 if ($user->foto && $user->foto != 'images/default_guru.png' && file_exists(public_path('images/profil_guru/' . $user->foto))) {
                     unlink(public_path('images/profil_guru/' . $user->foto));
                 }
                 $file = $request->file('foto');
                 $filename = time() . '_' . $file->getClientOriginalName();
                 $file->move(public_path('images/profil_guru'), $filename); // Sesuaikan path jika perlu
                 $user->foto = $filename; // Simpan nama file saja
             }
            $user->save();

            // Update data guru
            $guru->nip = $request->nip;
            $guru->telepon = $request->telepon;
            $guru->alamat = $request->alamat;
            $guru->tgl_lahir = $request->tgl_lahir;
            $guru->gender = $request->gender;
            $guru->jabatan = $request->jabatan;
            $guru->save();

            DB::commit();
            return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diupdate'); // Gunakan route()

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat admin update guru: ' . $e->getMessage());
            // Kirim error spesifik jika bisa
             if (str_contains($e->getMessage(), 'Duplicate entry')) {
                 if (str_contains($e->getMessage(), 'guru_nip_unique')) {
                    return redirect()->back()->withErrors(['nip' => 'NIP sudah terdaftar untuk guru lain.'])->withInput();
                 }
                  if (str_contains($e->getMessage(), 'users_username_unique')) {
                    return redirect()->back()->withErrors(['username' => 'Username sudah terdaftar untuk pengguna lain.'])->withInput();
                 }
            }
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui data guru. Terjadi kesalahan.'])->withInput();
        }
     }

     /**
      * Menghapus data guru
      * (Saya ambil dari kode Anda sebelumnya, dengan perbaikan parameter $id)
      */
     public function deleteGuru($id) // <-- Parameter sudah $id
     {
         DB::beginTransaction();
         try {
             // Cari guru berdasarkan id dan hapus
             $user = User::where('role', 'guru')->findOrFail($id); // <-- Gunakan $id
             // Menghapus User akan otomatis menghapus Guru jika constraint di db benar
             $user->delete();

             DB::commit();
             return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus'); // Gunakan route()

         } catch (\Exception $e) {
             DB::rollBack();
             Log::error('Error saat admin menghapus guru: ' . $e->getMessage());
             return redirect()->back()->withErrors(['error' => 'Gagal menghapus guru.']);
         }
     }


    /**
     * Menampilkan daftar siswa
     */
    public function listSiswa()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        // Cukup ambil User dengan relasi siswa dan kelasnya
        $users = User::where('role', 'siswa')
                    ->with(['siswa', 'siswa.kelas'])
                    ->get();
        return view('admin.siswa.index', compact('users', 'kelas'));
    }

    /**
     * Menampilkan form tambah siswa
     */
    public function createSiswa()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.siswa.create', compact('kelas'));
    }

    /**
     * Mencari siswa berdasarkan keyword
     */
    public function searchSiswa(Request $request)
    {
        $keyword = $request->get('keyword');
        $kelas = Kelas::orderBy('nama_kelas')->get();
        
        $users = User::where('role', 'siswa')
                    ->with(['siswa', 'siswa.kelas'])
                    ->whereHas('siswa', function($query) use ($keyword) {
                        $query->where('nis', 'like', "%{$keyword}%")
                              ->orWhere('nisn', 'like', "%{$keyword}%");
                    })
                    ->orWhere('username', 'like', "%{$keyword}%")
                    ->get();
        
        return view('admin.siswa.index', compact('users', 'kelas', 'keyword'));
    }


    /**
     * Menyimpan data siswa baru ke database.
     */
    public function storeSiswa(Request $request)
    {
        // ... (Kode storeSiswa Anda sudah benar) ...
         // 1. Validasi Input
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'nis' => 'required|string|max:20|unique:siswa,nis', // Sesuaikan max length jika perlu
            'nisn' => 'required|string|max:20|unique:siswa,nisn', // Sesuaikan max length jika perlu
            'telepon' => 'required|string|max:20',
            'kelas_id' => 'required|integer|exists:kelas,id', // Validasi kelas_id
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:255',
            'tgl_lahir' => 'required|date', // Ubah ke tipe date jika di db juga date
        ]);

        DB::beginTransaction();
        try {
            // Path gambar default
            $defaultPhoto = "images/default.png";

            // 2. Buat User baru (HANYA info login & role, TANPA kelas_id)
            $user = User::create([
                'username' => $validatedData['username'],
                'password' => Hash::make('123456'), // Ganti default password
                'role' => 'siswa',
                'foto' => $defaultPhoto, // Tambahkan foto default
                // Kolom kelas_id TIDAK disimpan di sini
            ]);

            // 3. Buat Siswa baru (Info profil + kelas_id)
            $siswa = Siswa::create([
                'user_id' => $user->id,
                'nis' => $validatedData['nis'],
                'nisn' => $validatedData['nisn'],
                'telepon' => $validatedData['telepon'],
                'kelas_id' => $validatedData['kelas_id'], // <-- KELAS DISIMPAN DI SINI
                'gender' => $validatedData['gender'],
                'alamat' => $validatedData['alamat'],
                'tgl_lahir' => $validatedData['tgl_lahir'],
            ]);

            DB::commit();
            return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat admin menambah siswa: ' . $e->getMessage());
             if (str_contains($e->getMessage(), 'Duplicate entry')) {
                 if (str_contains($e->getMessage(), 'siswa_nis_unique')) {
                    return redirect()->back()->withErrors(['nis' => 'NIS sudah terdaftar.'])->withInput();
                 }
                 if (str_contains($e->getMessage(), 'siswa_nisn_unique')) {
                    return redirect()->back()->withErrors(['nisn' => 'NISN sudah terdaftar.'])->withInput();
                 }
                  if (str_contains($e->getMessage(), 'users_username_unique')) {
                    return redirect()->back()->withErrors(['username' => 'Username sudah terdaftar.'])->withInput();
                 }
            }
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan siswa. Terjadi kesalahan.'])->withInput();
        }
    }

    /**
     * Memperbarui data siswa di database.
     */
    public function updateSiswa(Request $request, $id)
    {
        // ... (Kode updateSiswa Anda sudah benar) ...
         $user = User::where('role', 'siswa')->findOrFail($id); // <-- BERUBAH DI SINI
        $siswa = $user->siswa;

        if (!$siswa) {
            return redirect()->back()->withErrors(['error' => 'Data detail siswa tidak ditemukan.']);
        }

        // 1. Validasi Input (gunakan Rule::unique untuk mengabaikan data saat ini)
        $validatedData = $request->validate([
            'username' => ['required','string','max:255', Rule::unique('users')->ignore($user->id)],
            'nis' => ['required','string','max:20', Rule::unique('siswa')->ignore($siswa->id)], // Sesuaikan max length
            'nisn' => ['required','string','max:20', Rule::unique('siswa')->ignore($siswa->id)], // Sesuaikan max length
            'telepon' => 'required|string|max:20',
            'kelas_id' => 'required|integer|exists:kelas,id', // Validasi kelas_id dari dropdown
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:255',
            'tgl_lahir' => 'required|date', // Ubah ke tipe date jika di db juga date
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validasi foto
        ]);

        DB::beginTransaction();
        try {
            // 2. Update User (HANYA username & foto, JANGAN kelas_id)
            $user->username = $validatedData['username'];
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada dan bukan default
                if ($user->foto && $user->foto != 'images/default.png' && file_exists(public_path('images/profil_siswa/' . $user->foto))) {
                    unlink(public_path('images/profil_siswa/' . $user->foto));
                }
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/profil_siswa'), $filename);
                $user->foto = $filename; // Simpan nama file saja
            }
            $user->save();

            // 3. Update Siswa (Info profil + kelas_id)
            $siswa->nis = $validatedData['nis'];
            $siswa->nisn = $validatedData['nisn'];
            $siswa->telepon = $validatedData['telepon'];
            $siswa->kelas_id = $validatedData['kelas_id']; // <-- KELAS DISIMPAN/DIUPDATE DI SINI
            $siswa->gender = $validatedData['gender'];
            $siswa->alamat = $validatedData['alamat'];
            $siswa->tgl_lahir = $validatedData['tgl_lahir'];
            $siswa->save();

            DB::commit();
            return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat admin update siswa: ' . $e->getMessage());
             // Kirim error spesifik jika bisa
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                 if (str_contains($e->getMessage(), 'siswa_nis_unique')) {
                    return redirect()->back()->withErrors(['nis' => 'NIS sudah terdaftar untuk siswa lain.'])->withInput();
                 }
                 if (str_contains($e->getMessage(), 'siswa_nisn_unique')) {
                    return redirect()->back()->withErrors(['nisn' => 'NISN sudah terdaftar untuk siswa lain.'])->withInput();
                 }
                  if (str_contains($e->getMessage(), 'users_username_unique')) {
                    return redirect()->back()->withErrors(['username' => 'Username sudah terdaftar untuk pengguna lain.'])->withInput();
                 }
            }
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui data siswa. Terjadi kesalahan.'])->withInput();
        }
    }

    /**
     * Menghapus data siswa.
     */
    public function deleteSiswa($id)
    {
        // ... (Kode deleteSiswa Anda sudah benar) ...
         DB::beginTransaction();
        try {
            $user = User::where('role', 'siswa')->findOrFail($id); // <-- BERUBAH DI SINI
            // Menghapus User akan otomatis menghapus Siswa jika constraint di db benar
            $user->delete();

            DB::commit();
            return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat admin menghapus siswa: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus siswa.']);
        }
    }

    /**
     * Menampilkan profil admin
     */
    public function profil($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admin.profil.profil_admin', compact('admin'));
    }

    /**
     * Menampilkan form edit profil admin
     */
    public function editProfil($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admin.profil.edit_profil', compact('admin'));
    }

    /**
     * Memperbarui profil admin
     */
    public function updateProfil(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        // Validasi input
        $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();
        try {
            // Update data admin
            $admin->username = $request->username;
            $admin->email = $request->email;

            // Handle foto upload
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada dan bukan default
                if ($admin->foto && $admin->foto != 'images/default.png' && file_exists(public_path($admin->foto))) {
                    unlink(public_path($admin->foto));
                }
                
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/admin_photos'), $filename);
                $admin->foto = 'images/admin_photos/' . $filename;
            }

            $admin->save();

            DB::commit();
            return redirect()->route('admin.profil_admin', $admin->id)->with('success', 'Profil berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat admin update profil: ' . $e->getMessage());
            
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                if (str_contains($e->getMessage(), 'users_username_unique')) {
                    return redirect()->back()->withErrors(['username' => 'Username sudah terdaftar untuk pengguna lain.'])->withInput();
                }
                if (str_contains($e->getMessage(), 'users_email_unique')) {
                    return redirect()->back()->withErrors(['email' => 'Email sudah terdaftar untuk pengguna lain.'])->withInput();
                }
            }
            
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui profil. Terjadi kesalahan.'])->withInput();
        }
    }

    /**
     * Download template untuk import siswa
     */
    public function downloadTemplate()
    {
        $filePath = public_path('templates/template_siswa.xlsx');
        if (!file_exists($filePath)) {
            abort(404, 'Template file not found.');
        }
        return response()->download($filePath, 'template_siswa.xlsx');
    }

    /**
     * Import data siswa dari Excel
     */
    public function importSiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diimport.');
        } catch (\Exception $e) {
            Log::error('Error saat import siswa: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal mengimport data siswa. Periksa format file.'])->withInput();
        }
    }

    /**
     * Import data guru dari Excel
     */
    public function importGuru(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new GuruImport, $request->file('file'));
            return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diimport.');
        } catch (\Exception $e) {
            Log::error('Error saat import guru: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal mengimport data guru. Periksa format file.'])->withInput();
        }
    }
}

