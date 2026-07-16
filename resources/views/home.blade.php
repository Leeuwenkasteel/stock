<x-stock::layout>

    <div class="row g-3">

        <div class="col-6">
            <a href="{{route('stock.st')}}" class="btn btn-success w-100 product-btn">
                <i class="bi bi-box-arrow-in-down fs-2 d-block"></i>
                Voorraad<br>updaten
            </a>
        </div>


        <div class="col-6">
            <a href="{{route('stock.scan')}}" class="btn btn-primary w-100 product-btn">
                <i class="bi bi-printer fs-2 d-block"></i>
                Labels<br>printen
            </a>
        </div>


        <!--<div class="col-6">
            <a href="/stock/app/scan" class="btn btn-warning w-100 product-btn text-white">
                <i class="bi bi-upc-scan fs-2 d-block"></i>
                Product<br>informatie
            </a>
        </div>


        <!--<div class="col-6">
            <a href="/stock/app/stock" class="btn btn-danger w-100 product-btn">
                <i class="bi bi-boxes fs-2 d-block"></i>
                Voorraad<br>bekijken
            </a>
        </div>-->

    </div>

</x-stock::layout>