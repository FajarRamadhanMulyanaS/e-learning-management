<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PelajaranController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\GuruMapelController;
use App\Http\Controllers\EssayController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MateriSiswaController;
use App\Http\Controllers\TugasSiswaController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\KoreksiEssayController;
use App\Http\Controllers\ManajemenPilihanGandaController;
use App\Http\Controllers\ManajemenTugasController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\VideoController;
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminJadwalController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return redirect()->route('homepage'); // Redirect to login page
});

Route::get('/home_page', [LandingController::class, 'home'])->name('homepage');
Route::get('/about', [LandingController::class, 'about'])->name('About');
Route::get('/login', [LoginController::class, 'Login'])->name('login'); // Menampilkan halaman login

Route::middleware(['auth'])->group(function () {
    // Route Dashboard Admin
    Route::get('/admin/dashboard', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\AdminController@index');
        }, 'admin');
    })->name('admin.dashboard');

    // Route Dashboard Guru
    Route::get('/guru/index', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\GuruController@index');
        }, 'guru');
    })->name('guru.index');

    // Route Dashboard Siswa
    Route::get('/siswa/index', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\SiswaController@index');
        }, 'siswa');
    })->name('siswa.index');


    // =====================================================================================================================================
// =====================================================================================================================================




    // Route Profile Guru
    Route::get('/guru/profil/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\GuruController@profilGuru', ['id' => $id]);
        }, 'guru'); // Hanya guru yang dapat mengakses route ini
    })->name('guru.profil_guru');

    // Route Profile Admin
    // Route::get('/admin/profile/{id}', function () {
    //     return (new RoleMiddleware)->handle(request(), function () {
    //         return app()->call('App\Http\Controllers\AdminController@profil', ['id' => request()->route('id')]);
    //     }, 'admin');
    // })->name('admin.profil_admin');

    // =====================================================================================================================================
// =====================================================================================================================================


    // CRUD untuk Siswa (Hanya admin yang bisa mengakses)
    Route::get('/admin/siswa/search', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\AdminController@searchSiswa');
        }, 'admin');
    })->name('admin.siswa.search');

    Route::get('/admin/siswa', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\AdminController@listSiswa');
        }, 'admin');
    })->name('admin.siswa.index');

    Route::get('/admin/siswa/create', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\AdminController@createSiswa');
        }, 'admin');
    })->name('admin.siswa.create');

    Route::post('/admin/siswa/store', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\AdminController@storeSiswa');
        }, 'admin');
    })->name('admin.siswa.store');

    Route::get('/admin/siswa/edit/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\AdminController@editSiswa', ['id' => $id]);
        }, 'admin');
    })->name('admin.siswa.editSiswa');

    Route::post('/admin/siswa/update/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\AdminController@updateSiswa', ['id' => $id]);
        }, 'admin');
    })->name('admin.siswa.updateSiswa');

    Route::delete('/admin/siswa/delete/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\AdminController@deleteSiswa', ['id' => $id]);
        }, 'admin');
    })->name('admin.siswa.deleteSiswa');

    // untuk import excel siswa
    Route::post('/admin/siswa/import', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\AdminController@importSiswa');
        }, 'admin');
    })->name('admin.siswa.import'); // Route untuk meng-handle upload Excel

    // route untuk Download Excel siswa
    Route::get('/admin/siswa/download-template', function () {
        $filePath = public_path('templates/template_siswa.xlsx'); // pastikan file ada di folder public/templates
        return response()->download($filePath, 'template_siswa.xlsx');
    })->name('admin.siswa.downloadTemplateSiswa');

    // =====================================================================================================================================
