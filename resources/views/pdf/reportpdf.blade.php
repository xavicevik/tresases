<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css"> <script src="script.js"></script>
</head>
<body>
<style>
    @page {
        margin-left: 1cm;
        margin-right: 0;
        margin-top: 0cm;
        margin-bottom: 0.5cm;
    }
</style>
<div class="ticket">
    <img
        src="storage/img/logo_baner.jpg"
        alt="Logotipo"
        class="imgx"
    >
    <p class="centrado">TresAses
        <br>Colombia
        <br>{{ $venta->fechaventa }}
        <br>Venat #{{ $venta->id }}
        <br>Cliente:
        <br>{{ $cliente->nombre }}
        <br>Documento:
        <br>{{$cliente->documento}}
        <br>Correo:
        <br>{{$cliente->correo}}
        <br>Vendedor:
        <br>{{$vendedor->nombre}}
    </p>

    <br>
    <table>
        <thead>
        <tr>
            <th class="cantidad">Rifa</th>
            <th class="producto">Número</th>
            <th class="precio">$$</th>
        </tr>
        </thead>
        <tbody>
        @foreach($detalles as $boleta)
            <tr>
                <td class="cantidad">{{ $boleta['rifa']['nombre_tecnico'] }}</td>
                <td class="producto">{{ $boleta->numero }}</td>
                <td class="precio">{{ $boleta->valortotal }}</td>
            </tr>
        @endforeach

        <tr>
            <td class="cantidad"></td>
            <td class="producto">TOTAL</td>
            <td class="precio">{{ $venta->valortotal }}</td>
        </tr>
        </tbody>
    </table>
    <p class="centrado">¡GRACIAS POR SU COMPRA!
        <br>TresAses.com.co</p>
</div>
</body>
</html>
<script>
    function formatPrice(value) {
        let val = (value/1).toFixed(0).replace('.', ',')
        return '$ '+ val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }
</script>
<style>
    * {
        font-size: 12px;
        font-family: 'Times New Roman';
    }

    td,
    th,
    tr,
    table {
        border-top: 1px solid black;
        border-collapse: collapse;
    }

    td.producto,
    th.producto {
        width: 75px;
        max-width: 75px;
    }

    td.cantidad,
    th.cantidad {
        width: 40px;
        max-width: 40px;
        word-break: break-all;
    }

    td.precio,
    th.precio {
        width: 40px;
        max-width: 40px;
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
