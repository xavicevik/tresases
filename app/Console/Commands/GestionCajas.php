<?php

namespace App\Console\Commands;

use App\Http\Controllers\CajaController;
use App\Jobs\GestionCajasJob;
use App\Jobs\ValidarVentasJob;
use App\Models\Boleta;
use App\Models\Detallesesion;
use App\Models\Sesionventa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GestionCajas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cajas:openclose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cerrar y abrir caja automáticamente ';

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
        $exec = (new CajaController)->AbrirCerrarDefault();
    }
}
