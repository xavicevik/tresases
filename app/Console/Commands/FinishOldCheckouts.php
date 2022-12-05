<?php

namespace App\Console\Commands;

use App\Models\Boleta;
use App\Models\Checkout;
use App\Models\Detallesesion;
use App\Models\Sesionventa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinishOldCheckouts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:clearcheckout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eliminar checkouts antiguos';

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
        $dias = config('mercadopago.diascheckout');

        $checkouts = Checkout::whereRaw('TIMESTAMPDIFF(DAY, updated_at, NOW()) > '.$dias)
                                ->whereNull('status')
                                ->delete();
    }
}
