<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rajarata Sakura</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>
<body>

    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')

    <!-- Include Hero Slideshow JS -->
    <script src="{{ asset('js/hero-slideshow.js') }}"></script>
</body>
</html>