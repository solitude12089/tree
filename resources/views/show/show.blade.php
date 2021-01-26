<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/skin.css" rel="stylesheet">

    <!-- Scripts -->
    <style>
        .my_h2{
            font-size:36px;
            text-align: center;
            font-weight: bold;
        }
        img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }
        

    </style>

</head>
<body class="skin-v2">
    <script src="/js/app.js"></script>


    <div>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0"></nav>
        <div class="col-sm-12">
                <h2 class='my_h2'>{{$tree->name}}</h2>
                <div>
                    {!!$tree->description!!}
                </div>
        </div>





    </div>



    <!-- Scripts -->


</body>
</html>
