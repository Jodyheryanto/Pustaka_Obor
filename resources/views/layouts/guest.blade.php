@php
date_default_timezone_set("Asia/Bangkok");//set you countary name from below timezone list
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - Sidabor</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
        <style>
            .input-group{
            display: table;
            border-collapse: collapse;
            width:100%;
            }
            .input-group > div{
            display: table-cell;
            border: 1px solid #ddd;
            vertical-align: middle;  /* needed for Safari */
            }
            .input-group-icon:hover {
            cursor:pointer;
            }
            .input-group-icon{
            background:#eee;
            color: #777;
            padding: 0 12px
            }
            .input-group-area{
            width:100%;
            }
            .input-group input{
            border: 0;
            display: block;
            width: 100%;
            padding: 8px;
            }
        </style>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>
        <!-- BEGIN: Vendor JS-->
        <script src="/app-assets/vendors/js/vendors.min.js"></script>
        <!-- BEGIN Vendor JS-->
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
