<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LandingContent;
use Illuminate\Support\Facades\Storage;

class LandingContentController extends Controller
{
    /**
     * Tampilkan halaman edit landing page admin.
     */
    public function index()
    {
        // Ambil semua konten landing page dari tabel landing_contents
        $contents = LandingContent::all()->pluck('value', 'key');
        return view('admin.landing.edit', compact('contents'));
    }

    /**
     * Proses update konten landing page.
     */
    public function update(Request $request)
    {
        // Validasi input (opsional bisa ditambah sesuai kebutuhan)
        $request->validate([
            'logo_path' => 'nullable|image|max:2048',
            'favicon_path' => 'nullable|image|max:1024',
            'hero_bg1' => 'nullable|image|max:4096',
            'hero_bg2' => 'nullable|image|max:4096',
            'about_image' => 'nullable|image|max:4096',
            // tambahkan rule validasi lain untuk text field jika perlu
        ]);

        // Ambil semua input kecuali token
        $inputs = $request->except('_token');

        // 🔧 Gunakan allFiles() agar file berupa Illuminate\Http\UploadedFile (punya method store())
        foreach ($request->allFiles() as $fileKey => $file) {
            if ($file) {
                // Hapus file lama jika ada
                $old = LandingContent::where('key', $fileKey)->value('value');
                if ($old && str_starts_with($old, 'storage/')) {
                    $oldPath = substr($old, strlen('storage/')); // hapus prefix 'storage/'
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                // Simpan file baru ke storage/public/landing
                $stored = $file->store('landing', 'public');
                $inputs[$fileKey] = 'storage/' . $stored; // simpan path yang bisa diakses via asset()
            }
        }

        // Simpan semua data (teks dan file path) ke tabel landing_contents
        foreach ($inputs as $key => $value) {
            LandingContent::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Konten landing page berhasil diperbarui!');
    }
}
