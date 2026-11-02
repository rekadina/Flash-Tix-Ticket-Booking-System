@extends('layouts.app')

@section('title', 'Gate Scanner - Flash-Tix')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<style>
    body { background-color: #0b0f19; transition: background-color 0.5s ease; }
    .bg-success { background-color: #064e3b !important; } /* Hijau Gelap */
    .bg-danger { background-color: #7f1d1d !important; } /* Merah Gelap */
    
    #reader {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        border: 4px solid #4c1d95;
        border-radius: 20px;
        overflow: hidden;
        background: #000;
        box-shadow: 0 0 30px rgba(124, 58, 237, 0.4);
    }
    #reader video { object-fit: cover; }
    
    /* Styling khusus untuk animasi tepuk tangan */
    .swal-clap-icon {
        width: 100px !important;
        height: 100px !important;
        margin: 0 auto 15px auto !important;
        border: none !important;
    }
</style>

<div class="min-h-screen py-10" id="scanner-container">
    <div class="container mx-auto px-4 text-center">
        
        <h1 class="text-3xl font-black text-white uppercase font-['Space_Grotesk'] mb-2 tracking-widest">
            <i class="fas fa-expand text-purple-500 mr-2"></i> Gate Scanner
        </h1>
        <p class="text-slate-400 text-sm mb-8">Arahkan QR Code E-Tiket pengunjung ke kamera.</p>

        <div id="reader"></div>

        <div class="mt-8 text-center max-w-lg mx-auto">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 text-slate-300 text-xs font-mono">
                <i class="fas fa-circle-notch fa-spin text-purple-500 mr-2"></i> Menunggu pindaian QR Code...
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-block mt-6 text-slate-500 hover:text-white transition font-bold">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Command Center
            </a>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Audio Beep menggunakan Data URI
        const beepSound = new Audio('data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YU'+Array(1e3).join('123')); 
        beepSound.volume = 0.5;

        // FUNGSI ANIMASI CONFETTI KEREN
        function fireConfetti() {
            var duration = 3000;
            var animationEnd = Date.now() + duration;
            var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 9999 };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            var interval = setInterval(function() {
                var timeLeft = animationEnd - Date.now();
                if (timeLeft <= 0) { return clearInterval(interval); }
                var particleCount = 50 * (timeLeft / duration);
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
            }, 250);
        }

        let isScanning = true;
        
        // KONFIGURASI SCANNER DIPERCEPAT (30 FPS & FOKUS QR CODE)
        const html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
            fps: 30, 
            qrbox: {width: 250, height: 250},
            aspectRatio: 1.0,
            formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ]
        }, false);

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);

        function onScanSuccess(decodedText, decodedResult) {
            if (!isScanning) return;
            
            // Jeda scanner agar tidak menembak berkali-kali ke server
            isScanning = false;
            html5QrcodeScanner.pause(true);
            
            // Mainkan bunyi BEEP
            try { beepSound.play(); } catch(e) {}

            // Kirim data Order ID ke Laravel Backend via AJAX (Fetch API)
            fetch("{{ route('admin.scanner.verify') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ order_id: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                const body = document.body;
                
                if (data.success) {
                    // TIKET VALID - Layar Hijau + Tepuk Tangan + Confetti
                    body.classList.add('bg-success');
                    fireConfetti(); // Ledakkan confetti!
                    
                    Swal.fire({
                        title: 'AKSES DIBERIKAN',
                        html: `<p style="margin-top:10px">${data.message}</p>`,
                        imageUrl: 'https://fonts.gstatic.com/s/e/notoemoji/latest/1f44f/512.gif', // Animasi Tepuk Tangan
                        imageWidth: 100,
                        imageHeight: 100,
                        imageAlt: 'Tepuk Tangan',
                        customClass: { image: 'swal-clap-icon' },
                        background: '#064e3b',
                        color: '#fff',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Lanjut Scan Berikutnya <i class="fas fa-arrow-right ml-1"></i>'
                    }).then(() => resetScanner(body, 'bg-success'));
                } else {
                    // TIKET GAGAL/SUDAH DIPAKAI - Layar Merah
                    body.classList.add('bg-danger');
                    Swal.fire({
                        icon: 'error',
                        title: 'AKSES DITOLAK',
                        text: data.message,
                        background: '#7f1d1d',
                        color: '#fff',
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Tutup <i class="fas fa-times ml-1"></i>'
                    }).then(() => resetScanner(body, 'bg-danger'));
                }
            })
            .catch(error => {
                console.error("Error:", error);
                resetScanner(document.body, '');
            });
        }

        function onScanFailure(error) {
            // Abaikan error background saat kamera mencari frame QR
        }

        function resetScanner(bodyElement, classToRemove) {
            if (classToRemove) bodyElement.classList.remove(classToRemove);
            isScanning = true;
            html5QrcodeScanner.resume();
        }
    });
</script>
@endsection