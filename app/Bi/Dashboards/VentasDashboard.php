<?php

namespace App\Bi\Dashboards;

use LaravelBi\LaravelBi\Dashboard;

class VentasDashboard extends Dashboard
{

    public $model  = App\Models\Venta::class;
    public $uriKey = 'ventasDashboard';
    public $name   = 'VentasDashboard';

    public function filters()
    {
        return [
            
        ];
    }

    public function widgets()
    {
        return [
            
        ];
    }
}
