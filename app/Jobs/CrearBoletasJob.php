<?php

namespace App\Jobs;

use App\Mail\Notificaciones;
use App\Http\Controllers\RifaController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CrearBoletasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id, $isFisica, $cifras, $serie, $precio;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $isFisica, $cifras, $serie, $precio)
    {
        $this->id = $id;
        $this->isFisica = $isFisica;
        $this->cifras = $cifras;
        $this->serie = $serie;
        $this->precio = $precio;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        RifaController::crearBoleteria($this->id, $this->isFisica, $this->cifras, $this->serie, $this->precio);
    }
}
