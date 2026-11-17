<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Bidan | Portal Medis Bunanur</title>

    <!-- Google Fonts & Boxicons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Master Medical Glassmorphism 3D CSS (Light Mode) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">

    <style>
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            position: relative;
            z-index: 10;
        }

        .auth-card {
            width: 100%;
            max-width: 490px;
            padding: 44px 38px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1.5px solid rgba(244, 63, 94, 0.20);
            box-shadow: 0 20px 50px rgba(244, 63, 94, 0.10), 0 4px 20px rgba(0, 0, 0, 0.04);
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 26px;
        }

        .auth-logo-badge {
            width: 84px;
            height: 84px;
            margin: 0 auto 14px;
            background: linear-gradient(135deg, #fff1f2 0%, #ffffff 100%);
            border: 2px solid rgba(244, 63, 94, 0.32);
            border-radius: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(244, 63, 94, 0.16);
            transition: all 0.4s ease;
        }

        .auth-logo-badge:hover {
            transform: scale(1.06) rotate(-3deg);
            border-color: var(--primary-rose);
            box-shadow: 0 12px 28px rgba(244, 63, 94, 0.25);
        }

        .auth-logo-badge img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            filter: drop-shadow(0 4px 8px rgba(244, 63, 94, 0.2));
        }

        .clinical-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 800;
            background: #fff1f2;
            border: 1px solid rgba(244, 63, 94, 0.3);
            color: var(--primary-rose);
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .auth-header h1 {
            font-family: var(--font-heading);
            font-size: 28px;
            font-weight: 800;
            color: var(--text-heading);
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .auth-header p {
            color: var(--text-muted);
            font-size: 13.5px;
        }

        .input-group-cyber {
            position: relative;
            margin-bottom: 18px;
        }

        .input-group-cyber i.input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: var(--text-dim);
            transition: color 0.3s ease;
            pointer-events: none;
        }

        .input-group-cyber .cyber-input {
            padding-left: 50px;
        }

        .input-group-cyber .cyber-input:focus ~ i.input-icon {
            color: var(--primary-rose);
        }

        .alert-cyber-error {
            background: #fff1f2;
            border: 1px solid rgba(244, 63, 94, 0.35);
            color: #be123c;
            padding: 13px 16px;
            border-radius: 14px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 14px rgba(244, 63, 94, 0.08);
        }

        .alert-cyber-success {
            background: #ecfdf5;
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: #065f46;
            padding: 13px 16px;
            border-radius: 14px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.08);
        }

        .auth-footer-links {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(244, 63, 94, 0.12);
            text-align: center;
            font-size: 13.5px;
            color: var(--text-muted);
        }

        .auth-footer-links a {
            color: var(--primary-rose);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .auth-footer-links a:hover {
            color: var(--rose-dark);
            text-decoration: underline;
        }

        .home-back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 14px;
            color: var(--text-muted);
            font-size: 13px;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.25s ease;
        }

        .home-back-link:hover {
            color: var(--primary-rose);
        }
    </style>
