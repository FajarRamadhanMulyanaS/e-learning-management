<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Siswa;
use App\Models\Guru;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mengirimkan variabel $admin ke semua view yang menggunakan layout.side.blade.php
        View::composer('layout.side', function ($view) {
            $admin = Auth::user(); // Mengambil admin yang login
            $view->with('admin', $admin);

            $user = Auth::user(); // Mengambil user yang login

            // Jika user adalah siswa, ambil data siswa
            $siswa = null;
            if ($user && $user->role === 'siswa') {
                $siswa = Siswa::where('user_id', $user->id)->first();
            }

            $view->with(compact('user', 'siswa')); // Mengirimkan kedua variabel
        });

        // Mengirimkan data siswa ke view profil_siswa
        View::composer('siswa.profil_siswa', function ($view) {
            if (Auth::check() && Auth::user()->role === 'siswa') {
                $siswa = Siswa::with('user')->where('user_id', Auth::id())->first();
                $view->with('siswa', $siswa);
            }
        });

        // Mengirimkan data siswa ke view profil_siswa
        View::composer('guru.profil_guru', function ($view) {
            if (Auth::check() && Auth::user()->role === 'guru') {
                $guru = Guru::with('user')->where('user_id', Auth::id())->first();
                $view->with('guru', $guru);
            }
        });
    }
}
