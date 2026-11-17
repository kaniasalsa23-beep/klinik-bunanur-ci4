<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi Pasien | Bunanur Care</title>

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

        .input-group-cyber {
            position: relative;
            margin-bottom: 16px;
        }

        .cyber-input {
            width: 100%;
            padding: 14px 44px 14px 46px;
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

        .toggle-password-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: var(--text-muted);
            cursor: pointer;
            transition: color 0.2s;
        }

        .toggle-password-icon:hover {
            color: var(--primary-rose);
        }

        /* Password Strength Meter */
        .strength-meter-container {
            margin: 10px 0 18px;
            padding: 14px;
            background: #fffafa;
            border-radius: 16px;
            border: 1px solid rgba(244, 63, 94, 0.18);
        }

        .strength-bar-bg {
            height: 6px;
            background: #f1f5f9;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .strength-bar-fill {
            height: 100%;
            width: 0%;
            background: #ef4444;
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .strength-text {
            display: flex;
            justify-content: space-between;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .criteria-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            font-size: 11.5px;
            color: var(--text-muted);
        }

        .criteria-item {
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .criteria-item i {
            font-size: 14px;
            color: #cbd5e1;
        }

        .criteria-item.valid {
            color: #15803d;
            font-weight: 600;
        }

        .criteria-item.valid i {
            color: #16a34a;
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
                    <i class='bx bx-lock-open-alt'></i> ATUR ULANG KATA SANDI
                </div>
                <h1>Kata Sandi Baru</h1>
                <p>Tentukan kata sandi baru untuk akun pasien Anda.</p>
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

            <form action="<?= base_url('pasien/reset-sandi') ?>" method="POST" id="resetPasienForm">
                <?= csrf_field() ?>
                <input type="hidden" name="token" value="<?= esc($token) ?>">

                <div class="input-group-cyber">
                    <input
                        type="password"
                        name="password"
                        id="passwordInput"
                        class="cyber-input"
                        placeholder="Kata Sandi Baru"
                        required
                        autocomplete="new-password"
                        oninput="checkPasswordStrength(this.value)"
                    >
                    <i class='bx bx-lock-alt input-icon'></i>
                    <i class='bx bx-show toggle-password-icon' onclick="togglePasswordVisibility('passwordInput', this)"></i>
                </div>

                <!-- Password Strength Meter & Real-time Indicator -->
                <div class="strength-meter-container">
                    <div class="strength-text">
                        <span>Kekuatan Kata Sandi:</span>
                        <span id="strengthLabel" style="color: #ef4444;">Sangat Lemah</span>
                    </div>
                    <div class="strength-bar-bg">
                        <div class="strength-bar-fill" id="strengthBar"></div>
                    </div>
                    <div class="criteria-list">
                        <div class="criteria-item" id="critLength">
                            <i class='bx bx-check-circle'></i> Min. 8 Karakter
                        </div>
                        <div class="criteria-item" id="critUpper">
                            <i class='bx bx-check-circle'></i> Huruf Besar (A-Z)
                        </div>
                        <div class="criteria-item" id="critLower">
                            <i class='bx bx-check-circle'></i> Huruf Kecil (a-z)
                        </div>
                        <div class="criteria-item" id="critNumber">
                            <i class='bx bx-check-circle'></i> Angka (0-9)
                        </div>
                        <div class="criteria-item" id="critSymbol" style="grid-column: span 2;">
                            <i class='bx bx-check-circle'></i> Karakter Khusus / Simbol (!@#$%^&*)
                        </div>
                    </div>
                </div>

                <div class="input-group-cyber">
                    <input
                        type="password"
                        name="konfirmasi"
                        id="konfirmasiInput"
                        class="cyber-input"
                        placeholder="Konfirmasi Kata Sandi Baru"
                        required
                        autocomplete="new-password"
                    >
                    <i class='bx bx-lock-check input-icon'></i>
                    <i class='bx bx-show toggle-password-icon' onclick="togglePasswordVisibility('konfirmasiInput', this)"></i>
                </div>

                <button type="submit" class="btn-cyber-primary" id="btnSubmitReset">
                    <i class='bx bx-check-double' style="font-size: 20px;"></i>
                    Simpan Kata Sandi Pasien
                </button>
            </form>

            <div class="auth-footer-links">
                <a href="<?= base_url('login_pasien') ?>">
                    <i class='bx bx-arrow-back'></i> Kembali ke Login Pasien
                </a>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>

    <script>
        function togglePasswordVisibility(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            } else {
                input.type = 'password';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            }
        }

        function checkPasswordStrength(val) {
            const hasLen = val.length >= 8;
            const hasUpper = /[A-Z]/.test(val);
            const hasLower = /[a-z]/.test(val);
            const hasNumber = /[0-9]/.test(val);
            const hasSymbol = /[!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?~`]/.test(val);

            document.getElementById('critLength').className = 'criteria-item ' + (hasLen ? 'valid' : '');
            document.getElementById('critUpper').className = 'criteria-item ' + (hasUpper ? 'valid' : '');
            document.getElementById('critLower').className = 'criteria-item ' + (hasLower ? 'valid' : '');
            document.getElementById('critNumber').className = 'criteria-item ' + (hasNumber ? 'valid' : '');
            document.getElementById('critSymbol').className = 'criteria-item ' + (hasSymbol ? 'valid' : '');

            let score = 0;
            if (hasLen) score++;
            if (hasUpper) score++;
            if (hasLower) score++;
            if (hasNumber) score++;
            if (hasSymbol) score++;

            const bar = document.getElementById('strengthBar');
            const label = document.getElementById('strengthLabel');

            if (score <= 1) {
                bar.style.width = '20%';
                bar.style.background = '#ef4444';
                label.innerText = 'Sangat Lemah';
                label.style.color = '#ef4444';
            } else if (score === 2) {
                bar.style.width = '40%';
                bar.style.background = '#f97316';
                label.innerText = 'Lemah';
                label.style.color = '#f97316';
            } else if (score === 3) {
                bar.style.width = '60%';
                bar.style.background = '#eab308';
                label.innerText = 'Sedang';
                label.style.color = '#eab308';
            } else if (score === 4) {
                bar.style.width = '80%';
                bar.style.background = '#3b82f6';
                label.innerText = 'Kuat';
                label.style.color = '#3b82f6';
            } else {
                bar.style.width = '100%';
                bar.style.background = '#10b981';
                label.innerText = 'Sangat Kuat (Sesuai Standar)';
                label.style.color = '#10b981';
            }
        }
    </script>
</body>
</html>
