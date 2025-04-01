<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Custom Auth Laravel')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
  </head>
  <body class="bg-gray-50">
    @yield('content')

    <!-- Include compiled JavaScript -->
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
  </body>
</html>