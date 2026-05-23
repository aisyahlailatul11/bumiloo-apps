<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    /* 🌸 MINI-FOOTER CENTER TRANSPARAN */
    .bumiloo-footer {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        width: 100% !important;
        background: rgba(255, 255, 255, 0.4) !important; /* Efek kaca tipis */
        backdrop-filter: blur(10px);
        border-top: 1px solid rgba(248, 117, 170, 0.15) !important;
        color: #1E3A5F !important; /* Biru navy biar elegan */
        padding: 12px 20px !important;
        z-index: 100;
    }

    .footer-content {
        display: flex !important;
        flex-direction: column !important; /* Mutlak numpuk atas bawah */
        align-items: center !important;    /* Kunci di tengah */
        justify-content: center !important;
        gap: 2px !important;               /* Jarak antar teks super tipis */
        width: 100% !important;
        margin: 0 auto !important;
    }

    .footer-text {
        margin: 0 !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        line-height: 1.4;
    }

    .footer-text-muted {
        color: #64748B !important;
        font-weight: 400 !important;
    }

    .footer-sosmed {
        display: flex !important;
        gap: 16px !important;
        margin-top: 6px !important; /* Jarak ke ikon sosmed */
    }

    .footer-sosmed a {
        color: #f875aa !important; /* Ikon warna pink bumiloo */
        font-size: 15px !important;
        transition: 0.2s ease-in-out !important;
        text-decoration: none !important;
    }
    .footer-sosmed a:hover {
        transform: translateY(-2px) !important;
        color: #E91E8C !important;
    }
</style>

<footer class="bumiloo-footer">
    <div class="footer-content">
        <p class="footer-text class=footer-text-muted">2026 © Copyright</p>
        <p class="footer-text" style="font-weight: 600 !important;">Praktik Bidan Mandiri Siti Fatimah</p>
        <p class="footer-text footer-text-muted" style="font-size: 11px !important;">Jl. Melati No. 2,Jember</p>
        
        <div class="footer-sosmed">
            <a href="#" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" target="_blank" title="Youtube"><i class="fab fa-youtube"></i></a>
            <a href="https://wa.me/087656433212" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            <a href="#" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        </div>
    </div>
</footer>