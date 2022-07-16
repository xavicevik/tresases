<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css"> <script src="script.js"></script>
</head>
<style>
    @page {
        margin-left: 1cm;
        margin-right: 0;
        margin-top: 0cm;
        margin-bottom: 0.5cm;
    }
</style>
<body style="width: 6cm">
<p class="ticket">
    <p class="left">
        <strong>Los Tres Ases
        <br>Sus sueños hechos realidad
        </strong>
        <hr>
        <strong>Usuario:</strong> {{ $recaudocaja->vendedor->username }}
        <hr>
    </p>
    <p class="centrado">
        <strong>RSUMEN CIERRE CAJA</strong>
        <br><strong>Recibo: </strong>{{ $recibo }}
        <hr>

    </p>

    <br>
    <table class="table">
        <tr class="bg-white border-b ">
            <th scope="col" class="px-6 py-2">
                Fecha:
            </th>
            <th scope="col" class="px-6 py-2">
                {{ $fecha }}
            </th>
        </tr>
        <tr class="bg-white border-b ">
            <th scope="col" class="px-6 py-2">
                Usuario
            </th>
            <th scope="col" class="px-6 py-2">
                {{ $recaudocaja->vendedor->full_name }}
            </th>
        </tr>
        <tr class="bg-white border-b ">
            <th scope="col" class="px-6 py-2">
                Punto de venta
            </th>
            <th scope="col" class="px-6 py-2">
                {{ $recaudocaja->puntoventa->nombre }}
            </th>
        </tr>
        <tbody>
        <tr class="">
            <th colspan="2" scope="row" style="border: black" class="px-6 mx-auto py-4 font-medium text-black font-bold whitespace-nowrap">
                Movimientos
            </th>
        </tr>

        <tr class="bg-white border-b ">
            <th scope="col" class="px-6 py-2">
                Fondo:
            </th>
            <td class="px-6 py-2">
                {{ $recaudocaja->montoapertura }}
            </td>
        </tr>
        <tr class="bg-white border-b ">
            <th scope="col" class="px-6 py-2">
                Efectivo:
            </th>
            <td class="px-6 py-2">
                {{ $recaudocaja->montocierre }}
            </td>
        </tr>
        <tr class="bg-white border-b ">
            <th scope="col" class="px-6 py-2">
                Ventas:
            </th>
            <td class="px-6 py-2">
                {{ $recaudocaja->recaudoefectivo }}
            </td>
        </tr>
        <tr class="bg-white border-b ">
            <th scope="col" class="px-6 py-2">
                Comisiones:
            </th>
            <td class="px-6 py-2">
                {{ $recaudocaja->comisionventa }}
            </td>
        </tr>
        <tr class="bg-white border-b ">
            <th scope="col" class="px-6 py-2">
                Faltante
            </th>
            <td class="px-6 py-2 text-red-700">
                {{ $recaudocaja->faltante }}
            </td>
        </tr>
        <tr class="bg-white border-b ">
            <th scope="col" class="px-6 py-2">
                Sobrante
            </th>
            <td class="px-6 py-2">
                {{ $recaudocaja->sobrante }}
            </td>
        </tr>
        </tbody>
    </table>





<hr>

</div>
</body>
</html>

<style>
    * {
        font-size: 14px;
        font-family: 'Verdana';
    }

    td,
    th,
    tr,
    table {
        border-top: 1px dot-dash black;
        border-collapse: collapse;
        padding: 4px;
    }

    td.numero,
    th.numero {
        width: 85px;
        max-width: 85px;
    }

    td.promo,
    th.promo {
        width: 80px;
        max-width: 80px;
        word-break: break-all;
    }

    .centrado {
        text-align: center;
        align-content: center;
    }

    .ticket {
        width: 155px;
        max-width: 155px;
    }

    .imgx {
        max-width: inherit;
        width: inherit;
    }
    .img2 {
        max-width: 80px;
        width: 80px;
        display: block;
        margin: auto;
    }
</style>
