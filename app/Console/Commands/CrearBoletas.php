<?php

namespace App\Console\Commands;

use App\Http\Controllers\RifaController;
use App\Models\Boleta;
use App\Models\Detallesesion;
use App\Models\Rifa;
use App\Models\Sesionventa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CrearBoletas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rifas:crearboletas {--idrifa=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear boletaría';

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
        $idrifa = $this->option('idrifa');
        $rifa = Rifa::where('id', $idrifa)->first();

        RifaController::crearBoleteria($idrifa, $rifa->fisica, $rifa->cifras, $rifa->serie, $rifa->precio);
    }
}