// =====================================================================================================================================

    // CRUD untuk Guru (Hanya admin yang bisa mengakses)
    Route::get('/admin/guru', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\AdminController@listGuru');
        }, 'admin');
    })->name('admin.guru.index');

    Route::get('/admin/guru/create', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\AdminController@createGuru');
        }, 'admin');
    })->name('admin.guru.create');

    Route::post('/admin/guru/store', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\AdminController@storeGuru');
        }, 'admin');
    })->name('admin.guru.storeGuru');

    Route::get('/admin/guru/edit/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\AdminController@editGuru', ['id' => $id]);
        }, 'admin');
    })->name('admin.guru.editGuru');

    Route::post('/admin/guru/update/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\AdminController@updateGuru', ['id' => $id]);
        }, 'admin');
    })->name('admin.guru.updateGuru');

    Route::delete('/admin/guru/delete/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\AdminController@deleteGuru', ['id' => $id]);
        }, 'admin');
    })->name('admin.guru.deleteGuru');

    // untuk import excel guru
    Route::post('/admin/guru/import', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\AdminController@importguru');
        }, 'admin');
    })->name('admin.guru.import'); // Route untuk meng-handle upload Excel

    // route untuk Download Excel guru
    Route::get('/admin/guru/download-template', function () {
        $filePath = public_path('templates/template_guru.xlsx'); // pastikan file ada di folder public/templates
        return response()->download($filePath, 'template_guru.xlsx');
    })->name('admin.guru.downloadTemplateGuru');



    // =====================================================================================================================================
// =====================================================================================================================================

    // Route untuk daftar mata pelajaran
    Route::get('/admin/mapel', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\MapelController@index');
        }, 'admin');
    })->name('admin.mapel.index');

    // Route untuk form tambah mata pelajaran
    Route::get('/admin/mapel/create', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\MapelController@create');
        }, 'admin');
    })->name('admin.mapel.create');

    // Route untuk menyimpan mata pelajaran baru
    Route::post('/admin/mapel/store', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\MapelController@store');
        }, 'admin');
    })->name('admin.mapel.store');

    // Route untuk edit mata pelajaran
    Route::get('/admin/mapel/edit/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\MapelController@edit', ['id' => $id]);
        }, 'admin');
    })->name('admin.mapel.edit');

    // Route untuk update mata pelajaran
    Route::post('/admin/mapel/update/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\MapelController@update', ['id' => $id]);
        }, 'admin');
    })->name('admin.mapel.update');

    // Route untuk delete mata pelajaran
    Route::delete('/admin/mapel/delete/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\MapelController@destroy', ['id' => $id]);
        }, 'admin');
    })->name('admin.mapel.delete');

    // =====================================================================================================================================
// ======================      Route untuk Manajemen Semester        ======================================================
// =====================================================================================================================================

    // Route untuk daftar semester
    Route::get('/admin/semester', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\SemesterController@index');
        }, 'admin');
    })->name('admin.semester.index');

    // Route untuk form tambah semester
    Route::get('/admin/semester/create', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\SemesterController@create');
        }, 'admin');
    })->name('admin.semester.create');

    // Route untuk menyimpan semester baru
    Route::post('/admin/semester/store', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\SemesterController@store');
        }, 'admin');
    })->name('admin.semester.store');

    // Route untuk form edit semester
    Route::get('/admin/semester/edit/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\SemesterController@edit', ['id' => $id]);
        }, 'admin');
    })->name('admin.semester.edit');

    // Route untuk update semester
    Route::post('/admin/semester/update/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\SemesterController@update', ['id' => $id]);
        }, 'admin');
    })->name('admin.semester.update');

    // Route untuk menghapus semester
    Route::delete('/admin/semester/delete/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\SemesterController@destroy', ['id' => $id]);
        }, 'admin');
    })->name('admin.semester.delete');

    // Route untuk mengaktifkan semester
    Route::post('/admin/semester/activate/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\SemesterController@activate', ['id' => $id]);
        }, 'admin');
    })->name('admin.semester.activate');

    // =====================================================================================================================================
