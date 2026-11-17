<?php
/** @var array $galeriVideo */
/** @var array $galeriFoto */
/** @var array|null $pasien */
/** @var array $profil */
/** @var array $testimoni */
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($profil['hero_judul'] ?? 'Klinik Bunanur') ?> | Gentle Care For Mother & Baby</title>

    <!-- Google Fonts & Boxicons & Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Master Medical Glassmorphism 3D CSS (Light Mode) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">

    <style>
        :root {
            --bg-base: #fff5f7;
            --primary-rose: #f43f5e;
            --primary-pink: #ec4899;
            --rose-dark: #be123c;
            --glass-card-bg: rgba(255, 255, 255, 0.80);
            --glass-border-color: rgba(244, 63, 94, 0.16);
        }

        body {
            background: linear-gradient(135deg, #fff5f7 0%, #fdf2f8 50%, #fce7f3 100%);
            color: #1e293b;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            position: relative;
        }

        /* ================= FLOATING GLASS NAVBAR (LIGHT MODE) ================= */
        .cyber-navbar {
            position: fixed;
            top: 18px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 60px);
            max-width: 1240px;
            padding: 14px 28px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1.5px solid rgba(244, 63, 94, 0.15);
            border-radius: 24px;
            box-shadow: 0 16px 40px rgba(244, 63, 94, 0.08), 0 4px 16px rgba(0, 0, 0, 0.02);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .cyber-navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 20px;
            right: 20px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(244, 63, 94, 0.35), transparent);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .nav-brand img {
            width: 44px;
            height: 44px;
            background: #ffffff;
            padding: 5px;
            border-radius: 14px;
            border: 1.5px solid rgba(244, 63, 94, 0.3);
            box-shadow: 0 4px 14px rgba(244, 63, 94, 0.15);
            object-fit: contain;
        }

        .nav-brand h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 21px;
            font-weight: 800;
            color: #4c0519;
            letter-spacing: 0.5px;
        }

        .nav-brand span {
            color: var(--primary-rose);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .nav-links a {
            color: #64748b;
            text-decoration: none;
            font-size: 14.5px;
            font-weight: 600;
            transition: all 0.25s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--primary-rose);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        /* Profile Dropdown */
        .profile-area {
            position: relative;
        }

        .avatar-user {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-rose);
            box-shadow: 0 4px 14px rgba(244, 63, 94, 0.25);
            cursor: pointer;
            transition: transform 0.25s ease;
        }

        .avatar-user:hover {
            transform: scale(1.08);
        }

        .profile-dropdown-cyber {
            display: none;
            position: absolute;
            top: 56px;
            right: 0;
            width: 240px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1.5px solid rgba(244, 63, 94, 0.18);
            border-radius: 20px;
            box-shadow: 0 16px 40px rgba(244, 63, 94, 0.15), 0 4px 16px rgba(0, 0, 0, 0.05);
            padding: 18px;
            z-index: 1001;
        }

        .profile-dropdown-cyber h4 {
            font-size: 15px;
            font-weight: 800;
            color: #4c0519;
            margin-bottom: 2px;
        }

        .profile-dropdown-cyber p {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 14px;
            word-break: break-all;
        }

        .profile-dropdown-cyber a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            color: #334155;
            margin-bottom: 6px;
            transition: all 0.2s ease;
        }

        .profile-dropdown-cyber a:hover {
            background: #fff1f2;
            color: var(--primary-rose);
        }

        .profile-dropdown-cyber a.logout-link {
            color: #e11d48;
            margin-bottom: 0;
            border-top: 1px solid rgba(244, 63, 94, 0.12);
            padding-top: 10px;
            margin-top: 6px;
        }

        .profile-dropdown-cyber a.logout-link:hover {
            background: #ffe4e6;
            color: #be123c;
        }

        /* ================= HERO SECTION 3D ================= */
        .hero-section {
            padding: 170px 24px 100px;
            max-width: 1240px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            gap: 50px;
            align-items: center;
        }

        .hero-3d-visual {
            position: relative;
            display: flex;
            justify-content: center;
        }

        .hero-card-3d {
            background: var(--glass-card-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1.5px solid var(--glass-border-color);
            border-radius: 36px;
            padding: 48px;
            text-align: center;
            box-shadow: 0 25px 60px rgba(244, 63, 94, 0.12), 0 4px 20px rgba(0, 0, 0, 0.03);
            position: relative;
            width: 100%;
            max-width: 440px;
            transform-style: preserve-3d;
        }

        .hero-card-3d::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(244, 63, 94, 0.4), transparent);
        }

        .hero-logo-box {
            width: 130px;
            height: 130px;
            margin: 0 auto 24px;
            background: linear-gradient(135deg, #fff1f2 0%, #ffffff 100%);
            border: 2px solid rgba(244, 63, 94, 0.35);
            border-radius: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 28px rgba(244, 63, 94, 0.18);
            animation: floatLogo 4s ease-in-out infinite;
        }

        .hero-logo-box img {
            width: 82px;
            height: 82px;
            object-fit: contain;
            filter: drop-shadow(0 6px 12px rgba(244, 63, 94, 0.25));
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .hero-content h1 {
            font-family: var(--font-heading);
            font-size: 46px;
            font-weight: 800;
            line-height: 1.15;
            color: #2d1b24 !important;
            letter-spacing: -1px;
            margin-bottom: 12px;
            opacity: 1 !important;
            visibility: visible !important;
            -webkit-text-fill-color: #2d1b24 !important;
        }

        .hero-content h1 span {
            color: #c2255c !important;
            -webkit-text-fill-color: #c2255c !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .hero-content h3 {
            font-size: 20px;
            font-weight: 700;
            color: #c2255c !important;
            margin-bottom: 16px;
            opacity: 1 !important;
            visibility: visible !important;
            -webkit-text-fill-color: #c2255c !important;
        }

        .hero-content p {
            font-size: 16px;
            line-height: 1.8;
            color: #5c4350 !important;
            margin-bottom: 32px;
            max-width: 560px;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .hero-cta-group {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        /* ================= SECTION TENTANG ================= */
        .section-tentang {
            padding: 90px 24px;
            max-width: 1240px;
            margin: 0 auto;
        }

        .tentang-card-glass {
            background: var(--glass-card-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1.5px solid var(--glass-border-color);
            border-radius: 34px;
            padding: 52px;
            box-shadow: 0 20px 50px rgba(244, 63, 94, 0.08);
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 50px;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .tentang-card-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(244, 63, 94, 0.4), transparent);
        }

        .tentang-text h2 {
            font-family: var(--font-heading);
            font-size: 34px;
            font-weight: 800;
            color: #2d1b24 !important;
            margin-bottom: 20px;
            opacity: 1 !important;
            visibility: visible !important;
            -webkit-text-fill-color: #2d1b24 !important;
        }

        .tentang-text p, .tentang-biografi {
            font-size: 15.5px;
            line-height: 1.85;
            color: #5c4350 !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .tentang-img-frame {
            border-radius: 28px;
            overflow: hidden;
            border: 2px solid rgba(244, 63, 94, 0.25);
            box-shadow: 0 12px 35px rgba(244, 63, 94, 0.15);
            height: 380px;
        }

        .tentang-img-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .tentang-img-frame:hover img {
            transform: scale(1.04);
        }

        /* ================= HERO GALLERY ================= */
        .section-gallery {
            padding: 90px 24px;
            max-width: 1240px;
            margin: 0 auto;
            position: relative;
        }

        .gallery-container {
            border-radius: 34px;
            overflow: hidden;
            border: 1.5px solid rgba(244, 63, 94, 0.18);
            position: relative;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 50px rgba(244, 63, 94, 0.08);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            padding: 24px;
        }

        .gallery-item {
            border-radius: 22px;
            overflow: hidden;
            height: 260px; /* Sesuai instruksi 240px - 280px */
            border: 1.5px solid rgba(244, 63, 94, 0.2);
            position: relative;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(244, 63, 94, 0.08);
            transition: all 0.35s ease;
            transform-style: preserve-3d;
        }

        .gallery-item img, .gallery-item video {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Tidak gepeng / terpotong aneh */
            transition: transform 0.5s ease;
            display: block;
        }

        .gallery-item:hover {
            transform: translateY(-6px);
            border-color: rgba(244, 63, 94, 0.4);
            box-shadow: 0 18px 40px rgba(244, 63, 94, 0.16);
        }

        .gallery-item:hover img, .gallery-item:hover video {
            transform: scale(1.06);
        }

        .gallery-overlay-box {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(20px);
            border: 1.5px solid rgba(244, 63, 94, 0.3);
            border-radius: 26px;
            padding: 24px 38px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(244, 63, 94, 0.16);
            max-width: 500px;
            width: calc(100% - 60px);
            z-index: 10;
        }

        .gallery-overlay-box h3 {
            font-family: var(--font-heading);
            font-size: 22px;
            font-weight: 800;
            color: #4c0519;
            margin-bottom: 12px;
        }

        /* ================= PILL BADGES ================= */
        .badge-cyber, .pill-badge {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            width: fit-content !important;
            max-width: fit-content !important;
            padding: 8px 20px !important;
            border-radius: 50px !important;
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(236, 72, 153, 0.25) !important;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.1) !important;
            font-weight: 600 !important;
            font-size: 0.85rem !important;
            color: #be123c !important;
            letter-spacing: 0.3px !important;
            margin-bottom: 14px;
        }

        .badge-cyber i, .pill-badge i {
            color: #f43f5e;
            font-size: 1rem;
        }

        /* ================= TESTIMONI (3-COLUMN GLASS GRID) ================= */
        .section-testimoni {
            padding: 90px 24px;
            max-width: 1240px;
            margin: 0 auto;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .section-header-center {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-header-center h2 {
            font-family: var(--font-heading);
            font-size: 36px;
            font-weight: 800;
            color: #2d1b24 !important;
            margin-bottom: 10px;
            opacity: 1 !important;
            visibility: visible !important;
            -webkit-text-fill-color: #2d1b24 !important;
        }

        .section-header-center p {
            color: #5c4350 !important;
            font-size: 15.5px;
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* Horizontal Testimoni Slider */
        .section-testimoni {
            position: relative;
            max-width: 1240px;
            margin: 0 auto;
            padding: 80px 24px;
        }

        .testimoni-slider-wrapper {
            position: relative;
            width: 100%;
            margin-top: 30px;
        }

        .testimoni-slider-track, .testimoni-grid-3col {
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            scroll-snap-type: x mandatory !important;
            gap: 24px !important;
            scroll-behavior: smooth !important;
            padding: 16px 8px 30px 8px !important;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
            -webkit-overflow-scrolling: touch !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .testimoni-slider-track::-webkit-scrollbar, .testimoni-grid-3col::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        .testimoni-slider-track .testi-card-cyber, .testimoni-grid-3col .testi-card-cyber {
            flex: 0 0 calc(33.333% - 16px) !important;
            min-width: 320px !important;
            scroll-snap-align: start !important;
            box-sizing: border-box !important;
            height: auto !important;
            display: flex !important;
            flex-direction: column !important;
            background: rgba(255, 255, 255, 0.88) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1.5px solid rgba(244, 63, 94, 0.18) !important;
            border-radius: 28px !important;
            padding: 32px 28px !important;
            box-shadow: 0 14px 35px rgba(244, 63, 94, 0.08) !important;
            transition: all 0.35s ease !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        @media(max-width: 992px) {
            .testimoni-slider-track .testi-card-cyber, .testimoni-grid-3col .testi-card-cyber {
                flex: 0 0 calc(50% - 12px) !important;
                min-width: 280px !important;
            }
        }

        @media(max-width: 640px) {
            .testimoni-slider-track .testi-card-cyber, .testimoni-grid-3col .testi-card-cyber {
                flex: 0 0 88% !important;
                min-width: 260px !important;
            }
        }

        .testi-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1.5px solid rgba(244, 63, 94, 0.28);
            color: #e11d48;
            box-shadow: 0 10px 25px rgba(244, 63, 94, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 20;
            font-size: 20px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            outline: none;
        }

        .testi-nav-btn:hover {
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 12px 32px rgba(244, 63, 94, 0.35);
            transform: translateY(-50%) scale(1.12);
        }

        .testi-nav-btn:active {
            transform: translateY(-50%) scale(0.95);
        }

        .testi-nav-btn.prev-btn {
            left: -26px;
        }

        .testi-nav-btn.next-btn {
            right: -26px;
        }

        @media(max-width: 820px) {
            .testi-nav-btn.prev-btn { left: 4px; }
            .testi-nav-btn.next-btn { right: 4px; }
        }

        .testi-card-cyber:hover {
            border-color: rgba(244, 63, 94, 0.38) !important;
            box-shadow: 0 20px 45px rgba(244, 63, 94, 0.16) !important;
            transform: translateY(-5px) !important;
        }

        .testi-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }

        .avatar-bunda {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-rose);
            box-shadow: 0 4px 12px rgba(244, 63, 94, 0.2);
        }

        .bunda-name {
            font-size: 16px;
            font-weight: 800;
            color: #4c0519;
            margin-bottom: 3px;
        }

        .stars-gold {
            color: #f59e0b;
            font-size: 14px;
            letter-spacing: 2px;
        }

        .testi-review {
            font-size: 14.5px;
            line-height: 1.7;
            color: #334155;
            font-style: italic;
            margin-bottom: 18px;
            flex-grow: 1;
        }

        .testi-proof-thumb {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid rgba(244, 63, 94, 0.25);
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .testi-proof-thumb:hover {
            transform: scale(1.08);
            border-color: var(--primary-rose);
        }

        /* Force gallery visibility */
        .section-gallery, .gallery-container, .gallery-grid, .gallery-item {
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* ================= FOOTER ================= */
        .footer-cyber {
            background: rgba(255, 255, 255, 0.9);
            border-top: 1.5px solid rgba(244, 63, 94, 0.15);
            padding: 70px 24px 30px;
            position: relative;
        }

        .footer-grid-cyber {
            max-width: 1240px;
            margin: 0 auto 50px;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 40px;
        }

        .footer-col h4 {
            font-family: var(--font-heading);
            font-size: 18px;
            font-weight: 800;
            color: #4c0519;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }

        .footer-contact-item {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #475569;
            font-size: 14.5px;
            margin-bottom: 16px;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .footer-contact-item:hover {
            color: #be123c;
            transform: translateX(4px);
        }

        .contact-icon-box {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(244, 63, 94, 0.10);
            border: 1px solid rgba(244, 63, 94, 0.24);
            color: #f43f5e;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(244, 63, 94, 0.08);
            transition: all 0.25s ease;
        }

        .footer-contact-item:hover .contact-icon-box {
            background: linear-gradient(135deg, #f43f5e 0%, #fb7185 100%);
            color: #ffffff;
            box-shadow: 0 6px 16px rgba(244, 63, 94, 0.35);
            transform: scale(1.08);
        }

        .footer-bottom {
            max-width: 1240px;
            margin: 0 auto;
            padding-top: 25px;
            border-top: 1px solid rgba(244, 63, 94, 0.12);
            text-align: center;
            font-size: 13.5px;
            color: #64748b;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .hero-section {
                grid-template-columns: 1fr;
                padding-top: 130px;
                text-align: center;
            }
            .hero-content p {
                margin: 0 auto 30px;
            }
            .hero-cta-group {
                justify-content: center;
            }
            .tentang-card-glass {
                grid-template-columns: 1fr;
            }
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .footer-grid-cyber {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .nav-links {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }
            .hero-content h1 {
                font-size: 34px;
            }
            .cyber-navbar {
                width: calc(100% - 30px);
                padding: 12px 18px;
            }
        }
    </style>
</head>
<body>

    <!-- Interactive 3D Background Canvas (Pink-Rose Floating Particles) -->
    <canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>
    <div class="cyber-glow-blob cyber-glow-1"></div>
    <div class="cyber-glow-blob cyber-glow-2"></div>

    <!-- FLOATING GLASS NAVBAR (MURNI UNTUK PASIEN) -->
    <nav class="cyber-navbar">
        <a href="<?= base_url('/') ?>" class="nav-brand">
            <img src="<?= base_url('assets/Logo.png') ?>" alt="Logo Bunanur">
            <h2>BUNANUR <span>CARE</span></h2>
        </a>

        <div class="nav-links">
            <a href="#">Beranda</a>
            <a href="#tentang">Tentang Bidan</a>
            <a href="#gallery">Layanan & Galeri</a>
            <a href="#testimoni">Kata Bunda</a>
        </div>

        <div class="nav-actions">
            <!-- Profile or Login Pasien Area -->
            <div class="profile-area">
                <?php if (!empty($pasien)) : ?>
                    <?php
                    $fotoProfil = (!empty($pasien['foto']) && $pasien['foto'] != 'default.png')
                        ? $pasien['foto']
                        : 'default-hero.png';
                    ?>
                    <img
                        src="<?= base_url('assets/profile/' . $fotoProfil) ?>"
                        class="avatar-user"
                        alt="Foto Profil"
                        onclick="toggleDropdown()"
                        onerror="this.src='<?= base_url('assets/profile/default-hero.png') ?>'">

                    <div class="profile-dropdown-cyber" id="dropdown">
                        <h4><?= esc($pasien['nama'] ?? 'Pasien') ?></h4>
                        <p><?= esc($pasien['email'] ?? '-') ?></p>

                        <a href="<?= base_url('dashboard_pasien') ?>">
                            <i class='bx bx-grid-alt'></i> Dashboard Pasien
                        </a>
                        <a href="<?= base_url('profil') ?>">
                            <i class='bx bx-user'></i> Profil Saya
                        </a>
                        <a href="<?= base_url('logout') ?>" class="logout-link" onclick="return confirmLogout()">
                            <i class='bx bx-log-out'></i> Keluar Akun
                        </a>
                    </div>
                <?php else : ?>
                    <a href="<?= base_url('login_pasien') ?>" class="btn-cyber-primary" style="padding: 10px 22px; font-size: 14px;">
                        <i class='bx bx-log-in'></i> Masuk Pasien
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- SECTION HERO 3D -->
    <section class="hero-section">
        <!-- Visual Kiri dengan 3D Card Tilt -->
        <div class="hero-3d-visual">
            <div class="hero-card-3d" data-tilt data-tilt-max="8" data-tilt-glare data-tilt-max-glare="0.10">
                <div class="hero-logo-box">
                    <img src="<?= base_url('assets/Logo.png') ?>" alt="Logo Hero">
                </div>
                <div class="badge-cyber badge-rose" style="margin-bottom: 14px;">
                    ✨ KLINIK PRATAMA KEBIDANAN
                </div>
                <h3 style="color: #2d1b24 !important; font-size: 22px; font-weight: 800; margin-bottom: 6px; opacity: 1 !important; visibility: visible !important; -webkit-text-fill-color: #2d1b24 !important;">BUNANUR CLINIC</h3>
                <p style="color: #5c4350 !important; font-size: 13.5px; margin-bottom: 0; opacity: 1 !important; visibility: visible !important;">Pendampingan Kesehatan Ibu & Tumbuh Kembang Buah Hati Terpercaya</p>
            </div>
        </div>

        <!-- Teks Kanan -->
        <div class="hero-content">
            <div class="badge-cyber badge-rose" style="margin-bottom: 18px;">
                🌸 Gentle Care For Mother & Baby
            </div>
            <h1 style="color: #2d1b24 !important; opacity: 1 !important; visibility: visible !important; -webkit-text-fill-color: #2d1b24 !important;">
                <?= !empty(trim($profil['hero_judul'] ?? '')) ? esc($profil['hero_judul']) : 'Perawatan Lembut untuk Ibu dan Anak' ?>
            </h1>
            <h3 style="color: #c2255c !important; opacity: 1 !important; visibility: visible !important; -webkit-text-fill-color: #c2255c !important;">
                <?= !empty(trim($profil['spesialis'] ?? '')) ? esc($profil['spesialis']) : 'Klinik Pratama & Perawatan Ibu & Anak' ?>
            </h3>
            <p style="color: #5c4350 !important; opacity: 1 !important; visibility: visible !important;">
                <?= !empty(trim($profil['hero_subjudul'] ?? '')) ? esc($profil['hero_subjudul']) : 'Layanan medis berstandar tinggi yang mendampingi setiap langkah Bunda, mulai dari masa kehamilan, persalinan lembut, hingga perawatan tumbuh kembang buah hati.' ?>
            </p>

            <div class="hero-cta-group">
                <?php if (!empty($pasien)): ?>
                    <a href="<?= base_url('dashboard_pasien') ?>" class="btn-cyber-primary">
                        <i class='bx bx-chat'></i> Masuk Dashboard Konsultasi
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('login_pasien') ?>" class="btn-cyber-primary">
                        <i class='bx bx-chat'></i> Mulai Konsultasi Sekarang
                    </a>
                <?php endif; ?>

                <a href="#tentang" class="btn-cyber-secondary">
                    <i class='bx bx-info-circle'></i> Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION TENTANG -->
    <section id="tentang" class="section-tentang">
        <div class="tentang-card-glass">
            <div class="tentang-text">
                <div class="badge-cyber badge-rose" style="margin-bottom: 16px;">
                    <i class='bx bx-heart'></i> Dedikasi Penuh Kasih
                </div>
                <h2 style="color: #2d1b24 !important; opacity: 1 !important; visibility: visible !important; -webkit-text-fill-color: #2d1b24 !important;">Tentang Bidan Bunanur</h2>
                <p class="tentang-biografi" style="color: #5c4350 !important; opacity: 1 !important; visibility: visible !important;">
                    <?= !empty(trim($profil['tentang'] ?? '')) ? nl2br(esc($profil['tentang'])) : 'Klinik Bunanur didirikan dengan visi menghadirkan perawatan kebidanan yang hangat, profesional, dan berbasis bukti untuk mendukung kesehatan ibu dan anak.' ?>
                </p>
            </div>
            <div class="tentang-img-frame" data-tilt data-tilt-max="6">
                <img
                    src="<?= base_url('assets/profile/' . ($profil['foto_tentang'] ?? 'default.png')) ?>"
                    alt="Bidan Bunanur"
                    onerror="this.src='<?= base_url('assets/profile/default.png') ?>'">
            </div>
        </div>
    </section>

    <!-- SECTION GALERI / LAYANAN -->
    <section id="gallery" class="section-gallery">
        <div class="section-header-center">
            <div class="badge-cyber badge-rose" style="margin-bottom: 12px;">
                <i class='bx bx-images'></i> Dokumentasi Pelayanan
            </div>
            <h2 style="color: #2d1b24 !important; opacity: 1 !important; visibility: visible !important; -webkit-text-fill-color: #2d1b24 !important;">Fasilitas & Tindakan Medis</h2>
            <p style="color: #5c4350 !important; opacity: 1 !important; visibility: visible !important;">Berbagai momen pelayanan prima kami untuk bunda dan buah hati tercinta</p>
        </div>

        <div class="gallery-container">
            <div class="gallery-grid">
                <!-- Video Slides -->
                <?php if (!empty($galeriVideo)): ?>
                    <?php foreach(array_slice($galeriVideo, 0, 3) as $g): ?>
                        <div class="gallery-item glass-card-3d" data-tilt data-tilt-max="6">
                            <video autoplay muted loop playsinline>
                                <source src="<?= base_url('assets/slider/'.$g['file_name']) ?>" type="video/mp4">
                            </video>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Foto Slides -->
                <?php if (!empty($galeriFoto)): ?>
                    <?php foreach(array_slice($galeriFoto, 0, 3) as $g): ?>
                        <div class="gallery-item glass-card-3d" data-tilt data-tilt-max="6">
                            <img src="<?= base_url('assets/slider/'.$g['file_name']) ?>" alt="Gallery Klinik Bunanur">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Floating Hero Overlay Card (3D Tilt) -->
            <div class="gallery-overlay-box glass-card-3d" data-tilt data-tilt-max="5">
                <h3 style="color: #2d1b24 !important; opacity: 1 !important; visibility: visible !important; -webkit-text-fill-color: #2d1b24 !important;">Teman Setia Ibu Dan Buah Hati</h3>
                <a href="<?= base_url('daftar-layanan') ?>" class="btn-cyber-primary" style="padding: 10px 24px; font-size: 14px;">
                    <i class='bx bx-grid'></i> Jelajahi Seluruh Layanan Medis
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION TESTIMONI -->
    <section id="testimoni" class="section-testimoni">
        <div class="section-header-center">
            <div class="badge-cyber badge-rose" style="margin-bottom: 12px;">
                <i class='bx bxs-star'></i> Cerita Nyata Pasien
            </div>
            <h2 style="color: #2d1b24 !important; opacity: 1 !important; visibility: visible !important; -webkit-text-fill-color: #2d1b24 !important;">Kata Bunda Tercinta</h2>
            <p style="color: #5c4350 !important; opacity: 1 !important; visibility: visible !important;">Pengalaman nyata keluarga yang mempercayakan perawatannya di Klinik Bunanur</p>
        </div>

        <div class="testimoni-slider-wrapper">
            <button type="button" class="testi-nav-btn prev-btn" id="btnTestiPrev" aria-label="Sebelumnya">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <div class="testimoni-slider-track" id="testimoniTrack">
                <?php if (!empty($testimoni)): ?>
                    <?php foreach ($testimoni as $row): ?>
                        <?php
                        $foto_bunda = !empty($row['foto_profil'])
                            ? $row['foto_profil']
                            : 'default-hero.png';

                        $isi_ulasan = !empty($row['ulasan'])
                            ? $row['ulasan']
                            : 'Pelayanan sangat ramah, nyaman, dan memuaskan.';

                        $rating_pasien = !empty($row['rating'])
                            ? (int)$row['rating']
                            : 5;

                        $foto_bukti = !empty($row['foto'])
                            ? $row['foto']
                            : '';

                        $nama_display = !empty($row['nama'])
                            ? $row['nama']
                            : 'Bunda Pasien';
                        ?>

                        <div class="testi-card-cyber" data-tilt data-tilt-max="6">
                            <div class="testi-header">
                                <img
                                    src="<?= base_url('assets/profile/' . $foto_bunda) ?>"
                                    class="avatar-bunda"
                                    alt="<?= esc($nama_display) ?>"
                                    onerror="this.src='<?= base_url('assets/profile/default.png') ?>'">
                                <div>
                                    <h4 class="bunda-name"><?= esc($nama_display) ?></h4>
                                    <div class="stars-gold">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?= ($i <= $rating_pasien) ? '★' : '☆' ?>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>

                            <p class="testi-review">
                                "<?= esc($isi_ulasan, 'html') ?>"
                            </p>

                            <?php if (!empty($foto_bukti)): ?>
                                <div style="margin-top: auto;">
                                    <img
                                        src="<?= base_url('assets/testimoni/' . $foto_bukti) ?>"
                                        class="testi-proof-thumb"
                                        alt="Foto Bukti Testimoni"
                                        title="Klik untuk melihat foto"
                                        onclick="window.open(this.src)"
                                        onerror="this.style.display='none'">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <button type="button" class="testi-nav-btn next-btn" id="btnTestiNext" aria-label="Selanjutnya">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer-cyber">
        <div class="footer-grid-cyber">
            <!-- Brand & Info -->
            <div class="footer-col">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 18px;">
                    <img src="<?= base_url('assets/Logo.png') ?>" alt="Logo Bunanur" style="width: 44px; height: 44px; border-radius: 12px; background: #ffffff; padding: 5px; border: 1px solid rgba(244,63,94,0.3); box-shadow: 0 4px 10px rgba(244,63,94,0.15);">
                    <h3 style="font-family: var(--font-heading); font-size: 22px; font-weight: 800; color: #2d1b24 !important;">BUNANUR CARE</h3>
                </div>
                <p style="color: #5c4350 !important; font-size: 14.5px; line-height: 1.75; max-width: 360px;">
                    Klinik Pratama Kebidanan yang didedikasikan untuk kesehatan ibu dan tumbuh kembang optimal anak dengan pelayanan penuh kasih dan profesional.
                </p>
            </div>

            <!-- Kontak -->
            <div class="footer-col">
                <h4>Hubungi Kami</h4>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', !empty($profil['whatsapp']) ? $profil['whatsapp'] : '081234567890') ?>" class="footer-contact-item" target="_blank">
                    <div class="contact-icon-box"><i class="fa-brands fa-whatsapp"></i></div>
                    <span><?= esc(!empty($profil['whatsapp']) ? $profil['whatsapp'] : '0812-3456-7890') ?></span>
                </a>

                <a href="mailto:<?= esc(!empty($profil['email']) ? $profil['email'] : 'bunanurclinic@gmail.com') ?>" class="footer-contact-item">
                    <div class="contact-icon-box"><i class="fa-solid fa-envelope"></i></div>
                    <span><?= esc(!empty($profil['email']) ? $profil['email'] : 'bunanurclinic@gmail.com') ?></span>
                </a>

                <div class="footer-contact-item">
                    <div class="contact-icon-box"><i class="fa-solid fa-location-dot"></i></div>
                    <span><?= nl2br(esc(!empty($profil['alamat']) ? $profil['alamat'] : 'Klinik Pratama Kebidanan Bunanur, Jawa Barat')) ?></span>
                </div>
            </div>

            <!-- Media Sosial -->
            <div class="footer-col">
                <h4>Media Sosial</h4>
                <a href="https://instagram.com/bunanurclinic.id" class="footer-contact-item" target="_blank">
                    <div class="contact-icon-box"><i class="fa-brands fa-instagram"></i></div>
                    <span>bunanurclinic.id</span>
                </a>

                <a href="https://facebook.com/bunanurclinic" class="footer-contact-item" target="_blank">
                    <div class="contact-icon-box"><i class="fa-brands fa-facebook"></i></div>
                    <span>bunanurclinic</span>
                </a>

                <a href="https://www.tiktok.com/@bidanhellokity" class="footer-contact-item" target="_blank">
                    <div class="contact-icon-box"><i class="fa-brands fa-tiktok"></i></div>
                    <span>bidanhellokity</span>
                </a>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; <?= date('Y') ?> BUNANUR Mother Care Clinic &bull; Pelayanan Ramah, Aman & Terpercaya.
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            if (dropdown) {
                dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
            }
        }

        window.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-area')) {
                const d = document.getElementById('dropdown');
                if (d) d.style.display = 'none';
            }
        });

        function confirmLogout() {
            return confirm("Apakah Anda yakin ingin keluar dari akun ini?");
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Horizontal Testimoni Slider Navigation
            const testiTrack = document.getElementById('testimoniTrack');
            const btnPrev = document.getElementById('btnTestiPrev');
            const btnNext = document.getElementById('btnTestiNext');
            if (testiTrack && btnPrev && btnNext) {
                btnPrev.addEventListener('click', function() {
                    const card = testiTrack.querySelector('.testi-card-cyber');
                    const scrollStep = card ? card.offsetWidth + 24 : 350;
                    testiTrack.scrollBy({ left: -scrollStep, behavior: 'smooth' });
                });
                btnNext.addEventListener('click', function() {
                    const card = testiTrack.querySelector('.testi-card-cyber');
                    const scrollStep = card ? card.offsetWidth + 24 : 350;
                    testiTrack.scrollBy({ left: scrollStep, behavior: 'smooth' });
                });
            }

            // Testimoni Swiper
            const swiper = new Swiper(".testimoni-swiper", {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                autoplay: {
                    delay: 4500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                breakpoints: {
                    768: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 }
                }
            });
        });
    </script>
</body>
</html>
