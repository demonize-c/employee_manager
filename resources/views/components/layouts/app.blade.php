<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        @include('components.includes.css')
    </head>
    <body>

    <div class="d-flex">
    <!-- Sidebar -->
    @include('components.includes.leftbar')

    <!-- Main Content -->
    <div class="flex-grow-1 d-flex flex-column">
      <!-- Navbar -->
      @include('components.includes.navbar')
      {{$slot}}
    </div>
    </div>
        @include('components.includes.js')
    </body>
</html>
