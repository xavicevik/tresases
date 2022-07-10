<?php

namespace App\Exports;

use App\Models\Historialcaja;
use Maatwebsite\Excel\Concerns\FromCollection;

class HistorialcajasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Historialcaja::all();
    }
}