// =====================================================================================================================================


    // Route untuk daftar kelas (hanya admin yang bisa mengakses)
    Route::get('/admin/kelas', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\KelasController@index');
        }, 'admin');
    })->name('admin.kelas.index');

    // Route untuk form tambah kelas
    Route::get('/admin/kelas/create', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\KelasController@create');
        }, 'admin');
    })->name('admin.kelas.create');

    // Route untuk menyimpan kelas baru
    Route::post('/admin/kelas/store', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\KelasController@store');
        }, 'admin');
    })->name('admin.kelas.store');

    // Route untuk form edit kelas
    Route::get('/admin/kelas/edit/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\KelasController@edit', ['id' => $id]);
        }, 'admin');
    })->name('admin.kelas.edit');

    // Route untuk update kelas
    Route::post('/admin/kelas/update/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\KelasController@update', ['id' => $id]);
        }, 'admin');
    })->name('admin.kelas.update');

    // Route untuk menghapus kelas
    Route::delete('/admin/kelas/delete/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\KelasController@destroy', ['id' => $id]);
        }, 'admin');
    })->name('admin.kelas.destroy');


    // =====================================================================================================================================
// =====================================================================================================================================

    // Route untuk daftar Guru dengan Mata Pelajaran
    Route::get('/admin/guru-mapel', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\GuruMapelController@index');
        }, 'admin');
    })->name('admin.guru-mapel.index');

    // Route untuk form tambah Guru ke Mata Pelajaran
    Route::get('/admin/guru-mapel/create', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\GuruMapelController@create');
        }, 'admin');
    })->name('admin.guru-mapel.create');

    // Route untuk menyimpan Guru ke Mata Pelajaran baru
    Route::post('/admin/guru-mapel/store', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\GuruMapelController@store');
        }, 'admin');
    })->name('admin.guru-mapel.store');


    // Route untuk update Guru ke Mata Pelajaran
    Route::post('/admin/guru-mapel/update/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\GuruMapelController@update', ['id' => $id]);
        }, 'admin');
    })->name('admin.guru-mapel.update');

    // Route untuk delete Guru ke Mata Pelajaran
    Route::delete('/admin/guru-mapel/destroy/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\GuruMapelController@destroy', ['id' => $id]);
        }, 'admin');
    })->name('admin.guru-mapel.destroy');





    // =====================================================================================================================================
// ======================      Route untuk Manajemen Ujian / Tugas  HAL GURU        ======================================================
// =====================================================================================================================================


    // Route untuk Manajemen ujian
    Route::get('/guru/manajemen_ujian', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\ManajemenTugasController@index');
        }, 'guru');
    })->name('guru.manajemen-ujian.index');

    // Route untuk Manajemen ujian menggunakan POST
    Route::post('/guru/manajemen_ujian/store', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\Http\Controllers\ManajemenTugasController@store');
        }, 'guru');
    })->name('guru.manajemen-ujian.store');

    // Route untuk Manajemen ujian
    Route::get('/guru/manajemen_ujian/detail/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\ManajemenTugasController@show', ['id' => $id]);
        }, 'guru');  // Sesuaikan dengan peran siswa
    })->name('guru.manajemen-ujian.detailsoal');

    Route::post('/guru/manajemen_ujian/update/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\ManajemenTugasController@update', ['id' => $id]);
        }, 'guru');  // Sesuaikan dengan peran siswa
    })->name('guru.manajemen-ujian.update');

    Route::delete('/guru/manajemen_ujian/destroy/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\Http\Controllers\ManajemenTugasController@destroy', ['id' => $id]);
        }, 'guru');
    })->name('guru.manajemen-ujian.destroy');

    // =====================================================================================================================================
// ======================      Route untuk Manajemen Ujian / Tugas  Essay dan pilihan ganda        ======================================================
// =====================================================================================================================================


});

// =====================================================================================================================================
// ======================      Route untuk Manajemen Ujian / Tugas  HAL SISWA        ====================================================
// ======================                   Route untuk Login SISWA        ======================================================
// =====================================================================================================================================


Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/profile/{id}', [AdminController::class, 'profil'])->name('admin.profil_admin');
    Route::get('/admin/edit-profile/{id}', [AdminController::class, 'editProfil'])->name('admin.edit_profil');
    Route::post('/admin/update-profile/{id}', [AdminController::class, 'updateProfil'])->name('admin.update_profil');
});

