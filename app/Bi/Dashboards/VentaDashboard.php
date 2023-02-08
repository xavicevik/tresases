<?php

namespace App\Bi\Dashboards;

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


class VentaDashboard extends Dashboard
{

    public $model  = Venta::class;
    public $uriKey = 'ventas';
    public $name   = 'Dashboard Ventas';

    public function filters()
    {
        return [
            DateIntervalFilter::create('created_at', 'Fecha'),
            BelongsToFilter::create('vendedor', 'Vendedor')
                ->relation('vendedor')
                ->otherColumn('nombre'),
            BelongsToFilter::create('rifa', 'Rifa')
                ->relation('rifa')
                ->otherColumn('nombre_tecnico'),
            BelongsToFilter::create('estado', 'Estado')
                ->relation('estados')
                ->otherColumn('nombre'),
            BelongsToFilter::create('ciudad', 'Ciudad')
                ->relation('ciudad')
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

            PartitionPie::create('boletas', 'Boletas por estado')
                ->dimensions([
                    BelongsToDimension::create('estado', 'Estado')
                        ->relation('estados')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    CountMetric::create('count', 'Count')
                        ->color('#ff0055'),
                ])
                ->width('1/3')
                ->scope(function($builder) {
                    return $builder->where('idgenero', '>', 0);
                }),

            PartitionPie::create('miliantes-estado', 'Militantes por estado')
                ->dimensions([
                    BelongsToDimension::create('estado', 'Estados')
                        ->relation('estados')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    CountMetric::create('count', 'Count')
                        ->color('#ff5500'),
                ])
                ->width('1/3')->scope(function($builder) {
                    return $builder->where('estado', '!=', null);
                }),

            PartitionPie::create('miliantes-etnia', 'Militantes por Étnia')
                ->dimensions([
                    BelongsToDimension::create('etnia', 'Etnia')
                        ->relation('grupoEtnico')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    CountMetric::create('count', 'Count')
                        ->color('#ff5500'),
                ])
                ->width('1/3')->scope(function($builder) {
                    return $builder->where('idgrupoetnico', '>', 0);
                }),

            PartitionPie::create('miliantes-nivel', 'Militantes por Nivel')
                ->dimensions([
                    BelongsToDimension::create('niveleducativo', 'Estados')
                        ->relation('niveleducativo')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    CountMetric::create('count', 'Count')
                        ->color('#ff5500'),
                ])
                ->width('1/3')
                ->scope(function($builder) {
                    return $builder->where('idniveleducativo', '!=', null);
                }),

            PartitionPie::create('miliantes-corporacion', 'Militantes por Corporación')
                ->dimensions([
                    BelongsToDimension::create('corporacion', 'Corporación')
                        ->relation('corporacion')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    CountMetric::create('count', 'Count')
                        ->color('#ff5500'),
                ])
                ->width('1/3')->scope(function($builder) {
                    return $builder->where('idcorporacion', '>', 0);
                }),

            Table::create('militantes-departamento', 'Militantes por Departamentos')
                ->dimensions([
                    BelongsToDimension::create('departamento', 'Departamentos')
                        ->relation('departamento')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    CountMetric::create('count', 'Cantidad')
                        ->color('#dc0555'),
                ])
                ->orderBy('count', 'desc')
                ->width('1/3')->scope(function($builder) {
                    return $builder->where('iddepartamento', '>', 0)->limit(10);
                }),

            Table::create('militantes-ciudad', 'Militantes por Ciudades')
                ->dimensions([
                    BelongsToDimension::create('ciudad', 'Ciudades')
                        ->relation('ciudad')
                        ->otherColumn('nombre')
                ])
                ->metrics([
                    CountMetric::create('count', 'Cantidad')
                        ->color('#dc0555'),
                ])
                ->orderBy('count', 'desc')
                ->width('1/3')->scope(function($builder) {
                    return $builder->where('idciudad', '>', 0)->limit(10);
                }),

            Table::create('militantes-votos', 'Cantidad Votos')
                ->dimensions([
                    StringDimension::create('nombre', 'Votos')
                ])
                ->metrics([
                    SumMetric::create('votos', 'Cantidad')
                        ->color('#dc0555'),
                ])
                ->orderBy('sum', 'desc')
                ->width('1/3')
                ->scope(function($builder) {
                    return $builder->where('votos', '>', 0)->limit(10);
                }),

        ];
    }
}
