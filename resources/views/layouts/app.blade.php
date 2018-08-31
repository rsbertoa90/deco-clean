<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Deco') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">

    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

</head>
<body>
    <div id="app">
        <div class=" m-0 w-100">
            <app-nav class="row w-100 m-0"></app-nav>
                <main class="py-4">
                    <div class="container container-fluid">
                        @yield('content')
                    </div>
                </main>
            {{-- <app-footer></app-footer> --}}
        </div>

        
    </div>
    <script src="https://unpkg.com/ionicons@4.2.6/dist/ionicons.js"></script>
    
    @yield('js')
   
</body>
</html>
