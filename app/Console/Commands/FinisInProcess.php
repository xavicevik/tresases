<?php

namespace App\Console\Commands;

use App\Models\Boleta;
use App\Models\Detallesesion;
use App\Models\Sesionventa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinisInProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:rollback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambiar de estado ventas en proceso - estado 5';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $time = config('session.max_time_inprocess');
        try {
            DB::beginTransaction();

            $boletas = Boleta::whereRaw('TIMESTAMPDIFF(SECOND, updated_at, NOW()) > '.$time)
                                ->where('estado', 5)
                                ->whereNotExists(function($query)
                                {
                                    $query->select(DB::raw(1))
                                        ->from('detallesesion')
                                        ->whereRaw('detallesesion.id = boletas.id');
                                })->get();
            foreach ($boletas as $boleta) {
                if ($boleta->estado_ant == 5) {
                    if ($boleta->saldo == 0) {
                        $boleta->estado_ant = $boleta->estado;
                        $boleta->estado = 3;
                    } elseif ($boleta->saldo == $boleta->valor) {
                        if ($boleta->idvendedor > 0) {
                            $boleta->estado_ant = $boleta->estado;
                            $boleta->estado = 2;
                        } else {
                            $boleta->estado_ant = $boleta->estado;
                            $boleta->estado = 1;
                        }
                    } else {
                        $boleta->estado_ant = $boleta->estado;
                        $boleta->estado = 4;
                    }
                } else {
                    $boleta->estado = $boleta->estado_ant;
                }
                $boleta->save();
            }

            DB::commit();
        } catch (Throwable $e){
            DB::rollBack();
        }
    }
}