//==============================    Route SISWA ==========================================================

Route::group(['middleware' => ['auth']], function () {
    Route::get('/siswa/ujian', [UjianController::class, 'index'])->name('siswa.ujian.index');
    Route::get('/siswa/ujian/{id}', [UjianController::class, 'view'])->name('siswa.ujian.view');
    Route::get('/siswa/ujian/kerjakan/{ujian_id}', [UjianController::class, 'kerjakan'])->name('siswa.ujian.kerjakan');

    Route::get('/siswa/ujian/{id}/pilgan', [UjianController::class, 'mulaiPilgan'])->name('siswa.ujian.mulai.pilgan');
    Route::post('/siswa/ujian/{id}/pilgan/submit', [UjianController::class, 'submitPilgan'])->name('siswa.ujian.submit.pilgan');
    Route::get('/siswa/ujian/{id}/nilai/pilgan', [UjianController::class, 'hasilUjian'])->name('siswa.ujian.nilai.pilgan');

    Route::get('/siswa/ujian/{id}/essay', [UjianController::class, 'mulaiEssay'])->name('siswa.ujian.mulai.essay');
    Route::get('/ujian/essay/{id}', [UjianController::class, 'tampilEssay'])->name('siswa.ujian.mulai.essay');
    Route::post('/ujian/essay/{id}', [UjianController::class, 'submitEssay'])->name('siswa.ujian.submitEssay');
    Route::get('/ujian/nilai-essay/{id}', [UjianController::class, 'showNilaiEssay'])->name('siswa.ujian.nilai.essay');




    Route::get('/User Profil', [ProfileController::class, 'profil'])->name('siswa.profil_siswa');



    Route::get('/siswa/edit', [ProfileController::class, 'edit'])->name('siswa.profil.edit');
    Route::put('/siswa/update', [ProfileController::class, 'updateProfilSiswa'])->name('siswa.update');




    // ======================      Route untuk materi siswa        ======================================================


    // Route untuk menampilkan daftar materi bagi siswa
    Route::get('/siswa/materi', [MateriController::class, 'indexSiswa'])->name('siswa.materi.index');
    // Route untuk menampilkan materi bagi siswa berdasarkan ID
    Route::get('/siswa/materi/{id}', [MateriController::class, 'detailMateri'])->name('siswa.materi.detail');

    Route::get('siswa/tugas/{id}', [TugasSiswaController::class, 'show'])->name('siswa.tugas.show');

    Route::get('/siswa/tugas', [TugasSiswaController::class, 'indexSiswa'])->name('siswa.tugas.index');


    // Route untuk menampilkan form pengumpulan tugas
    Route::get('/siswa/tugas/{id}/submit', [TugasSiswaController::class, 'formPengumpulan'])->name('siswa.tugas.submit');

    // Route untuk menyimpan tugas yang dikumpulkan
    Route::post('/siswa/tugas/{id}/submit', [TugasSiswaController::class, 'submitTugas'])->name('siswa.tugas.submitTugas');

    // Route untuk form edit pengumpulan tugas (GET)
    Route::get('/siswa/pengumpulan/{id}/edit', [TugasSiswaController::class, 'formEditPengumpulan'])->name('siswa.tugas.edit');

    // Route untuk update pengumpulan tugas (PUT)
    Route::put('/siswa/pengumpulan/{id}', [TugasSiswaController::class, 'updateTugasSiswa'])->name('siswa.tugas.updateTugasSiswa');

    Route::delete('/siswa/pengumpulan/{id}', [TugasSiswaController::class, 'destroyTugasSiswa'])->name('siswa.tugas.destroyTugasSiswa');
});

