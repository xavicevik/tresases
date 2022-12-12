<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
<style>
    body {
        background-image: url("storage/img/boletas/5_base.png");
        background-size: cover;
    }

    @page {margin:0px;}
    p{
        font-family: Verdana;
        font-size: 26px;
        width: 80%;
        text-align: justify;
        margin-left: 10%;
        margin-top: 70%;
    }
</style>
</head>
<body>

<div id="contenedor" name="contenedor">
    <p>
        {{ $numero }}
        {{ $promocional }}
        {{ $codigo }}
    </p>
</div>

</body>
</html>
