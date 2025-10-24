<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PresensiDetailExport implements FromView
{
    protected $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function view(): View
    {
        return view('admin.presensi.export-detail-excel', [
            'session' => $this->session
        ]);
    }
}
