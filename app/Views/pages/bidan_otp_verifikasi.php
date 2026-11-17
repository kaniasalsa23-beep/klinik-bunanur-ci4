<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP WhatsApp | Portal Medis Bunanur</title>

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
            max-width: 500px;
            padding: 44px 38px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1.5px solid rgba(244, 63, 94, 0.20);
            box-shadow: 0 20px 50px rgba(244, 63, 94, 0.10), 0 4px 20px rgba(0, 0, 0, 0.04);
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-logo-badge {
            width: 80px;
            height: 80px;
            margin: 0 auto 14px;
            background: linear-gradient(135deg, #fff1f2 0%, #ffffff 100%);
            border: 2px solid rgba(244, 63, 94, 0.32);
            border-radius: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(244, 63, 94, 0.16);
        }

        .auth-logo-badge img {
            width: 48px;
            height: 48px;
            object-fit: contain;
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

        .masked-phone-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            padding: 6px 14px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            margin-top: 8px;
        }

        /* Timer Badge */
        .timer-badge-container {
            text-align: center;
            margin: 18px 0;
        }

        .timer-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 20px;
            background: #fff1f2;
            border: 1px solid rgba(244, 63, 94, 0.35);
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 800;
            color: var(--rose-dark);
            letter-spacing: 0.5px;
        }

        .timer-badge.urgent {
            background: #fef2f2;
            border-color: #ef4444;
            color: #dc2626;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.03); }
        }

        /* OTP Input */
        .otp-input-container {
            margin: 20px 0;
            text-align: center;
        }

        .cyber-otp-input {
            width: 100%;
            max-width: 280px;
            padding: 14px 10px;
            border-radius: 18px;
            border: 2px solid rgba(244, 63, 94, 0.3);
            background: #ffffff;
            font-family: var(--font-heading);
            font-size: 28px;
            font-weight: 800;
            text-align: center;
            letter-spacing: 12px;
            color: var(--rose-dark);
            outline: none;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .cyber-otp-input:focus {
            border-color: var(--primary-rose);
            box-shadow: 0 0 0 5px rgba(244, 63, 94, 0.18);
        }


        .alert-cyber-error {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #be123c;
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 13.5px;
            margin-bottom: 18px;
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
            margin-bottom: 18px;
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
            margin-top: 22px;
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
    </style>
</head>
<body>

    <canvas id="cyberCanvas3D"></canvas>
    <div class="cyber-glow-blob cyber-glow-1"></div>
    <div class="cyber-glow-blob cyber-glow-2"></div>

    <div class="auth-wrapper">
        <div class="auth-card glass-card-3d" data-tilt data-tilt-max="6">
            
            <div class="auth-header">
                <div class="auth-logo-badge">
                    <img src="<?= base_url('assets/Logo.png') ?>" alt="Logo Klinik Bunanur" onerror="this.src='<?= base_url('assets/profile/default-hero.png') ?>'">
                </div>
                <div class="clinical-badge">
                    <i class='bx bxl-whatsapp'></i> VERIFIKASI WHATSAPP OTP
                </div>
                <h1>Verifikasi OTP Bidan</h1>
                <p>Masukkan 6-digit kode OTP yang telah dikirimkan ke nomor WhatsApp terdaftar:</p>
                <div>
                    <span class="masked-phone-badge">
                        <i class='bx bxl-whatsapp'></i> <?= esc($masked_phone ?? '+62 812-****-1377') ?>
                    </span>
                </div>
            </div>

            <!-- Countdown Timer Display -->
            <div class="timer-badge-container">
                <div class="timer-badge" id="timerBadge">
                    <i class='bx bx-time-five'></i>
                    Sisa Waktu: <span id="timerCountdown">05:00</span>
                </div>
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



            <form action="<?= base_url('bidan/otp-verifikasi') ?>" method="POST" id="otpForm">
                <?= csrf_field() ?>

                <div class="otp-input-container">
                    <input
                        type="text"
                        name="otp"
                        id="otpInput"
                        class="cyber-otp-input"
                        placeholder="••••••"
                        maxlength="6"
                        pattern="\d{6}"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        required
                        autofocus
                    >
                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 8px;">
                        *Masukkan 6 angka tanpa spasi. Maksimal 5 kali percobaan.
                    </div>
                </div>

                <button type="submit" class="btn-cyber-primary" id="btnSubmitOtp">
                    <i class='bx bx-check-shield' style="font-size: 20px;"></i>
                    Verifikasi Kode OTP
                </button>
            </form>

            <div class="auth-footer-links">
                <div>
                    Tidak menerima kode? 
                    <a href="<?= base_url('bidan/kirim-ulang-otp') ?>" id="btnResendOtp">
                        Kirim Ulang OTP <span id="resendTimerSpan" style="display:none; font-weight: 500; color: var(--text-muted);">(<span id="resendCountdown">60</span>s)</span>
                    </a>
                </div>
                <div style="margin-top: 10px;">
                    <a href="<?= base_url('login_bidan') ?>" style="color: var(--text-muted);">
                        <i class='bx bx-arrow-back'></i> Kembali ke Login Bidan
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>

    <script>
        // 5-Minute (or remaining) Interactive Countdown Timer
        let secondsRemaining = <?= (int)($remaining_seconds ?? 300) ?>;
        let resendCooldown   = <?= (int)($cooldown_remaining ?? 60) ?>;
        const timerElem      = document.getElementById('timerCountdown');
        const timerBadge     = document.getElementById('timerBadge');
        const otpInput       = document.getElementById('otpInput');
        const btnSubmit      = document.getElementById('btnSubmitOtp');
        const btnResend      = document.getElementById('btnResendOtp');
        const resendSpan     = document.getElementById('resendTimerSpan');
        const resendCount    = document.getElementById('resendCountdown');

        function updateCountdown() {
            if (secondsRemaining <= 0) {
                timerElem.innerText = '00:00 (Kedaluwarsa)';
                timerBadge.classList.add('urgent');
                otpInput.disabled = true;
                btnSubmit.disabled = true;
                btnSubmit.style.opacity = '0.5';
                btnSubmit.innerText = 'OTP Kedaluwarsa — Silakan Ajukan Ulang';
                return;
            }

            const m = Math.floor(secondsRemaining / 60);
            const s = secondsRemaining % 60;
            timerElem.innerText = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');

            if (secondsRemaining <= 60) {
                timerBadge.classList.add('urgent');
            }

            secondsRemaining--;
            setTimeout(updateCountdown, 1000);
        }

        function updateResendCooldown() {
            if (resendCooldown > 0) {
                btnResend.style.pointerEvents = 'none';
                btnResend.style.opacity = '0.6';
                resendSpan.style.display = 'inline';
                resendCount.innerText = resendCooldown;
                resendCooldown--;
                setTimeout(updateResendCooldown, 1000);
            } else {
                btnResend.style.pointerEvents = 'auto';
                btnResend.style.opacity = '1';
                resendSpan.style.display = 'none';
            }
        }

        updateCountdown();
        updateResendCooldown();

        // Auto submit when 6 digits are typed
        otpInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length === 6) {
                // Focus styling
                this.blur();
            }
        });
    </script>
</body>
</html>