// =====================================================================================================================================
// ======================      Route untuk Manajemen Ujian / Tugas  HAL GURU        ====================================================
// ======================                   Route untuk Login Guru        ======================================================
// =====================================================================================================================================


//==============================    Route Guru ==========================================================
Route::group(['middleware' => ['auth']], function () {
    Route::prefix('guru/tugas-siswa')->name('guru.tugas-siswa.')->group(function () {
        Route::get('/create', [TugasSiswaController::class, 'create'])->name('create');
        Route::post('/', [TugasSiswaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TugasSiswaController::class, 'edit'])->name('edit'); // Rute untuk halaman edit
        Route::put('/{id}', [TugasSiswaController::class, 'update'])->name('update'); // Rute untuk update tugas
        Route::get('/', [TugasSiswaController::class, 'index'])->name('index'); // Rute untuk daftar tugas
        Route::get('/{id}', [TugasSiswaController::class, 'show'])->name('showguru');
        Route::delete('/{id}', [TugasSiswaController::class, 'destroy'])->name('destroy');

    });


    // ======================      Route untuk materi guru        ======================================================
// =====================================================================================================================================

    Route::prefix('guru/materi')->name('guru.materi.')->group(function () {
        // Route untuk menampilkan daftar materi
        Route::get('', [MateriController::class, 'index'])->name('index');
        // Route untuk menyimpan materi baru
        Route::post('/store', [MateriController::class, 'store'])->name('store');
        // Route untuk mengupdate materi
        Route::put('/{id}', [MateriController::class, 'update'])->name('update');

        Route::delete('/{id}', [MateriController::class, 'destroy'])->name('destroy');

    });

    // ======================================= route untuk manajemen ujian ==========================================
    Route::prefix('guru/manajemen-ujian')->name('guru.manajemen-ujian.')->group(function () {

        Route::get('/create', [ManajemenTugasController::class, 'create'])->name('create');
        // Route untuk menampilkan soal pilihan ganda
        Route::get('/pilihan-ganda/{ujian_id}', [ManajemenPilihanGandaController::class, 'index'])->name('pilihan-ganda');
        // Route untuk menyimpan soal pilihan ganda
        Route::post('/pilihan-ganda/{ujian_id}', [ManajemenPilihanGandaController::class, 'storePilgan'])->name('pilihan-ganda.storePilgan');
        // Route untuk mengupdate soal pilihan ganda
        Route::put('/pilihan-ganda/{ujian_id}/{id}', [ManajemenPilihanGandaController::class, 'update'])->name('pilihan-ganda.update');
        // Route untuk menghapus soal pilihan ganda
        Route::delete('/pilihan-ganda/{ujian_id}/{id}', [ManajemenPilihanGandaController::class, 'destroy'])->name('pilihan-ganda.destroy');


        Route::get('/essay/{ujian_id}', [EssayController::class, 'index'])->name('essay');
        Route::post('/essay/{ujian_id}', [EssayController::class, 'store'])->name('essay.store');
        Route::put('/essay/{ujian_id}/{id}', [EssayController::class, 'update'])->name('essay.update');
        Route::delete('/essay/{ujian_id}/{id}', [EssayController::class, 'destroy'])->name('essay.destroy');

        // Route untuk daftar siswa yang ikut ujian
        Route::get('/koreksi/{ujian_id}/daftar-siswa', [UjianController::class, 'daftarSiswa'])->name('koreksi.daftar-siswa');
        Route::get('/daftar-siswa/{ujian_id}', [UjianController::class, 'daftarSiswa'])->name('daftar-siswa');

        // Route untuk analisa pilihan ganda
        Route::get('/koreksi/{ujian_id}/pg/{siswa_id}', [UjianController::class, 'analisaPilihanGanda'])->name('koreksi.analisa_pg');
        // Route untuk koreksi Nilai Essay
        Route::post('/koreksi/nilai/{jawaban_id}', [KoreksiEssayController::class, 'KoreksiNilai'])->name('koreksi.koreksiNilai');
    });

    // Route untuk koreksi essay
    Route::get('/guru/koreksi/{ujian_id}/{siswa_id}', [KoreksiEssayController::class, 'showKoreksi'])->name('guru.manajemen-ujian.koreksi.koreksi_essay');
    // Route detail tugas siswa
    Route::get('/guru/tugas-siswa/{id}', [TugasSiswaController::class, 'show'])->name('guru.tugas-siswa.showguru');
    // route untuk tampilan daftar siswa
    Route::get('/guru/daftar-siswa', [GuruController::class, 'daftarSiswa'])->name('guru.daftar_siswa');
    // route untuk exports nilai ujian siswa
    Route::get('guru/manajemen-ujian/koreksi/{ujian_id}/daftar-siswa/export', [UjianController::class, 'exportExcel'])->name('guru.daftar-siswa.export');



    Route::get('/guru/profil', [ProfileController::class, 'showProfilGuru'])->name('guru.profil.profil_guru');
    // route untuk exports nilai tugas
    Route::get('/guru/tugas/{id}/export-excel', [TugasSiswaController::class, 'exportExcel'])->name('guru.exportExcel');
    // routes/web.php
    Route::get('guru/tugas/{id}/detail', [TugasSiswaController::class, 'showTugas'])->name('guru.tugas-siswa.showguru');
    Route::post('guru/tugas/{id}/koreksi', [TugasSiswaController::class, 'koreksiTugas'])->name('guru.koreksiTugas');




    Route::put('/guru/profil/{id}', [ProfileController::class, 'updateProfilGuru'])->name('guru.profil.updateProfilGuru');

});

