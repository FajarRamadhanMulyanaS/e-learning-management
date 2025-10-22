<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * ======================================================================
     * METHOD BARU UNTUK DASHBOARD SISWA
     * ======================================================================
     * Menampilkan halaman dashboard untuk siswa yang sedang login.
     */
    public function dashboard()
    {
        // Ambil data siswa yang sedang login (termasuk relasi user dan kelas jika perlu)
        $siswa = Siswa::with(['user', 'kelas'])
                      ->where('user_id', auth()->id())
                      ->firstOrFail(); // Gunakan firstOrFail() agar error jika data siswa tidak ada

        // Ganti 'siswa.index' dengan nama file view dashboard siswa Anda yang sebenarnya
        // (Misalnya 'siswa.dashboard' atau 'siswa.home')
        return view('siswa.index', compact('siswa'));
    }

    /**
     * ======================================================================
     * METHOD LAMA UNTUK ADMIN (DIBIARKAN)
     * ======================================================================
     * Menampilkan halaman daftar siswa (index) untuk Admin.
     */
    public function index()
    {
        // Ambil semua kelas untuk modal dropdown
        $kelas = Kelas::orderBy('nama_kelas')->get();

        // Ambil semua user yang 'siswa' beserta relasi siswa dan kelasnya
        $users = User::where('role', 'siswa')
                    ->with(['siswa', 'siswa.kelas'])
                    ->get(); // Anda bisa gunakan paginate() jika datanya banyak

        // Kirim data ke view Admin
        return view('admin.siswa.index', compact('users', 'kelas'));
    }

    /**
     * Menyimpan data siswa baru ke database.
     * (Method ini untuk Admin - DIBIARKAN)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'nis' => 'required|string|unique:siswa,nis',
            'nisn' => 'required|string|unique:siswa,nisn',
            'telepon' => 'required|string',
            'kelas_id' => 'required|integer|exists:kelas,id',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'tgl_lahir' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // 2. Buat User baru
            $user = User::create([
                'username' => $validatedData['username'],
                'password' => Hash::make('password123'), // Ganti dengan password default Anda
                'role' => 'siswa',
            ]);

            // 3. Buat Siswa baru
            $siswa = Siswa::create([
                'user_id' => $user->id,
                'nis' => $validatedData['nis'],
                'nisn' => $validatedData['nisn'],
                'telepon' => $validatedData['telepon'],
                'kelas_id' => $validatedData['kelas_id'],
                'gender' => $validatedData['gender'],
                'alamat' => $validatedData['alamat'],
                'tgl_lahir' => $validatedData['tgl_lahir'],
            ]);

            DB::commit();
            return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menambah siswa: ' . $e->getMessage());
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
     * (Method ini untuk Admin - DIBIARKAN)
     */
    public function updateSiswa(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $siswa = $user->siswa;

        if (!$siswa) {
            return redirect()->back()->withErrors(['error' => 'Data detail siswa tidak ditemukan.']);
        }

        // 1. Validasi Input
        $validatedData = $request->validate([
            'username' => ['required','string','max:255', Rule::unique('users')->ignore($user->id)],
            'nis' => ['required','string', Rule::unique('siswa')->ignore($siswa->id)],
            'nisn' => ['required','string', Rule::unique('siswa')->ignore($siswa->id)],
            'telepon' => 'required|string',
            'kelas_id' => 'required|integer|exists:kelas,id',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'tgl_lahir' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();
        try {
            // 2. Update User
            $user->username = $validatedData['username'];
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/profil_siswa'), $filename);
                $user->foto = $filename;
            }
            $user->save();

            // 3. Update Siswa
            $siswa->nis = $validatedData['nis'];
            $siswa->nisn = $validatedData['nisn'];
            $siswa->telepon = $validatedData['telepon'];
            $siswa->kelas_id = $validatedData['kelas_id'];
            $siswa->gender = $validatedData['gender'];
            $siswa->alamat = $validatedData['alamat'];
            $siswa->tgl_lahir = $validatedData['tgl_lahir'];
            $siswa->save();

            DB::commit();
            return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat update siswa: ' . $e->getMessage());
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
     * (Method ini untuk Admin - DIBIARKAN)
     */
    public function deleteSiswa($userId)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($userId);
            $user->delete();
            DB::commit();
            return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menghapus siswa: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus siswa.']);
        }
    }
}