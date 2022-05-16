<?php

namespace App\Jobs;

use App\Mail\Notificaciones;
use App\Models\Rifa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CrearBoletasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id, $cifras, $serie;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $cifras, $serie)
    {
        $this->id = $id;
        $this->cifras = $cifras;
        $this->serie = $serie;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Rifa::crearBoleteria($this->id, $this->cifras, $this->serie);
    }
}
