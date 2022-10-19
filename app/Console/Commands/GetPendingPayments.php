<?php

namespace App\Console\Commands;

use App\Models\Boleta;
use App\Models\Checkout;
use App\Models\Detallesesion;
use App\Models\Sesionventa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GetPendingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pagos:actualizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar pagos pendientes';

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
        try {
            DB::beginTransaction();

            $pagos = Checkout::where('estado', 4)
                               ->get();

            foreach ($pagos as $pago) {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer TEST-527760229179050-091011-a9b62330235cb5d7a47b2b59968ac474-1195821039',
                ])->get("https://api-sms.masivapp.com/send-message", [
                    "id" => $pago->id
                ]);

                if ($response['status'] == 'aproved') {
                    $pagos->estado = 1;

                    $r = new Request();
                    $r->idsesion = $pago['idsesionventa'];
                    $r->isSale = true;
                    $idventa = $this->newSale($r);
                    $this->finishSession($r);
                } elseif ($response['status'] == 'rejected') {
                    $pagos->estado = 2;

                    $r = new Request();
                    $r->idsesion = $pago['idsesionventa'];
                    $this->finishSession($r);
                }

            }

            DB::commit();
        } catch (Throwable $e){
            DB::rollBack();
        }
    }
}
