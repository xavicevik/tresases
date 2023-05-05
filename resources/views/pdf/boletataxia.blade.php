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
            font-size: 48px;
            width: 100%;
            position: absolute;
            text-align: justify;
            top: 600px;
            left: 180px;
        }


        #p3{
            font-family: Verdana;
            font-size: 35px;
            width: 100%;
            position: absolute;
            text-align: justify;
            top: 1000px;
            left: 1200px;
        }
    </style>
</head>
<body>

<div id="contenedor" name="contenedor">
    <p id="p1">
        {{ $numero }} &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
        {{ $promocional }}
    </p>
    <p id="p3">
        {{ $codigo }}
    </p>
</div>

</body>
</html>
