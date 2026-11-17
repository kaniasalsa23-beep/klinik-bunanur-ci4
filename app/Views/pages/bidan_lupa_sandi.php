<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemulihan Akses Bidan | Klinik Bunanur</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">
    <style>
        .auth-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 30px 20px; position: relative; z-index: 10; }
        .auth-card { width: 100%; max-width: 500px; padding: 44px 38px; border-radius: 30px; background: rgba(255,255,255,0.85); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); border: 1.5px solid rgba(244,63,94,0.20); box-shadow: 0 20px 50px rgba(244,63,94,0.10), 0 4px 20px rgba(0,0,0,0.04); }
        .auth-header { text-align: center; margin-bottom: 26px; }
        .auth-logo-badge { width: 84px; height: 84px; margin: 0 auto 14px; background: linear-gradient(135deg,#fff1f2 0%,#ffffff 100%); border: 2px solid rgba(244,63,94,0.32); border-radius: 26px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 24px rgba(244,63,94,0.16); }
        .auth-logo-badge img { width: 52px; height: 52px; object-fit: contain; }
        .clinical-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 14px; border-radius: 20px; font-size: 11.5px; font-weight: 800; background: #fff1f2; border: 1px solid rgba(244,63,94,0.3); color: #f43f5e; letter-spacing: 0.5px; margin-bottom: 12px; }
        .auth-header h1 { font-size: 26px; font-weight: 800; color: #1e293b; letter-spacing: -0.5px; margin-bottom: 6px; }
        .auth-header p { color: #64748b; font-size: 13.5px; }
        .input-group-cyber { position: relative; margin-bottom: 18px; }
        .input-group-cyber i.input-icon { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); font-size: 20px; color: #94a3b8; pointer-events: none; transition: color 0.3s; }
        .alert-cyber-error { background: #fff1f2; border: 1px solid rgba(244,63,94,0.35); color: #be123c; padding: 13px 16px; border-radius: 14px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-cyber-info { background: #eff6ff; border: 1px solid rgba(59,130,246,0.35); color: #1d4ed8; padding: 13px 16px; border-radius: 14px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-cyber-success { background: #ecfdf5; border: 1px solid rgba(16,185,129,0.35); color: #065f46; padding: 13px 16px; border-radius: 14px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; }
        .recovery-hint { background: rgba(251,191,36,0.10); border: 1px solid rgba(251,191,36,0.35); border-radius: 14px; padding: 12px 16px; font-size: 12.5px; color: #92400e; margin-bottom: 18px; display: flex; gap: 10px; }
        .auth-footer-links { margin-top: 22px; padding-top: 18px; border-top: 1px solid rgba(244,63,94,0.12); text-align: center; font-size: 13.5px; color: #64748b; }
        .auth-footer-links a { color: #f43f5e; text-decoration: none; font-weight: 700; }
        .auth-footer-links a:hover { text-decoration: underline; }
        @media (max-width: 480px) { .auth-card { padding: 1.5rem; width: 92%; } .auth-header h1 { font-size: 22px; } }
    </style>
</head>
<body>
    <canvas id="cyberCanvas3D"></canvas>
    <div class="cyber-glow-blob cyber-glow-1"></div>
    <div class="cyber-glow-blob cyber-glow-2"></div>

    <div class="auth-wrapper">
        <div class="auth-card glass-card-3d" data-tilt data-tilt-max="4" data-tilt-glare data-tilt-max-glare="0.06">
            <div class="auth-header">
                <div class="auth-logo-badge">
                    <img src="<?= base_url('assets/Logo.png') ?>" alt="Logo Klinik Bunanur" onerror="this.src='<?= base_url('assets/profile/default-hero.png') ?>'">
                </div>
                <div class="clinical-badge"><i class='bx bx-shield-quarter'></i> PEMULIHAN AKSES KREDENSIAL BIDAN</div>
                <h1>Lupa Kata Sandi Bidan</h1>
                <p>Verifikasi identitas untuk memulihkan akses dashboard medis</p>
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

            <div class="recovery-hint">
                <i class='bx bx-key' style="font-size:18px;flex-shrink:0;margin-top:1px;"></i>
                <div><strong>Kode Pemulihan Master</strong> adalah PIN keamanan klinik yang ditetapkan oleh administrator. Hubungi manajemen Klinik Bunanur jika Anda tidak memilikinya.</div>
            </div>

            <form action="<?= base_url('bidan/lupa-sandi/proses') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="input-group-cyber">
                    <input type="text" name="identifier" class="cyber-input" value="<?= esc(old('identifier') ?? '') ?>"
                        placeholder="Username atau Email Bidan" required autocomplete="username" style="padding-left:50px;">
                    <i class='bx bx-id-card input-icon'></i>
                </div>

                <div class="input-group-cyber">
                    <input type="password" name="recovery_pin" class="cyber-input"
                        placeholder="Master Recovery PIN / Kode Keamanan Klinik" required style="padding-left:50px;">
                    <i class='bx bx-key input-icon'></i>
                </div>

                <!-- Math CAPTCHA -->
                <div class="cyber-captcha-box" id="captchaBox">
                    <div class="captcha-header-row">
                        <div class="captcha-checkbox-wrapper" id="captchaTrigger">
                            <div class="captcha-custom-checkbox" id="captchaCheckbox">
                                <i class='bx bx-check' id="captchaCheckIcon" style="display:none;color:#fff;font-size:20px;"></i>
                            </div>
                            <span class="captcha-label" id="captchaStatusText">Saya bukan robot</span>
                        </div>
                        <div class="captcha-brand"><i class='bx bxs-shield-plus'></i><span>CyberShield CI4</span></div>
                    </div>
                    <div class="captcha-pop-challenge" id="captchaChallengeDrawer">
                        <div style="font-size:12.5px;color:#64748b;margin-bottom:8px;">Selesaikan verifikasi angka:</div>
                        <div class="captcha-math-display">
                            <span class="captcha-math-equation"><?= esc($captcha['soal'] ?? '4 + 3 = ?') ?></span>
                            <input type="number" name="captcha" id="captchaInputField" class="cyber-input"
                                placeholder="Jawaban?" required
                                style="max-width:130px;padding:10px 14px;text-align:center;font-weight:700;font-size:16px;"
                                oninput="onCaptchaAnswerInput(this.value)">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-cyber-primary" style="width:100%;padding:15px;font-size:16px;min-height:44px;margin-top:16px;">
                    <i class='bx bx-lock-open-alt' style="font-size:20px;"></i> Verifikasi & Lanjutkan
                </button>
            </form>

            <div class="auth-footer-links">
                <a href="<?= base_url('login_bidan') ?>"><i class='bx bx-arrow-back'></i> Kembali ke Login Bidan</a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
    <script>
        let isCaptchaVerified = false;
        document.getElementById('captchaTrigger').addEventListener('click', function() {
            if (isCaptchaVerified) return;
            const checkbox = document.getElementById('captchaCheckbox');
            const statusText = document.getElementById('captchaStatusText');
            checkbox.classList.add('spinner');
            statusText.innerText = 'Memverifikasi...';
            setTimeout(() => {
                checkbox.classList.remove('spinner');
                document.getElementById('captchaChallengeDrawer').style.display = 'block';
                statusText.innerText = 'Selesaikan tantangan di bawah';
                document.getElementById('captchaInputField').focus();
            }, 550);
        });
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
                statusText.style.color = '';
                captchaBox.classList.remove('verified');
            }
        }
        <?php if (session()->getFlashdata('error')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const drawer = document.getElementById('captchaChallengeDrawer');
            if (drawer) drawer.style.display = 'block';
        });
        <?php endif; ?>
    </script>
</body>
</html>
