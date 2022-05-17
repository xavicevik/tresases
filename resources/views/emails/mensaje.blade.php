<!DOCTYPE html>
<html>
<head>
    <title>Message</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .content { text-align: center; }
        .title { font-size: 84px; }
    </style>
</head>
<body>
<br />

<img src="/storage/{{ $data['url'] }}" alt="" width="300" style="height:auto;display:block;" />

<br>
<div class="container box" style="width: 970px;">
    <h1 style="text-align:center;"> {{ $data['name'] }} </h1>
    <br>
    <p align="center">{{ $data['message'] }}</p>
</div>
</body>
</html>
