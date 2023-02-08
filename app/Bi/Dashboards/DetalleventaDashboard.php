<?php

namespace App\Bi\Dashboards;

use App\Models\Detalleventa;
use LaravelBi\LaravelBi\Dashboard;
use LaravelBi\LaravelBi\Dimensions\BelongsToDimension;
use LaravelBi\LaravelBi\Dimensions\DateDimension;
use LaravelBi\LaravelBi\Dimensions\StringDimension;
use LaravelBi\LaravelBi\Filters\BelongsToFilter;
use LaravelBi\LaravelBi\Filters\DateFilter;
use LaravelBi\LaravelBi\Filters\DateIntervalFilter;
use LaravelBi\LaravelBi\Filters\StringFilter;
use LaravelBi\LaravelBi\Metrics\CountMetric;
use LaravelBi\LaravelBi\Metrics\SumMetric;
use LaravelBi\LaravelBi\Widgets\BigNumber;
use App\Models\Militante;
use LaravelBi\LaravelBi\Widgets\LineChart;
use LaravelBi\LaravelBi\Widgets\PartitionPie;
use LaravelBi\LaravelBi\Widgets\Table;
use LaravelBi\LaravelBi\Widgets\Traits\SingleMetric;


class DetalleventaDashboard extends Dashboard
{

    public $model  = Detalleventa::class;
    public $uriKey = 'detalle_ventas';
    public $name   = 'Detalle Ventas';

    public function filters()
    {
        return [
            DateIntervalFilter::create('created_at', 'Fecha'),
            BelongsToFilter::create('rifa', 'Rifa')
                            ->relation('rifa')
                            ->otherColumn('nombre'),
            BelongsToFilter::create('estados', 'Estado')
                            ->relation('estados')
                            ->otherColumn('nombre'),

            //StringFilter::create('avalado', 'Avalado'),
            //StringFilter::create('electo', 'Electo'),
            //StringFilter::create('lider', 'Lider'),
        ];
    }

    public function widgets()
    {
        return [
            BigNumber::create('ventas', 'Cantidad de ventas')
                ->metric(
                    CountMetric::create('count', 'Cantidad')
                        ->color('#ff5555')
                )
                ->width('1/3'),

            PartitionPie::create('ventas', 'Ventas por estado')
                ->dimensions([
                    BelongsToDimension::create('estados', 'Estado')
                        ->relation('estados')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    CountMetric::create('count', 'Count')
                        ->color('#ff0055'),
                ])
                ->width('1/3'),
                //->scope(function($builder) {
                //    return $builder->where('idgenero', '>', 0);
                //}),

            PartitionPie::create('ventas', 'Ventas por estado')
                ->dimensions([
                    BelongsToDimension::create('estados', 'Estado')
                        ->relation('estado')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    SumMetric::create('sum', 'Sum')
                        ->color('#ff0055'),
                ])
                ->width('1/3'),

        ];
    }
}