Route::prefix('siswa')->middleware('auth')->group(function () {
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
    Route::get('/pesan terkirim', [PesanController::class, 'pesan'])->name('pesan.pengirim');
    Route::get('/pesan/kirim', [PesanController::class, 'create'])->name('pesan.create');
    Route::post('/pesan/create', [PesanController::class, 'store'])->name('pesan.store');
    Route::get('/pesan2/{id}', [PesanController::class, 'showSiswa2'])->name('siswa.pesan.show2');
    Route::get('/pesan/{id}', [PesanController::class, 'showSiswa'])->name('siswa.pesan.show');
    // Route untuk form edit pesan (menggunakan modal di view, tidak terpisah)
    Route::put('pesan/{id}', [PesanController::class, 'update'])->name('pesan.update');
    // Route untuk menghapus pesan
    Route::delete('pesan/{id}', [PesanController::class, 'destroy'])->name('pesan.destroy');
    Route::post('/pesan/balas/{id}', [PesanController::class, 'balas'])->name('pesan.balas');
    Route::get('/siswa/video', [VideoController::class, 'indexSiswa'])->name('siswa.video');

});

Route::prefix('guru')->middleware('auth')->group(function () {
    Route::get('/pesan', [PesanController::class, 'indexGuru'])->name('guru.pesan.index');
    Route::get('/pesan/kirim', [PesanController::class, 'createGuru'])->name('guru.pesan.create');
    Route::post('/pesan/kirim', [PesanController::class, 'storeGuru'])->name('guru.pesan.store');
    Route::post('/pesan/{id}/reply', [PesanController::class, 'reply'])->name('pesan.reply');
    Route::get('/pesan terkirim', [PesanController::class, 'pesanGuru'])->name('guru.pesan.pengirim');
    Route::get('/pesan/{id}', [PesanController::class, 'showGuru'])->name('guru.pesan.show');
    Route::get('/pesan2/{id}', [PesanController::class, 'showGuru2'])->name('guru.pesan.show2');
});
//============================== route untuk ganti password ===================================================

