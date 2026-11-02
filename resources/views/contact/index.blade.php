@extends('layouts.app')

@section('title', 'Contact Us - Flash-Tix')

@section('content')
<style>
    /* ============================================ */
    /* CONCERT THEME - STAGE LIGHTING & NEON */
    /* ============================================ */
    
    /* Floating WhatsApp */
    .float-wa {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .float-wa a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        border-radius: 50%;
        box-shadow: 0 0 20px rgba(37, 211, 102, 0.5);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .float-wa a:hover {
        transform: scale(1.1);
        box-shadow: 0 0 30px rgba(37, 211, 102, 0.8);
    }
    
    .float-wa i {
        font-size: 32px;
        color: white;
    }
    
    .float-wa .tooltip {
        position: absolute;
        right: 75px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.9);
        backdrop-filter: blur(10px);
        color: white;
        padding: 8px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(37, 211, 102, 0.3);
    }
    
    .float-wa:hover .tooltip {
        opacity: 1;
        visibility: visible;
    }
    
    /* Hero Section - Concert Stage */
    .hero-concert {
        position: relative;
        min-height: 500px;
        background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #0a0a0a 100%);
        overflow: hidden;
    }
    
    /* Stage Lighting Effect */
    .stage-lighting {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
    }
    
    .light-beam {
        position: absolute;
        bottom: 0;
        width: 4px;
        background: linear-gradient(to top, transparent, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.2));
        animation: lightSwing 3s ease-in-out infinite;
        transform-origin: bottom center;
    }
    
    @keyframes lightSwing {
        0%, 100% { transform: skewX(-10deg); opacity: 0.3; }
        50% { transform: skewX(10deg); opacity: 0.7; }
    }
    
    .light-beam:nth-child(1) { left: 10%; height: 200px; animation-delay: 0s; background: linear-gradient(to top, transparent, rgba(139, 92, 246, 0.8), transparent); }
    .light-beam:nth-child(2) { left: 25%; height: 250px; animation-delay: 0.5s; background: linear-gradient(to top, transparent, rgba(236, 72, 153, 0.8), transparent); }
    .light-beam:nth-child(3) { left: 40%; height: 180px; animation-delay: 1s; background: linear-gradient(to top, transparent, rgba(59, 130, 246, 0.8), transparent); }
    .light-beam:nth-child(4) { left: 55%; height: 220px; animation-delay: 0.3s; background: linear-gradient(to top, transparent, rgba(168, 85, 247, 0.8), transparent); }
    .light-beam:nth-child(5) { left: 70%; height: 190px; animation-delay: 0.8s; background: linear-gradient(to top, transparent, rgba(249, 115, 22, 0.8), transparent); }
    .light-beam:nth-child(6) { left: 85%; height: 240px; animation-delay: 1.2s; background: linear-gradient(to top, transparent, rgba(34, 197, 94, 0.8), transparent); }
    
    /* Background Crowd Silhouette */
    .crowd-silhouette {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 150px;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path fill="%231a1a2e" d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path></svg>') repeat-x bottom;
        background-size: 200px 60px;
        opacity: 0.6;
    }
    
    /* Neon Text Effect */
    .neon-text {
        text-shadow: 0 0 5px #7c3aed, 0 0 10px #7c3aed, 0 0 20px #7c3aed, 0 0 40px #ec4899;
        animation: neonPulse 1.5s ease-in-out infinite alternate;
    }
    
    @keyframes neonPulse {
        from { text-shadow: 0 0 5px #7c3aed, 0 0 10px #7c3aed, 0 0 20px #7c3aed; }
        to { text-shadow: 0 0 10px #ec4899, 0 0 20px #ec4899, 0 0 30px #ec4899, 0 0 60px #ec4899; }
    }
    
    /* Contact Card - Glass with Neon Border */
    .contact-card {
        background: rgba(20, 20, 40, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(139, 92, 246, 0.3);
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    
    .contact-card:hover {
        transform: translateY(-5px);
        border-color: #7c3aed;
        box-shadow: 0 0 30px rgba(139, 92, 246, 0.3);
    }
    
    .contact-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.2) 0%, rgba(236, 72, 153, 0.2) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(139, 92, 246, 0.5);
    }
    
    .contact-card:hover .contact-icon {
        transform: scale(1.1);
        box-shadow: 0 0 20px rgba(139, 92, 246, 0.5);
    }
    
    /* Map Container */
    .map-container {
        border-radius: 20px;
        overflow: hidden;
        border: 2px solid rgba(139, 92, 246, 0.3);
        transition: all 0.3s ease;
    }
    
    .map-container:hover {
        border-color: #7c3aed;
        box-shadow: 0 0 25px rgba(139, 92, 246, 0.4);
    }
    
    /* FAQ Accordion - Dark Theme */
    .faq-item {
        background: rgba(30, 30, 50, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(139, 92, 246, 0.3);
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    
    .faq-item:hover {
        border-color: #7c3aed;
        box-shadow: 0 0 20px rgba(139, 92, 246, 0.2);
    }
    
    .faq-question {
        width: 100%;
        padding: 18px 22px;
        text-align: left;
        font-weight: 600;
        color: white;
        background: transparent;
        border: none;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .faq-question:hover {
        color: #7c3aed;
    }
    
    .faq-question i {
        transition: transform 0.3s ease;
        color: #7c3aed;
    }
    
    .faq-question.active i {
        transform: rotate(180deg);
    }
    
    .faq-answer {
        padding: 0 22px 18px 22px;
        color: #cbd5e1;
        font-size: 14px;
        line-height: 1.6;
        display: none;
    }
    
    .faq-answer.show {
        display: block;
    }
    
    /* CTA Section - Stage Style */
    .cta-stage {
        background: linear-gradient(135deg, #1a1a2e 0%, #0a0a0a 100%);
        border: 2px solid rgba(139, 92, 246, 0.3);
        border-radius: 24px;
        position: relative;
        overflow: hidden;
    }
    
    .cta-stage::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* Music Note Floating */
    .music-note {
        position: absolute;
        font-size: 24px;
        opacity: 0.3;
        animation: floatNote 6s ease-in-out infinite;
        pointer-events: none;
    }
    
    @keyframes floatNote {
        0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.2; }
        50% { transform: translateY(-30px) rotate(10deg); opacity: 0.5; }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .light-beam { display: none; }
    }
</style>

<!-- Floating WhatsApp -->
<div class="float-wa">
    <a href="https://wa.me/6282210335302?text=Halo%20Flash-Tix%2C%20saya%20ingin%20bertanya%20tentang%20pemesanan%20tiket%20konser" target="_blank">
        <i class="fab fa-whatsapp"></i>
        <span class="tooltip">Chat via WhatsApp</span>
    </a>
</div>

<!-- ============================================ -->
<!-- HERO SECTION - CONCERT STAGE -->
<!-- ============================================ -->
<div class="hero-concert min-h-[500px] flex items-center relative">
    
    <!-- Stage Lighting Beams -->
    <div class="stage-lighting">
        <div class="light-beam"></div>
        <div class="light-beam"></div>
        <div class="light-beam"></div>
        <div class="light-beam"></div>
        <div class="light-beam"></div>
        <div class="light-beam"></div>
    </div>
    
    <!-- Crowd Silhouette -->
    <div class="crowd-silhouette"></div>
    
    <!-- Floating Music Notes -->
    <div class="music-note" style="top: 20%; left: 10%; animation-delay: 0s;">🎵</div>
    <div class="music-note" style="top: 50%; left: 85%; animation-delay: 1s;">🎸</div>
    <div class="music-note" style="top: 70%; left: 15%; animation-delay: 2s;">🎤</div>
    <div class="music-note" style="top: 30%; left: 75%; animation-delay: 1.5s;">🎶</div>
    <div class="music-note" style="top: 80%; left: 60%; animation-delay: 0.5s;">🥁</div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-5 py-2 mb-6 border border-purple-500/30">
                <span class="text-yellow-300 text-sm">🎤</span>
                <span class="text-white text-sm font-medium">LIVE SUPPORT 24/7</span>
                <span class="text-yellow-300 text-sm">🎸</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-bold mb-6">
                <span class="text-white">Contact</span>
                <span class="neon-text"> Us</span>
            </h1>
            <p class="text-white/80 text-xl max-w-2xl mx-auto">
                Kami siap membantu Anda seperti panggung yang siap menyambut penonton
            </p>
            <div class="flex flex-wrap gap-3 justify-center mt-6">
                <span class="bg-purple-500/20 backdrop-blur-sm rounded-full px-3 py-1 text-white text-sm border border-purple-500/30">🎫 24/7 Support</span>
                <span class="bg-pink-500/20 backdrop-blur-sm rounded-full px-3 py-1 text-white text-sm border border-pink-500/30">⚡ Fast Response</span>
                <span class="bg-blue-500/20 backdrop-blur-sm rounded-full px-3 py-1 text-white text-sm border border-blue-500/30">🎵 Live Chat</span>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MAIN CONTACT SECTION -->
<!-- ============================================ -->
<div class="py-20 bg-gradient-to-b from-gray-900 to-black">
    <div class="container mx-auto px-4">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            
            <!-- WhatsApp Card -->
            <div class="contact-card rounded-2xl p-6 text-center">
                <div class="contact-icon mx-auto mb-4">
                    <i class="fab fa-whatsapp text-purple-400 text-2xl"></i>
                </div>
                <h3 class="font-bold text-white text-lg mb-2">WhatsApp</h3>
                <p class="text-gray-400 text-sm mb-3">Chat langsung dengan tim kami</p>
                <a href="https://wa.me/6282210335302?text=Halo%20Flash-Tix%2C%20saya%20ingin%20bertanya%20tentang%20pemesanan%20tiket%20konser" 
                   target="_blank"
                   class="text-purple-400 font-semibold text-sm hover:text-purple-300 transition">
                    +62 822-1033-5302
                </a>
            </div>
            
            <!-- Email Card -->
            <div class="contact-card rounded-2xl p-6 text-center">
                <div class="contact-icon mx-auto mb-4">
                    <i class="fas fa-envelope text-purple-400 text-2xl"></i>
                </div>
                <h3 class="font-bold text-white text-lg mb-2">Email</h3>
                <p class="text-gray-400 text-sm mb-3">Kirim email untuk pertanyaan</p>
                <a href="mailto:support@flash-tix.com" 
                   class="text-purple-400 font-semibold text-sm hover:text-purple-300 transition">
                    support@flash-tix.com
                </a>
            </div>
            
            <!-- Phone Card -->
            <div class="contact-card rounded-2xl p-6 text-center">
                <div class="contact-icon mx-auto mb-4">
                    <i class="fas fa-phone text-purple-400 text-2xl"></i>
                </div>
                <h3 class="font-bold text-white text-lg mb-2">Telepon</h3>
                <p class="text-gray-400 text-sm mb-3">Hubungi langsung</p>
                <a href="tel:+622112345678" 
                   class="text-purple-400 font-semibold text-sm hover:text-purple-300 transition">
                    (021) 1234-5678
                </a>
            </div>
            
            <!-- Hours Card -->
            <div class="contact-card rounded-2xl p-6 text-center">
                <div class="contact-icon mx-auto mb-4">
                    <i class="fas fa-clock text-purple-400 text-2xl"></i>
                </div>
                <h3 class="font-bold text-white text-lg mb-2">Jam Operasional</h3>
                <p class="text-gray-400 text-sm">Senin - Minggu</p>
                <p class="text-purple-400 font-bold text-3xl mt-2">24/7</p>
                <p class="text-gray-500 text-xs">Nonstop siap membantu!</p>
            </div>
        </div>
        
        <!-- ============================================ -->
        <!-- MAP SECTION - IT DEL -->
        <!-- ============================================ -->
        <div class="mt-8">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-white mb-2">📍 Lokasi <span class="text-purple-400">Kami</span></h2>
                <p class="text-gray-400">Datangi langsung kantor pusat kami</p>
            </div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.831725372394!2d98.8432158147539!3d2.388184997990322!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e00fdad2d7341%3A0xf59ef99c591fe451!2sInstitut%20Teknologi%20Del!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                    width="100%" 
                    height="400" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <div class="text-center mt-4">
                <p class="text-gray-300">
                    <i class="fas fa-map-marker-alt text-purple-400 mr-2"></i>
                    Institut Teknologi Del, Jl. Sisingamangaraja No. 12, Laguboti, Toba Samosir, Sumatera Utara
                </p>
                <a href="https://www.google.com/maps/place/Institut+Teknologi+Del/@2.3832206,99.1460579,17z/data=!3m1!4b1!4m6!3m5!1s0x302e00fdad2d7341:0xf59ef99c591fe451!8m2!3d2.3832152!4d99.1486328!16s%2Fg%2F12148s15?entry=ttu" 
                   target="_blank"
                   class="inline-flex items-center gap-2 text-purple-400 text-sm mt-2 hover:text-purple-300 transition">
                    <i class="fas fa-directions"></i>
                    Buka di Google Maps
                </a>
            </div>
        </div>
        
        <!-- ============================================ -->
        <!-- FAQ SECTION -->
        <!-- ============================================ -->
        <div class="mt-20">
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 bg-purple-500/20 backdrop-blur-sm rounded-full px-4 py-1 mb-4 border border-purple-500/30">
                    <span class="text-purple-400 text-sm">❓</span>
                    <span class="text-purple-400 text-sm font-medium">Frequently Asked Questions</span>
                </div>
                <h2 class="text-3xl font-bold text-white">Pertanyaan <span class="text-purple-400">Umum</span></h2>
                <p class="text-gray-400 mt-2">Jawaban untuk pertanyaan yang sering diajukan</p>
            </div>
            
            <div class="max-w-3xl mx-auto space-y-4">
                <div class="faq-item">
                    <button class="faq-question">
                        <span>🎫 Bagaimana cara memesan tiket?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        Ikuti 4 langkah mudah: Pilih Konser → Pilih Kursi → Isi Data → Bayar. E-tiket akan langsung dikirim ke email Anda dalam hitungan menit.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question">
                        <span>🔄 Apakah tiket bisa refund?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        Tiket tidak dapat direfund kecuali konser dibatalkan oleh penyelenggara. Silakan hubungi customer support untuk informasi lebih lanjut.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question">
                        <span>⏰ Berapa lama tiket akan dikirim?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        E-tiket langsung dikirim ke email dalam hitungan menit setelah pembayaran berhasil dikonfirmasi. Cek folder Spam jika belum menerima.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question">
                        <span>💳 Metode pembayaran apa saja yang tersedia?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        QRIS, Bank Transfer (BCA, Mandiri, BNI, BRI), E-Wallet (GoPay, OVO, Dana, LinkAja), dan Kartu Kredit (Visa, Mastercard).
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- CTA SECTION - STAGE STYLE -->
<!-- ============================================ -->
<div class="py-16">
    <div class="container mx-auto px-4">
        <div class="cta-stage p-12 text-center relative z-10">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-6 border border-purple-500/30">
                    <span class="text-yellow-300 text-sm">🌟</span>
                    <span class="text-white text-sm">Ready to Rock!</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Kami Siap Membantu Anda <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">24/7</span>
                </h2>
                <p class="text-white/80 text-lg mb-8 max-w-2xl mx-auto">
                    Tim support kami selalu siap seperti panggung yang siap menyambut penonton
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://wa.me/6282210335302?text=Halo%20Flash-Tix%2C%20saya%20ingin%20bertanya%20tentang%20pemesanan%20tiket%20konser" 
                       target="_blank"
                       class="bg-gradient-to-r from-green-500 to-green-600 text-white px-8 py-3 rounded-full font-semibold hover:shadow-xl transition transform hover:scale-105 inline-flex items-center gap-2">
                        <i class="fab fa-whatsapp"></i>
                        Chat via WhatsApp
                    </a>
                    <a href="mailto:support@flash-tix.com" 
                       class="bg-white/20 border border-white/30 text-white px-8 py-3 rounded-full font-semibold hover:bg-white/30 transition inline-flex items-center gap-2">
                        <i class="fas fa-envelope"></i>
                        Kirim Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // FAQ Accordion
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
            const answer = button.nextElementSibling;
            const isActive = answer.classList.contains('show');
            
            document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('show'));
            document.querySelectorAll('.faq-question').forEach(q => q.classList.remove('active'));
            
            if (!isActive) {
                answer.classList.add('show');
                button.classList.add('active');
            }
        });
    });
    
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
@endsection