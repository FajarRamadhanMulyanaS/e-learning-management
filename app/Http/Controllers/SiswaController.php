<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

use App\Models\Siswa;
class SiswaController extends Controller
{
    // Halaman utama siswa
    public function index()
    {
        return view('siswa.index');
    }


}
