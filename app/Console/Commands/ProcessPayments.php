<?php

namespace App\Console\Commands;

use App\Http\Controllers\VentaController;
use App\Jobs\ValidarVentasJob;
use App\Models\Boleta;
use App\Models\Detallesesion;
use App\Models\Sesionventa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProcessPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ventas:processpayments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Procesar pagos pendientes y en proceso';

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
        $status  = (new VentaController)->ProcessPayments();
    }
}
