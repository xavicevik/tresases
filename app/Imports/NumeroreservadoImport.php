<?php

namespace App\Imports;

use App\Models\Boleta;
use App\Models\NumeroReservado;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use function PHPUnit\Framework\isNull;

class NumeroreservadoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $boleta = Boleta::where('idrifa', $row[1])
                        ->where('numero', $row[2])
                        ->firstOrFail();
        if (!is_null($boleta)) {
            if (($boleta->idvendedor === '' || $boleta->idvendedor === null) && $boleta->estado == 1) {
                $boleta->idvendedor = $row[0];
                $boleta->estado = 2;
                $boleta->save();
            }
        }

        return $boleta;
    }
}
