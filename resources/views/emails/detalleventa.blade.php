<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de la venta</title>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-10">
            <div class="receipt bg-white p-3 rounded">
                <img src="/storage/img/{{ $data['data']['url'] }}" width="120">
                <h4 class="mt-2 mb-3">Su orden ha sido confirmada!</h4>
                <h6 class="name">Hola {{ $data['data']['cliente']['nombre'] }},</h6><span class="fs-12 text-black-50">Se ha realizado la venta de las boletas satisfactoriamente</span>
                <hr>
                <div class="d-flex flex-row justify-content-between align-items-center order-details">
                    <div><span class="d-block fs-12">Fecha de la orden</span><span class="font-weight-bold">{{ $data['data']['fechaventa'] }}</span></div>
                    <div><span class="d-block fs-12">Número de Orden</span><span class="font-weight-bold">{{ $data['data']['id'] }}</span></div>
                    <div><span class="d-block fs-12">Método de pago</span><span class="font-weight-bold">Credit card</span><img class="ml-1 mb-1" src="https://i.imgur.com/ZZr3Yqj.png" width="20"></div>
                </div>
                <hr>

                <div class="d-flex justify-content-between align-items-center product-details">
                    <div class="d-flex flex-row product-name-image"><img class="rounded" src="https://i.imgur.com/GsFeDLn.jpg" width="80">
                        <div class="d-flex flex-column justify-content-between ml-2">
                            <div><span class="d-block font-weight-bold p-name">Ralco formal shirts for men</span><span class="fs-12">Clothes</span></div><span class="fs-12">Qty: 1pcs</span></div>
                    </div>
                    <div class="product-price">
                        <h5>$70</h5>
                    </div>
                </div>

                <div class="mt-5 amount row">
                    <div class="d-flex justify-content-center col-md-6"><img src="https://i.imgur.com/AXdWCWr.gif" width="250" height="100"></div>
                    <div class="col-md-6">
                        <div class="billing">
                            <div class="d-flex justify-content-between"><span>Subtotal</span><span class="font-weight-bold">$120</span></div>
                            <hr>
                            <div class="d-flex justify-content-between mt-1"><span class="font-weight-bold">Total</span><span class="font-weight-bold text-success">$165</span></div>
                        </div>
                    </div>
                </div><span class="d-block">Expected delivery date</span><span class="font-weight-bold text-success">12 March 2020</span><span class="d-block mt-3 text-black-50 fs-15">We will be sending a shipping confirmation email when the item is shipped!</span>
                <hr>
                <div class="d-flex justify-content-between align-items-center footer">
                    <div class="thanks"><span class="d-block font-weight-bold">Thanks for shopping</span><span>Amazon team</span></div>
                    <div class="d-flex flex-column justify-content-end align-items-end"><span class="d-block font-weight-bold">Need Help?</span><span>Call - 974493933</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<style>
    body {
        background-color: #eee;
    }

    .fs-12 {
        font-size: 12px;
    }

    .fs-15 {
        font-size: 15px;
    }

    .name {
        margin-bottom: -2px;
    }

    .product-details {
        margin-top: 13px;
    }
</style>
</html>