</head>
<body>

    <!-- Interactive 3D Background Canvas (Pink-Rose Floating Nodes) -->
    <canvas id="cyberCanvas3D"></canvas>
    <div class="cyber-glow-blob cyber-glow-1"></div>
    <div class="cyber-glow-blob cyber-glow-2"></div>

    <div class="auth-wrapper">
        <div class="auth-card glass-card-3d" data-tilt data-tilt-max="6" data-tilt-glare data-tilt-max-glare="0.08">
            
            <div class="auth-header">
                <div class="auth-logo-badge">
                    <img src="<?= base_url('assets/Logo.png') ?>" alt="Logo Klinik Bunanur" onerror="this.src='<?= base_url('assets/profile/default-hero.png') ?>'">
                </div>
                <div class="clinical-badge">
                    <i class='bx bx-plus-medical'></i> AKSES KREDENSIAL MEDIS INTERNAL
                </div>
                <h1>Portal Bidan</h1>
                <p>Dashboard Manajemen Pelayanan Kesehatan Bidan Terakreditasi</p>
            </div>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert-cyber-error">
                    <i class='bx bx-error-circle' style="font-size: 20px;"></i>
                    <div><?= esc(session()->getFlashdata('error')) ?></div>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert-cyber-success">
                    <i class='bx bx-check-circle' style="font-size: 20px;"></i>
                    <div><?= esc(session()->getFlashdata('success')) ?></div>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login_bidan') ?>" method="POST" id="loginBidanForm">
                <?= csrf_field() ?>

                <div class="input-group-cyber">
                    <input
                        type="text"
                        name="username"
                        class="cyber-input"
                        value="<?= esc(old('username') ?? '') ?>"
                        placeholder="ID Pengguna / Username Bidan"
                        required
                        autocomplete="username"
                    >
                    <i class='bx bx-id-card input-icon'></i>
                </div>

                <div class="input-group-cyber">
                    <input
                        type="password"
                        name="password"
                        class="cyber-input"
                        placeholder="Kata Sandi / Password"
                        required
                        autocomplete="current-password"
                    >
                    <i class='bx bx-lock-alt input-icon'></i>
                </div>

                <!-- Modern Turnstile / reCAPTCHA v2 Style Verification Widget -->
                <div class="cyber-captcha-box" id="captchaBox">
                    <div class="captcha-header-row">
                        <div class="captcha-checkbox-wrapper" id="captchaTrigger" onclick="toggleCaptchaChallenge()">
                            <div class="captcha-custom-checkbox" id="captchaCheckbox">
                                <i class='bx bx-check' id="captchaCheckIcon" style="display: none; color: #fff; font-size: 20px; font-weight: bold;"></i>
                            </div>
                            <span class="captcha-label" id="captchaStatusText">Saya bukan robot</span>
                        </div>
                        <div class="captcha-brand">
                            <i class='bx bxs-shield-plus'></i>
                            <span>CyberShield CI4</span>
                            <span style="font-size: 9px; opacity: 0.7;">Bidan Verification</span>
                        </div>
                    </div>

                    <!-- Slide-Down Math Challenge Popup -->
                    <div class="captcha-pop-challenge" id="captchaChallengeDrawer">
                        <div style="font-size: 12.5px; color: var(--text-muted); margin-bottom: 8px;">
                            Selesaikan verifikasi angka berikut:
                        </div>
                        <div class="captcha-math-display">
                            <span class="captcha-math-equation">
                                <?= esc($captcha['soal'] ?? '3 + 5 = ?') ?>
                            </span>
                            <input
                                type="number"
                                name="captcha"
                                id="captchaInputField"
                                class="cyber-input"
                                placeholder="Jawaban?"
                                required
                                style="max-width: 130px; padding: 10px 14px; text-align: center; font-weight: 700; font-size: 16px;"
                                oninput="onCaptchaAnswerInput(this.value)"
                            >
                        </div>
                        <div style="font-size: 11.5px; color: var(--rose-dark); opacity: 0.9;">
                            *Ketik jawaban angka untuk mengonfirmasi Anda adalah manusia.
                        </div>
                    </div>
                </div>

                <!-- Remember Me Toggle (iOS / Modern Rose Glass Switch) -->
                <label class="cyber-switch-container">
                    <span class="switch-label-text">
                        <i class='bx bx-lock-open-alt' style="color: var(--primary-rose); margin-right: 4px;"></i>
                        Ingat sesi bidan (30 hari terenkripsi)
                    </span>
                    <input type="checkbox" name="remember_me" value="1" style="display: none;">
                    <div class="cyber-switch"></div>
                </label>

                <!-- Glowing CTA Submit Button -->
                <button type="submit" class="btn-cyber-primary" style="width: 100%; padding: 15px; font-size: 16px;">
                    <i class='bx bx-shield-quarter' style="font-size: 20px;"></i>
                    Masuk Dashboard Medis
                </button>
            </form>

            <div class="auth-footer-links">

                <a href="<?= base_url('/') ?>" class="home-back-link">
                    <i class='bx bx-arrow-back'></i> Kembali ke Beranda Klinik
                </a>
                <div style="margin-top: 14px; font-size: 11.5px; color: var(--text-dim);">
                    Sistem Keamanan Siber Aktif &bull; Enkripsi Kredensial OWASP
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>

    <script>
        let isCaptchaVerified = false;

        function toggleCaptchaChallenge() {
            const drawer = document.getElementById('captchaChallengeDrawer');
            const checkbox = document.getElementById('captchaCheckbox');
            const statusText = document.getElementById('captchaStatusText');
            const inputField = document.getElementById('captchaInputField');

            if (isCaptchaVerified) return;

            // Trigger simulated Turnstile security check spinner
            checkbox.classList.add('spinner');
            statusText.innerText = 'Memverifikasi kredensial...';

            setTimeout(() => {
                checkbox.classList.remove('spinner');
                drawer.style.display = 'block';
                statusText.innerText = 'Selesaikan tantangan di bawah';
                inputField.focus();
            }, 550);
        }

        function onCaptchaAnswerInput(val) {
            const checkbox = document.getElementById('captchaCheckbox');
            const checkIcon = document.getElementById('captchaCheckIcon');
            const statusText = document.getElementById('captchaStatusText');
            const captchaBox = document.getElementById('captchaBox');

            if (val.trim() !== '') {
                isCaptchaVerified = true;
                checkbox.classList.add('checked');
                checkIcon.style.display = 'inline-block';
                statusText.innerText = 'Saya bukan robot (Terverifikasi)';
                statusText.style.color = '#047857';
                captchaBox.classList.add('verified');
            } else {
                isCaptchaVerified = false;
                checkbox.classList.remove('checked');
                checkIcon.style.display = 'none';
                statusText.innerText = 'Selesaikan tantangan di bawah';
                statusText.style.color = 'inherit';
                captchaBox.classList.remove('verified');
            }
        }

        // Auto-open challenge if user had previous attempt (e.g., error from backend)
        <?php if(session()->getFlashdata('error')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const drawer = document.getElementById('captchaChallengeDrawer');
            if (drawer) drawer.style.display = 'block';
        });
        <?php endif; ?>
    </script>
</body>
</html>
