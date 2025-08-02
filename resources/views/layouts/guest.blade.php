<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        @livewireStyles
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <style>
               body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    height: 100vh;
                    margin: 0;
                    overflow: hidden;
                    display: flex;
                }
                
                .wrapper {
                    display: flex;
                    flex-direction: column;
                    width: 100%;
                    height: 100vh;
                }
  
        </style>
        @yield('css')
    </head>
    <body>

        <div class="wrapper">
             @yield('content')
        </div> <!-- end .wrapper -->
        @yield('js')
    </body>
</html>
