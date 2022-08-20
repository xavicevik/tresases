<?php

namespace App\Console\Commands;

use App\Models\Boleta;
use App\Models\Detallesesion;
use App\Models\Sesionventa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinisSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eliminar sessiones de venta';

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
        $time = config('session.max_time_sales');
        try {
            DB::beginTransaction();

            $sessions = Sesionventa::whereRaw('TIMESTAMPDIFF(SECOND, created_at, NOW()) > 120')->get();
            foreach ($sessions as $session) {
                $idsesion = $session->id;
                $boletas = Boleta::join('detallesesion', 'boletas.id', '=', 'detallesesion.idboleta')
                    ->where('detallesesion.idsesionventa', $idsesion)
                    ->select('boletas.*')
                    ->get();
                $detalle = Detallesesion::where('idsesionventa', $idsesion)->delete();

                foreach ($boletas as $dato) {
                    $dato->estado = $dato->estado_ant;
                    $dato->save();
                }
                $session->delete();

                \Cart::remove($idsesion);
            }

            DB::commit();
        } catch (Throwable $e){
            DB::rollBack();
        }
    }
}
