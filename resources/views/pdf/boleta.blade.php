<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
<style>
    body {
        background-image: url("storage/img/boletas/4_base.png");
        background-size: cover;
    }

    @page {margin:0px;}
    #p2{
        font-family: Verdana;
        font-size: 40px;
        width: 80%;
        text-align: justify;
        margin-left: 17%;
        margin-top: 39%;
    }

    #p1{
        font-family: Verdana;
        font-size: 40px;
        width: 80%;
        text-align: justify;
        margin-left: 9%;
        padding-top: 13.5%;
    }

    #p3{
        font-family: Verdana;
        font-size: 25px;
        margin-left: 80%;
        padding-top: -2.5%;
    }
</style>
</head>
<body>

<div id="contenedor" name="contenedor">
    <p id="p2">
        {{ $numero }}
    </p>
    <p id="p1">
        {{ $promocional }}
    </p>
    <p id="p3">
        {{ $codigo }}
    </p>
</div>

</body>
</html>
