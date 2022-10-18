<?php

namespace App\Jobs;

use App\Http\Controllers\VentaController;
use App\Mail\Notificaciones;
use App\Http\Controllers\RifaController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to, $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $message)
    {
        $this->to = $to;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        RifaController::crearBoleteria($this->id, $this->isFisica, $this->cifras, $this->serie, $this->precio);
        VentaController::sendSMS($this->to, $this->message);
    }
}
