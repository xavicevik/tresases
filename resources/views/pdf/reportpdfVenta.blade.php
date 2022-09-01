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
        <strong>Usuario:</strong>  {{ $usuario}}
        <br><strong>Rifa:</strong>  {{ $rifa }}
        <br><strong>Fecha:</strong>{{ $fecha }}
        <hr>
    </p>
    <p class="centrado">
        <strong>PAGO DE COMISION</strong>
        <br><strong>Recibo: </strong>{{ $recibo }}
        <hr>

    </p>

    <br>
    <table class="centrado">
        <thead>
        <tr>
            <th class="promo">MAYOR</th>
            <th class="promo">PROMO</th>
            <th class="promo">PAGADO</th>
            <th class="promo">COMISION</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reservas as $boleta)
            <tr>
                <td class="numero">{{ $boleta->numero }}</td>
                <td class="numero">{{ $boleta->promocional }}</td>
                <td class="numero">{{ $boleta->valor }}</td>
                <td class="numero">{{ $boleta->comision }}</td>
            </tr>
        @endforeach


        </tbody>
    </table>
<hr>
<p class="left">
    <strong>Cantidad de boletas:</strong> {{ $cantidad }}
    <br><strong>Valor boletas Total:</strong> {{ $valortotal }}
    <br><strong>Valor Total:</strong> {{ $comisionvendedor }}
    <br>
    <br><strong>Valor Entregar:</strong> {{ $valorentregar }}
    <br><strong>Vendedor:</strong> {{ $vendedor }}
</p>
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
        padding-left: 0px;
    }

    th.numero {
        font-size: 14px;

    }

    th.promo {
        font-size: 12px;

    }

    .centrado {
        text-align: center;
        align-content: center;
    }


</style>
