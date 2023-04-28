<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
<style>
    body {
        background-image: url({{ $url }});
        background-size: cover;
    }

    @page {margin:0px;}
    #p1{
        font-family: Verdana;
        font-size: 40px;
        width: 80%;
        text-align: justify;
        margin-left: 7%;
        margin-top: 52%;
    }


    #p3{
        font-family: Verdana;
        font-size: 25px;
        margin-left: 80%;
        padding-top: 10%;
    }
</style>
</head>
<body>

<div id="contenedor" name="contenedor">
    <p id="p1">
        {{ $numero }} &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {{ $promocional }}
    </p>
    <p id="p3">
        {{ $codigo }}
    </p>
</div>

</body>
</html>
