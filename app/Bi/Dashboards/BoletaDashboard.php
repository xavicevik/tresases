<?php

namespace App\Bi\Dashboards;

use App\Models\Boleta;
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
use LaravelBi\LaravelBi\Widgets\LineChart;
use LaravelBi\LaravelBi\Widgets\PartitionPie;
use LaravelBi\LaravelBi\Widgets\Table;
use LaravelBi\LaravelBi\Widgets\Traits\SingleMetric;


class BoletaDashboard extends Dashboard
{

    public $model  = Boleta::class;
    public $uriKey = 'boletas';
    public $name   = 'Dashboard Boletas';

    public function filters()
    {
        return [
            DateIntervalFilter::create('created_at', 'Fecha'),
            BelongsToFilter::create('vendedor', 'Vendedor')
                ->relation('vendedor')
                ->otherColumn('nombre'),
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
            BigNumber::create('boletas-cantidad', 'Cantidad de boletas')
                ->metric(
                    CountMetric::create('count', 'Cantidad')
                        ->color('#ff5555')
                )
                ->width('1/3'),

            PartitionPie::create('boletas-estados', 'Boletas por estado')
                ->dimensions([
                    BelongsToDimension::create('estados', 'Estados')
                        ->relation('estados')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    CountMetric::create('count', 'Count')
                        ->color('#ff0055'),
                ])
                ->width('1/3'),

            PartitionPie::create('boletas-vendedor', 'Boletas por vendedor')
                ->dimensions([
                    BelongsToDimension::create('vendedor', 'Vendedor')
                        ->relation('vendedor')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    CountMetric::create('count', 'Count')
                        ->color('#ff5500'),
                ])
                ->width('1/3')->scope(function($builder) {
                    return $builder->where('idvendedor', '>', 0);
                }),

            Table::create('boletas-ventascant', 'Ventas por vendedor')
                ->dimensions([
                    BelongsToDimension::create('vendedor', 'Vendedor')
                        ->relation('vendedor')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    SumMetric::create('pago', 'Pagado')
                        ->color('#dc0555'),
                ])
                ->orderBy('sum', 'desc')
                ->width('1/3')->scope(function($builder) {
                    return $builder->where('pago', '>', 0)->limit(10);
                }),

            Table::create('boletas-ventasc', 'Ventas Totales')
                ->dimensions([
                    BelongsToDimension::create('vendedor', 'Vendedor')
                        ->relation('vendedor')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    SumMetric::create('valor', 'Vendido')
                        ->color('#dc0555'),
                ])
                ->orderBy('sum', 'desc')
                ->width('1/3')->scope(function($builder) {
                    return $builder->where('valor', '>', 0)->where('idvendedor', '>', 0)->limit(10);
                }),
        ];
    }
}
