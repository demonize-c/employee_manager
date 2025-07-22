<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        @livewireStyles
        @include('includes.css')
        @yield('css')
    </head>
    <body>

        <div class="wrapper">
        <div class="main d-flex">
            <!-- Sidebar -->
            @include('includes.leftbar')

            <!-- Main Content -->
            <div class="flex-grow-1 d-flex flex-column">
                <!-- Navbar -->
                @include('includes.navbar')

                <div class="content p-0 m-0">
                    @yield('content')
                </div>
            </div>
        </div> <!-- end .main -->
        </div> <!-- end .wrapper -->
        
        @include('includes.js')
        @yield('js')
    </body>
</html>
