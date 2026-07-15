<div class="container py-3">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3 text-center">📷 Barcode Scanner</h4>

            {{-- Scanner --}}
            <div id="scanner-container"
                 wire:ignore
                 class="w-100 border rounded overflow-hidden position-relative"
                 style="height: 300px; background: #000;">

                {{-- Scan overlay --}}
                <div style="
                    position:absolute;
                    top:50%;
                    left:50%;
                    width:220px;
                    height:220px;
                    transform:translate(-50%,-50%);
                    border:2px solid #00ff88;
                    border-radius:10px;
                    pointer-events:none;
                "></div>

            </div>

            {{-- Controls --}}
            <div class="d-flex justify-content-center gap-2 mt-3">
                <button class="btn btn-sm btn-outline-primary" onclick="startScanner()"><i class="bi bi-play-fill"></i> Start</button>
                <button class="btn btn-sm btn-outline-warning" onclick="restartScanner()"><i class="bi bi-repeat"></i> Refresh</button>
                <button class="btn btn-sm btn-outline-danger" onclick="stopScanner()"><i class="bi bi-sign-stop"></i> Stop</button>
            </div>
			</div>
			</div>
			<div class="card shadow-sm mt-1">
    <div class="card-body">

        <div class="small text-muted text-center">
            Handmatig toevoegen:
        </div>

        <div class="input-group mt-1">
            <input 
                type="number" 
                class="form-control form-control-sm" 
                wire:model="add"
            >

            <button 
                class="btn btn-primary btn-sm"
                wire:click="handleBarcode"
                type="button"
            >
                <i class="bi bi-search"></i>
            </button>
        </div>

    </div>
</div>
			<div class="card shadow-sm mt-1">
        <div class="card-body">

            {{-- Result --}}
            <div class="mt-3 text-center">
                <div class="small text-muted">Gescande barcode:</div>
                <div class="fs-5 fw-bold">
                    {{ $barcode ?: 'Nog niets gescand' }}
                </div>
            </div>
			</div>
			</div>

            {{-- Items --}}
            <div >

                @foreach($table as $t)
                    <div class="card mb-2 shadow-sm mt-1" wire:key="stock-{{ $t->id }}">
                        <div class="card-body">

                            <div class="d-flex justify-content-between small text-muted">
                                <span>#{{ $t->product->nr }}</span>
                                <span>€ {{ $t->product->price }}</span>
								<div class="text-end">
								<button
									class="btn btn-sm btn-outline-danger"
									wire:click="delete({{ $t->id }})"
								>
									<i class="bi bi-trash"></i>
								</button>
							</div>
                            </div>

                            {{-- Titel --}}
                            <label class="form-label small mt-2 fw-bold">Titel:</label>
							<small>{{ $t->product->translations->title }}</small>

                            {{-- Print --}}
                            <div class="d-flex justify-content-between mt-3">
                                <span class="small text-muted">Labels printen</span>
                                <input type="number"
                                       class="form-control form-control-sm text-center"
                                       style="width:90px;"
                                       value="{{ $t->quantity }}"
                                       wire:change="updateQuantity({{ $t->id }}, $event.target.value)" />
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
			@if($table->count() > 0)
			<div class="card shadow-sm mt-1">
			<div class="card-body">
				<button class="btn btn-outline-primary btn-sm w-100" onclick="confirmPrintLabels()">Print Labels</button>
			</div>
			</div>
			@endif
</div>

@pushonce('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let scanner = null;
let scannerRunning = false;
let lastCode = null;
let lastTime = 0;

function onScanSuccess(decodedText) {

    const now = Date.now();

    if (now - lastTime < 1200) return;
    lastTime = now;

    if (decodedText === lastCode) return;
    lastCode = decodedText;

    navigator.vibrate?.(100);

    Livewire.dispatch('barcodeScanned', { code: decodedText });
}

function startScanner() {

    if (scannerRunning) return;

    scanner = new Html5Qrcode("scanner-container");

    Html5Qrcode.getCameras().then(devices => {

        const backCamera =
            devices.find(d => (d.label || '').toLowerCase().includes('back')) ||
            devices[0];

        const config = {
            fps: 10,
            qrbox: { width: 220, height: 220 },
            videoConstraints: {
                facingMode: "environment",
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        };

        scanner.start(backCamera.id, config, onScanSuccess)
            .then(() => scannerRunning = true)
            .catch(() => alert("Camera fout"));
    });
}

function stopScanner() {
    if (!scannerRunning) return;

    scanner.stop().then(() => {
        scanner.clear();
        scannerRunning = false;
    }).catch(() => {});
}

function restartScanner() {
    stopScanner();
    setTimeout(startScanner, 400);
}

document.addEventListener("livewire:init", () => startScanner());
document.addEventListener("livewire:navigating", () => stopScanner());
</script>
<script>
document.addEventListener('livewire:init', () => {

    Livewire.on('productNotFound', (event) => {

        Swal.fire({
            icon: 'error',
            title: 'Product niet gevonden',
            text: `Barcode: ${event.code}`,
            confirmButtonText: 'OK',
            timer: 2500,
            timerProgressBar: true
        });

    });
	


});
	function confirmPrintLabels() {

    Swal.fire({
        title: 'Labels printen?',
        text: 'Weet je zeker dat je de labels wilt afdrukken?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ja, printen',
        cancelButtonText: 'Annuleren'
    }).then((result) => {

        if (result.isConfirmed) {
            Livewire.dispatch('printLabels');
        }

    });

}
</script>
@endpushonce