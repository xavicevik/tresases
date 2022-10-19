<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $table = 'checkout';
    protected $fillable =[
        'idsesionventa',
        'iddetallesesion',
        'idboleta',
        'valor',
        'idcliente',
        'idventa',
        'idvendedor',
        'preference_id',
        'collection_id',
        'collection_status',
        'payment_id',
        'status',
        'payment_type',
        'merchant_order_id',
        'site_id',
        'processing_mode',
        'merchant_account_id',
        'estado',
        'urlpago'
    ];

    public function detallesesion(){
        return $this->belongsTo(Detallesesion::class, 'iddetallesesion');
    }

    public function sesionventa(){
        return $this->belongsTo(Sesionventa::class, 'idsesionventa');
    }

    public function vendedor(){
        return $this->belongsTo(Vendedor::class, 'idvendedor');
    }

    public function boleta(){
        return $this->belongsTo(Boleta::class, 'idboleta');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'idcliente');
    }

    public function venta(){
        return $this->belongsTo(Venta::class, 'idventa');
    }

}