Route::middleware(['auth'])->group(function () {
    Route::get('change-password', [UserController::class, 'showChangePasswordForm'])->name('auth.change-password');
    Route::get('change-password/admin', [UserController::class, 'showChangePasswordForm2'])->name('auth.change-password2');
    Route::post('change-password/admin', [UserController::class, 'updatePasswordAdmin'])->name('change-password.update');
    Route::post('change-password/guru', [UserController::class, 'updatePasswordGuru'])->name('change-password.update');
    Route::post('change-password/siswa', [UserController::class, 'updatePasswordSiswa'])->name('change-password.update');

    Route::resource('threads', ThreadController::class);
    Route::post('threads/{thread}/comments', [CommentController::class, 'store'])->name('comments.store');
});



Route::prefix('guru/video')->name('guru.video.')->middleware('auth')->group(function () {
    Route::get('/', [VideoController::class, 'index'])->name('index'); // Halaman manajemen video
    Route::post('/store/local', [VideoController::class, 'storeLocal'])->name('store.local'); // Upload lokal
    Route::post('/store/youtube', [VideoController::class, 'storeYoutube'])->name('store.youtube'); // Upload YouTube
    Route::delete('/{id}', [VideoController::class, 'destroy'])->name('destroy'); // Hapus video
    Route::get('/video/play/{id}', [VideoController::class, 'play'])->name('video.play');
});






// Routes untuk Mata Pelajaran
// ====================== Manajemen Jadwal (Admin) ======================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/jadwal', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\\Http\\Controllers\\AdminJadwalController@index');
        }, 'admin');
    })->name('admin.jadwal.index');

    Route::get('/admin/jadwal/create', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\\Http\\Controllers\\AdminJadwalController@create');
        }, 'admin');
    })->name('admin.jadwal.create');

    Route::post('/admin/jadwal/store', function () {
        return (new RoleMiddleware)->handle(request(), function () {
            return app()->call('App\\Http\\Controllers\\AdminJadwalController@store');
        }, 'admin');
    })->name('admin.jadwal.store');

    Route::get('/admin/jadwal/edit/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\\Http\\Controllers\\AdminJadwalController@edit', ['id' => $id]);
        }, 'admin');
    })->name('admin.jadwal.edit');

    Route::post('/admin/jadwal/update/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\\Http\\Controllers\\AdminJadwalController@update', ['id' => $id]);
        }, 'admin');
    })->name('admin.jadwal.update');

    Route::delete('/admin/jadwal/delete/{id}', function ($id) {
        return (new RoleMiddleware)->handle(request(), function () use ($id) {
            return app()->call('App\\Http\\Controllers\\AdminJadwalController@destroy', ['id' => $id]);
        }, 'admin');
    })->name('admin.jadwal.destroy');
});
// ====================== End Manajemen Jadwal (Admin) ======================

Route::resource('courses', CourseController::class);

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/bhsINDO', [PelajaranController::class, 'indo'])->name('siswa.bhs_indo');
Route::get('/bhsINGGRIS', [PelajaranController::class, 'inggris'])->name('siswa.bhs_inggris');
Route::get('/bhsJAWA', [PelajaranController::class, 'jawa'])->name('siswa.bhs_jawa');
Route::get('/INFORMATIKA', [PelajaranController::class, 'informatika'])->name('siswa.informatika');
Route::get('/BK', [PelajaranController::class, 'bk'])->name('siswa.bk');
Route::get('/MATEMATIKA', [PelajaranController::class, 'mtk'])->name('siswa.mtk');
Route::get('/IPA', [PelajaranController::class, 'ipa'])->name('siswa.ipa');
Route::get('/IPS', [PelajaranController::class, 'ips'])->name('siswa.ips');
Route::get('/AGAMA', [PelajaranController::class, 'agama'])->name('siswa.pai');
Route::get('/PJOK', [PelajaranController::class, 'pjok'])->name('siswa.pjok');
Route::get('/SENI BUDAYA', [PelajaranController::class, 'seni'])->name('siswa.seni');
Route::get('/PPKN', [PelajaranController::class, 'ppkn'])->name('siswa.ppkn');
Route::get('/Jadwal', [PelajaranController::class, 'jadwal'])->name('siswa.jadwal');





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
