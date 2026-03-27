<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Rajarata Sakura Restaurant</title>
    <meta name="description" content="Rajarata Sakura Restaurant – Authentic Sri Lankan and Japanese cuisine.">

    <!-- CSS Files -->
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/popup.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <!-- Wrapper for flex layout -->
    <div class="page-wrapper">

        <!-- Header -->
        @include('layouts.header')

        <!-- Main Content -->
        <main class="content">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.footer')

    </div>

    @yield('scripts')

</body>
</html>