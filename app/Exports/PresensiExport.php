<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PresensiExport implements FromView
{
    protected $records;

    public function __construct($records)
    {
        $this->records = $records;
    }

    public function view(): View
    {
        return view('admin.presensi.export-excel', [
            'records' => $this->records
        ]);
    }
}
