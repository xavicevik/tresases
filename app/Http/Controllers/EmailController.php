<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\Notificaciones;
use App\Models\Venta;
use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;


class EmailController extends Controller
{
    function index()
    {
        return view('form');
    }

    public function send(Request $request)
    {
        $data = Venta::where('id', $request->notificacion)
            ->with('detalles.boleta')
            ->with('detalles.rifa')
            ->with('cliente')
            ->with('vendedor')
            ->get();
        $venta = $data[0];

        $subject = "TresAses - Venta #".$request->idventa;
        $for = $venta['cliente']->correo;
        $url = $request->url;

        $data = array(
            'data'     => $venta,
            'subject'  => $subject
        );

        //\Mail::to('javier.minotta.h@gmail.com')->send(new Notificaciones($data));
        //dispatch(new SendEmailJob($data));
        SendEmailJob::dispatch($data);

        return back()->with('success', 'Enviado exitosamente!');
    }
}
