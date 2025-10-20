<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelajaranController extends Controller
{
    //

    public function jadwal()
    {
        return view('siswa.jadwal');
    }
    public function indo()
    {
        return view('siswa.pelajaran.bhs_indo');
    }
    public function inggris()
    {
        return view('siswa.pelajaran.bhs_inggris');
    }
    public function mtk()
    {
        return view('siswa.pelajaran.mtk');
    }
    public function ipa()
    {
        return view('siswa.pelajaran.ipa');
    }
    public function ips()
    {
        return view('siswa.pelajaran.ips');
    }
    public function bk()
    {
        return view('siswa.pelajaran.bk');
    }
    public function agama()
    {
        return view('siswa.pelajaran.pai');
    }
    public function pjok()
    {
        return view('siswa.pelajaran.pjok');
    }
    public function ppkn()
    {
        return view('siswa.pelajaran.ppkn');
    }
    public function informatika()
    {
        return view('siswa.pelajaran.informatika');
    }
    public function seni()
    {
        return view('siswa.pelajaran.seni');
    }
    public function jawa()
    {
        return view('siswa.pelajaran.bhs_jawa');
    }
}

