<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi Bidan | Portal Medis Bunanur</title>

    <!-- Google Fonts & Boxicons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Master Medical Glassmorphism 3D CSS -->
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
            font-size: 26px;
            font-weight: 800;
            color: var(--text-heading);
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .auth-header p {
            color: var(--text-muted);
            font-size: 13.5px;
            line-height: 1.5;
        }

        .input-group-cyber {
            position: relative;
            margin-bottom: 18px;
        }

        .cyber-input {
            width: 100%;
            padding: 14px 18px 14px 46px;
            border-radius: 16px;
            border: 1.5px solid rgba(244, 63, 94, 0.22);
            background: rgba(255, 255, 255, 0.95);
            font-size: 14.5px;
            color: var(--text-main);
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .cyber-input:focus {
            border-color: var(--primary-rose);
            box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.15);
            background: #ffffff;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: var(--primary-rose);
            opacity: 0.85;
        }

        /* CAPTCHA challenge box */
        .cyber-captcha-widget {
            border: 1.5px solid rgba(244, 63, 94, 0.22);
            background: #fffafa;
            border-radius: 18px;
            padding: 14px 18px;
            margin-bottom: 22px;
            transition: all 0.3s ease;
        }

        .captcha-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .captcha-trigger-box {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            user-select: none;
        }

        .captcha-checkbox-custom {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            border: 2px solid rgba(244, 63, 94, 0.4);
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
        }

        .captcha-checkbox-custom.verified {
            background: var(--primary-rose);
            border-color: var(--primary-rose);
            color: #ffffff;
        }

        .captcha-checkbox-custom.spinner {
            border-top-color: var(--primary-rose);
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .captcha-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-heading);
        }

        .captcha-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 10px;
            color: var(--text-dim);
            font-weight: 700;
        }

        .captcha-pop-challenge {
            display: none;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px dashed rgba(244, 63, 94, 0.25);
            animation: fadeIn 0.3s ease;
        }

        .captcha-math-display {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 6px;
        }

        .captcha-math-equation {
            font-family: var(--font-heading);
            font-size: 20px;
            font-weight: 800;
            color: var(--rose-dark);
            background: #ffe4e6;
            padding: 8px 16px;
            border-radius: 12px;
            letter-spacing: 1px;
        }

        .alert-cyber-error {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #be123c;
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-cyber-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-cyber-primary {
            width: 100%;
            padding: 15px;
            border-radius: 16px;
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            color: #ffffff;
            border: none;
            font-size: 15.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(244, 63, 94, 0.35);
            transition: all 0.3s ease;
        }

        .btn-cyber-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(244, 63, 94, 0.45);
        }

        .auth-footer-links {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .auth-footer-links a {
            color: var(--primary-rose);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-footer-links a:hover {
            text-decoration: underline;
        }

        .home-back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 14px;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

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
                    <i class='bx bxs-key'></i> PEMULIHAN KATA SANDI BIDAN
                </div>
                <h1>Lupa Kata Sandi</h1>
                <p>Masukkan ID Pengguna dan Nomor WhatsApp terdaftar untuk menerima kode verifikasi OTP 6-digit.</p>
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

            <form action="<?= base_url('bidan/lupa-sandi') ?>" method="POST" id="lupaSandiForm">
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
                        type="tel"
                        name="whatsapp"
                        class="cyber-input"
                        value="<?= esc(old('whatsapp') ?? '') ?>"
                        placeholder="Nomor WhatsApp (contoh: 081224841377)"
                        required
                    >
                    <i class='bx bxl-whatsapp input-icon' style="font-size: 22px; color: #16a34a;"></i>
                </div>

                <!-- CyberShield Math CAPTCHA Widget -->
                <div class="cyber-captcha-widget" id="captchaBox">
                    <div class="captcha-row">
                        <div class="captcha-trigger-box" onclick="toggleCaptchaChallenge()">
                            <div class="captcha-checkbox-custom" id="captchaCheckbox">
                                <i class='bx bx-check' id="captchaCheckIcon" style="display: none; font-size: 18px;"></i>
                            </div>
                            <span class="captcha-label" id="captchaStatusText">Saya bukan robot</span>
                        </div>
                        <div class="captcha-brand">
                            <i class='bx bxs-shield-plus'></i>
                            <span>CyberShield CI4</span>
                            <span style="font-size: 9px; opacity: 0.7;">Bidan Verification</span>
                        </div>
                    </div>

                    <!-- Math Challenge Drawer -->
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

                <button type="submit" class="btn-cyber-primary">
                    <i class='bx bx-send' style="font-size: 20px;"></i>
                    Kirim Kode OTP WhatsApp
                </button>
            </form>

            <div class="auth-footer-links">
                <div>
                    Sudah ingat kata sandi Anda? 
                    <a href="<?= base_url('login_bidan') ?>">Masuk ke Portal Bidan</a>
                </div>
                <a href="<?= base_url('/') ?>" class="home-back-link">
                    <i class='bx bx-arrow-back'></i> Kembali ke Beranda Klinik
                </a>
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

            checkbox.classList.add('spinner');
            statusText.innerText = 'Memverifikasi keamanan...';

            setTimeout(() => {
                checkbox.classList.remove('spinner');
                drawer.style.display = 'block';
                statusText.innerText = 'Selesaikan tantangan di bawah';
                inputField.focus();
            }, 450);
        }

        function onCaptchaAnswerInput(val) {
            const checkbox = document.getElementById('captchaCheckbox');
            const checkIcon = document.getElementById('captchaCheckIcon');
            const statusText = document.getElementById('captchaStatusText');
            const captchaBox = document.getElementById('captchaBox');

            if (val.trim().length > 0) {
                checkbox.classList.add('verified');
                checkIcon.style.display = 'block';
                statusText.innerText = 'Verifikasi CAPTCHA Siap';
                captchaBox.style.borderColor = '#10b981';
                isCaptchaVerified = true;
            } else {
                checkbox.classList.remove('verified');
                checkIcon.style.display = 'none';
                statusText.innerText = 'Selesaikan tantangan di bawah';
                captchaBox.style.borderColor = 'rgba(244, 63, 94, 0.22)';
                isCaptchaVerified = false;
            }
        }
    </script>
</body>
</html>
