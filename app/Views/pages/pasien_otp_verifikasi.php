<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP Pasien | Klinik Bunanur</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">
    <style>
        .auth-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 30px 20px; position: relative; z-index: 10; }
        .auth-card { width: 100%; max-width: 500px; padding: 44px 38px; border-radius: 30px; background: rgba(255,255,255,0.88); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); border: 1.5px solid rgba(244,63,94,0.20); box-shadow: 0 20px 50px rgba(244,63,94,0.10), 0 4px 20px rgba(0,0,0,0.04); }
        .auth-header { text-align: center; margin-bottom: 24px; }
        .auth-logo-badge { width: 80px; height: 80px; margin: 0 auto 12px; background: linear-gradient(135deg,#fff1f2,#ffffff); border: 2px solid rgba(244,63,94,0.32); border-radius: 24px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 24px rgba(244,63,94,0.16); }
        .auth-logo-badge i { font-size: 38px; color: #f43f5e; }
        .clinical-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 14px; border-radius: 20px; font-size: 11.5px; font-weight: 800; background: #fff1f2; border: 1px solid rgba(244,63,94,0.3); color: #f43f5e; letter-spacing: 0.5px; margin-bottom: 10px; }
        .auth-header h1 { font-size: 24px; font-weight: 800; color: #1e293b; letter-spacing: -0.5px; margin-bottom: 6px; }
        .auth-header p { color: #64748b; font-size: 13px; }
        .otp-input-row { display: flex; gap: 8px; justify-content: center; margin: 20px 0; flex-wrap: wrap; }
        .otp-box { width: 52px; height: 60px; border: 2px solid rgba(244,63,94,0.3); border-radius: 14px; text-align: center; font-size: 24px; font-weight: 800; color: #1e293b; background: rgba(255,255,255,0.9); transition: border-color 0.3s, box-shadow 0.3s; }
        .otp-box:focus { border-color: #f43f5e; box-shadow: 0 0 0 4px rgba(244,63,94,0.12); outline: none; }
        .sandbox-otp-banner { background: linear-gradient(135deg,rgba(251,191,36,0.15) 0%,rgba(249,115,22,0.10) 100%); border: 1.5px solid rgba(251,191,36,0.5); border-radius: 18px; padding: 18px 20px; margin-bottom: 20px; }
        .sandbox-otp-banner .banner-title { font-size: 12px; font-weight: 800; color: #92400e; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; gap: 7px; }
        .sandbox-otp-code { font-size: 42px; font-weight: 900; color: #f43f5e; text-align: center; letter-spacing: 10px; padding: 10px; background: rgba(255,255,255,0.7); border-radius: 12px; margin: 8px 0; font-family: 'Outfit', monospace; }
        .sandbox-otp-warning { font-size: 11px; color: #92400e; opacity: 0.85; margin-top: 6px; text-align: center; }
        .timer-bar-wrap { background: rgba(241,245,249,0.9); border-radius: 50px; height: 8px; overflow: hidden; margin: 10px 0 18px; }
        .timer-bar { height: 100%; background: linear-gradient(90deg,#f43f5e,#fb923c); border-radius: 50px; transition: width 1s linear; width: 100%; }
        .timer-text { text-align: center; font-size: 12.5px; color: #64748b; margin-bottom: 8px; }
        .alert-cyber-error { background: #fff1f2; border: 1px solid rgba(244,63,94,0.35); color: #be123c; padding: 13px 16px; border-radius: 14px; font-size: 13.5px; margin-bottom: 18px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-cyber-info { background: #eff6ff; border: 1px solid rgba(59,130,246,0.35); color: #1d4ed8; padding: 13px 16px; border-radius: 14px; font-size: 13.5px; margin-bottom: 18px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-cyber-success { background: #ecfdf5; border: 1px solid rgba(16,185,129,0.35); color: #065f46; padding: 13px 16px; border-radius: 14px; font-size: 13.5px; margin-bottom: 18px; display: flex; align-items: flex-start; gap: 10px; }
        .auth-footer-links { margin-top: 20px; padding-top: 16px; border-top: 1px solid rgba(244,63,94,0.12); text-align: center; font-size: 13.5px; color: #64748b; }
        .auth-footer-links a { color: #f43f5e; text-decoration: none; font-weight: 700; }
        @media (max-width: 480px) { .auth-card { padding: 1.5rem; width: 92%; } .otp-box { width: 42px; height: 52px; font-size: 20px; } }
    </style>
</head>
<body>
    <canvas id="cyberCanvas3D"></canvas>
    <div class="cyber-glow-blob cyber-glow-1"></div>
    <div class="cyber-glow-blob cyber-glow-2"></div>

    <div class="auth-wrapper">
        <div class="auth-card glass-card-3d">
            <div class="auth-header">
                <div class="auth-logo-badge"><i class='bx bx-mobile-alt'></i></div>
                <div class="clinical-badge"><i class='bx bx-mobile-alt'></i> VERIFIKASI KODE OTP</div>
                <h1>Masukkan Kode OTP</h1>
                <p>Kode 6-digit berlaku selama 15 menit sejak diminta</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert-cyber-error"><i class='bx bx-error-circle' style="font-size:20px;flex-shrink:0;"></i><div><?= esc(session()->getFlashdata('error')) ?></div></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert-cyber-success"><i class='bx bx-check-circle' style="font-size:20px;flex-shrink:0;"></i><div><?= esc(session()->getFlashdata('success')) ?></div></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('info')): ?>
                <div class="alert-cyber-info"><i class='bx bx-info-circle' style="font-size:20px;flex-shrink:0;"></i><div><?= esc(session()->getFlashdata('info')) ?></div></div>
            <?php endif; ?>

            <?php if (!empty($sandbox_otp)): ?>
            <div class="sandbox-otp-banner">
                <div class="banner-title"><i class='bx bx-test-tube' style="font-size:16px;"></i> Demo OTP Sandbox — Hanya Untuk Evaluasi</div>
                <div class="sandbox-otp-code"><?= esc($sandbox_otp) ?></div>
                <?php if (!empty($sandbox_email)): ?>
                <div style="font-size:12px;text-align:center;color:#78350f;margin-top:4px;">
                    Dikirim ke: <strong><?= esc($sandbox_email) ?></strong> (SMTP belum dikonfigurasi)
                </div>
                <?php endif; ?>
                <div class="sandbox-otp-warning">⚠️ Jangan gunakan tampilan ini di lingkungan produksi. Konfigurasikan SMTP di .env untuk pengiriman email nyata.</div>
            </div>
            <?php endif; ?>

            <div class="timer-text" id="timerText">Sisa waktu: <strong id="timerCountdown">15:00</strong></div>
            <div class="timer-bar-wrap"><div class="timer-bar" id="timerBar"></div></div>

            <form action="<?= base_url('lupa-sandi/verifikasi/proses') ?>" method="POST" id="otpForm">
                <?= csrf_field() ?>
                <input type="hidden" name="token" value="<?= esc($token) ?>">

                <div style="text-align:center;margin-bottom:12px;font-size:13.5px;color:#475569;">Ketik kode 6-digit di bawah ini:</div>
                <div class="otp-input-row" id="otpBoxRow">
                    <input type="text" class="otp-box" id="otpBox0" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code">
                    <input type="text" class="otp-box" id="otpBox1" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    <input type="text" class="otp-box" id="otpBox2" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    <input type="text" class="otp-box" id="otpBox3" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    <input type="text" class="otp-box" id="otpBox4" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    <input type="text" class="otp-box" id="otpBox5" maxlength="1" inputmode="numeric" pattern="[0-9]">
                </div>
                <input type="hidden" name="otp" id="otpHidden">

                <button type="submit" class="btn-cyber-primary" style="width:100%;padding:14px;font-size:16px;min-height:44px;" onclick="combineOtp()">
                    <i class='bx bx-check-shield' style="font-size:20px;"></i> Verifikasi OTP
                </button>
            </form>

            <div class="auth-footer-links">
                <a href="<?= base_url('lupa-sandi') ?>"><i class='bx bx-arrow-back'></i> Kembali &amp; Minta OTP Baru</a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
    <script>
        // OTP box auto-advance
        const boxes = document.querySelectorAll('.otp-box');
        boxes.forEach((box, i) => {
            box.addEventListener('input', e => {
                const v = e.target.value.replace(/\D/g, '');
                e.target.value = v;
                if (v && i < boxes.length - 1) boxes[i + 1].focus();
            });
            box.addEventListener('keydown', e => {
                if (e.key === 'Backspace' && !box.value && i > 0) boxes[i - 1].focus();
            });
            box.addEventListener('paste', e => {
                const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                boxes.forEach((b, idx) => b.value = paste[idx] || '');
                e.preventDefault();
            });
        });
        function combineOtp() {
            let otp = '';
            boxes.forEach(b => otp += b.value);
            document.getElementById('otpHidden').value = otp;
        }

        // Countdown timer
        const expiresAt = new Date('<?= esc($expires_at ?? '') ?>').getTime();
        const totalMs   = 15 * 60 * 1000;
        function updateTimer() {
            const now    = Date.now();
            const diff   = expiresAt - now;
            const pct    = Math.max(0, Math.min(100, (diff / totalMs) * 100));
            document.getElementById('timerBar').style.width = pct + '%';
            if (diff <= 0) {
                document.getElementById('timerCountdown').textContent = '00:00';
                document.getElementById('timerText').style.color = '#dc2626';
                return;
            }
            const m = String(Math.floor(diff / 60000)).padStart(2, '0');
            const s = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
            document.getElementById('timerCountdown').textContent = m + ':' + s;
            if (diff < 120000) document.getElementById('timerBar').style.background = '#dc2626';
            setTimeout(updateTimer, 1000);
        }
        updateTimer();
        document.getElementById('otpBox0').focus();
    </script>
</body>
</html>
