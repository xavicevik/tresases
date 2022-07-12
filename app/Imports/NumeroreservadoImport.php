<?php

namespace App\Imports;

use App\Models\Boleta;
use App\Models\NumeroReservado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use function PHPUnit\Framework\isNull;

class NumeroreservadoImport implements ToModel
{
    protected $idvenddor = null;
    protected $idrifa = null;

    public function __construct(Request $request)
    {
        $this->idrifa = $request->rifa;
        $this->idvenddor = $request->vendedor;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $boleta = Boleta::where('idrifa', $this->idrifa)
                        ->where('numero', $row[0])
                        ->firstOrFail();
        if (!is_null($boleta)) {
            if (($boleta->idvendedor === '' || $boleta->idvendedor === null) && $boleta->estado == 1) {
                $boleta->idvendedor = $this->idvenddor;
                $boleta->estado = 2;
                $boleta->save();
            }
        }

        return $boleta;
    }
}
