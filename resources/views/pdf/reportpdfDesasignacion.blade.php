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
        <strong>DESASIGNAR BOLETERIA</strong>
        <br><strong>Recibo: </strong>{{ $recibo }}
        <hr>

    </p>

    <br>
    <table class="centrado">
        <thead>
        <tr>
            <th class="mayor">MAYOR</th>
            <th class="promo">PROMO</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reservas as $boleta)
            <tr>
                <td class="numero">{{ $boleta->numero }}</td>
                <td class="numero">{{ $boleta->promocional }}</td>
            </tr>
        @endforeach


        </tbody>
    </table>
<hr>
<p class="left"><strong>Total boletas Entregadas:</strong> {{ $cantidad }}
    <br><strong>Vendedor</strong>: {{ $vendedor }}
</p>
</div>
</body>
</html>

<style>
    * {
        font-size: 16px;
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
