<?php

namespace App\Exports;

use App\Models\Detalleventa;
use Maatwebsite\Excel\Concerns\FromCollection;

class DetalleventasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Detalleventa::all();
    }
}
