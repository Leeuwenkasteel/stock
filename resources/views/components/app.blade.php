<!doctype html>
<html lang="nl">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Stock</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="{{asset('css/style.css')}}"></link>
		<link rel="stylesheet" href="{{asset('css/custom.css')}}"></link>
    @livewireStyles

    <style>
        body {
            background: #f1f5f9;
            font-family: system-ui, -apple-system, sans-serif;
        }

        .stock-header {
            height: 64px;
            background: #198754;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }

        .stock-header .logo {
            font-size: 1.4rem;
            font-weight: 700;
        }

        .stock-header i {
            font-size: 1.6rem;
        }


        .stock-container {
            padding: 15px;
        }


        .stock-card {
            background: white;
            border-radius: 16px;
            padding: 15px;
            box-shadow: 0 3px 10px rgba(0,0,0,.08);
        }


        .product-btn {
            min-height: 100px;
            border-radius: 14px;
            font-size: 1.1rem;
            font-weight: 600;
        }


        .action-btn {
            min-height: 75px;
            border-radius: 12px;
            font-size: 1rem;
        }


        .stock-footer {
            position: fixed;
            bottom: 0;
            left:0;
            right:0;
            height:55px;
            background:white;
            border-top:1px solid #ddd;
            display:flex;
            justify-content:space-around;
            align-items:center;
        }

        .stock-footer a {
            color:#198754;
            text-decoration:none;
            font-size:.85rem;
        }

        .stock-footer i {
            display:block;
            text-align:center;
            font-size:1.3rem;
        }

    </style>

    @stack('styles')

</head>


<body>


<header class="stock-header">

    <div class="d-flex align-items-center">
        <i class="bi bi-box-seam me-2"></i>

        <div class="logo">
            Stock
        </div>
    </div>



</header>


<div class="stock-container mb-5">

    {{ $slot }}

</div>

<footer class="stock-footer">

    <a href="{{route('stock.home')}}">
        <i class="bi bi-house"></i>
        Home
    </a>
	<a href="{{route('stock.st')}}">
        <i class="bi bi-box-arrow-in-down"></i>
        Voorraad
    </a>
    <a href="{{route('stock.scan')}}">
        <i class="bi bi-printer"></i>
        Labels
    </a>
	
	<!--<a href="/stock/app/products">
        <i class="bi bi-boxes"></i>
        Producten
    </a>-->
	<a href="/stock/app/logout">
        <i class="bi bi-power"></i>
        Uitloggen
    </a>

</footer>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@livewireScripts

@stack('scripts')


</body>
</html>