<!doctype html>
<html lang="nl">

<head>
    <meta charset="utf-8">

    {{-- 📱 MOBILE FIX (belangrijk voor camera/scanner) --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <link rel="stylesheet" href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    {{-- Styles --}}
    <style>
        body, html { height:100%; margin:0; }
        header { height:60px; line-height:60px; }
        .product-btn { min-height:90px; font-size:1.1rem; }
        .action-grid button { min-height:80px; font-size:1rem; }
    </style>

    @stack('styles')

    {{-- Livewire styles (BELANGRIJK) --}}
    @livewireStyles
</head>

<body>

<div class="container mt-5">
    {{ $slot }}
</div>

{{-- jQuery (alleen nodig als je het echt gebruikt) --}}
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- Livewire scripts (BELANGRIJK voor scanner) --}}
@livewireScripts

{{-- Scripts stack (barcode scanner etc.) --}}
@stack('scripts')

</body>
</html>
