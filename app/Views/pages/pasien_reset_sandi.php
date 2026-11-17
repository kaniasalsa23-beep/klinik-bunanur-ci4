<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi Pasien | Klinik Bunanur</title>
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
        .input-group-cyber { position: relative; margin-bottom: 18px; }
        .input-group-cyber i.input-icon { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); font-size: 20px; color: #94a3b8; pointer-events: none; transition: color 0.3s; }
        .input-group-cyber .eye-toggle { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); font-size: 20px; color: #94a3b8; cursor: pointer; transition: color 0.3s; }
        .input-group-cyber .eye-toggle:hover { color: #f43f5e; }
        .alert-cyber-error { background: #fff1f2; border: 1px solid rgba(244,63,94,0.35); color: #be123c; padding: 13px 16px; border-radius: 14px; font-size: 13.5px; margin-bottom: 18px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-cyber-success { background: #ecfdf5; border: 1px solid rgba(16,185,129,0.35); color: #065f46; padding: 13px 16px; border-radius: 14px; font-size: 13.5px; margin-bottom: 18px; display: flex; align-items: flex-start; gap: 10px; }
        /* Password Strength Meter */
        .strength-meter-wrap { margin: -10px 0 16px; }
        .strength-bar-row { display: flex; gap: 4px; margin-bottom: 6px; }
        .strength-bar-seg { flex: 1; height: 5px; border-radius: 3px; background: #e2e8f0; transition: background 0.3s; }
        .strength-bar-seg.weak { background: #f43f5e; }
        .strength-bar-seg.medium { background: #f59e0b; }
        .strength-bar-seg.strong { background: #22c55e; }
        .strength-label { font-size: 12px; color: #64748b; display: flex; align-items: center; gap: 5px; }
        .strength-label .label-text { font-weight: 700; }
        .password-requirements { background: rgba(248,250,252,0.9); border: 1px solid rgba(226,232,240,0.8); border-radius: 12px; padding: 12px 14px; font-size: 12px; color: #475569; margin-bottom: 16px; }
        .req-item { display: flex; align-items: center; gap: 7px; margin-bottom: 4px; }
        .req-item:last-child { margin-bottom: 0; }
        .req-icon { font-size: 14px; }
        .req-icon.ok { color: #22c55e; }
        .req-icon.fail { color: #cbd5e1; }
        .auth-footer-links { margin-top: 20px; padding-top: 16px; border-top: 1px solid rgba(244,63,94,0.12); text-align: center; font-size: 13.5px; color: #64748b; }
        .auth-footer-links a { color: #f43f5e; text-decoration: none; font-weight: 700; }
        @media (max-width: 480px) { .auth-card { padding: 1.5rem; width: 92%; } }
    </style>
</head>
<body>
    <canvas id="cyberCanvas3D"></canvas>
    <div class="cyber-glow-blob cyber-glow-1"></div>
    <div class="cyber-glow-blob cyber-glow-2"></div>

    <div class="auth-wrapper">
        <div class="auth-card glass-card-3d">
            <div class="auth-header">
                <div class="auth-logo-badge"><i class='bx bx-lock-open-alt'></i></div>
                <div class="clinical-badge"><i class='bx bx-shield-quarter'></i> PERBARUI KATA SANDI</div>
                <h1>Buat Kata Sandi Baru</h1>
                <p>Gunakan kata sandi yang kuat dan belum pernah digunakan sebelumnya</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert-cyber-error"><i class='bx bx-error-circle' style="font-size:20px;flex-shrink:0;"></i><div><?= esc(session()->getFlashdata('error')) ?></div></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert-cyber-success"><i class='bx bx-check-circle' style="font-size:20px;flex-shrink:0;"></i><div><?= esc(session()->getFlashdata('success')) ?></div></div>
            <?php endif; ?>

            <div class="password-requirements">
                <div class="req-item"><i class='bx bx-info-circle req-icon fail' id="reqLen"></i><span>Minimal 8 karakter</span></div>
                <div class="req-item"><i class='bx bx-info-circle req-icon fail' id="reqUp"></i><span>Minimal 1 huruf besar (A-Z)</span></div>
                <div class="req-item"><i class='bx bx-info-circle req-icon fail' id="reqLo"></i><span>Minimal 1 huruf kecil (a-z)</span></div>
                <div class="req-item"><i class='bx bx-info-circle req-icon fail' id="reqNum"></i><span>Minimal 1 angka (0-9)</span></div>
                <div class="req-item"><i class='bx bx-info-circle req-icon fail' id="reqSym"></i><span>Minimal 1 simbol (!@#$%&amp;*)</span></div>
            </div>

            <form action="<?= base_url('lupa-sandi/reset/proses') ?>" method="POST" id="resetForm">
                <?= csrf_field() ?>
                <input type="hidden" name="token" value="<?= esc($token) ?>">

                <div class="input-group-cyber">
                    <input type="password" name="password" id="newPassword" class="cyber-input"
                        placeholder="Kata Sandi Baru" required autocomplete="new-password"
                        style="padding-left:50px;padding-right:48px;"
                        oninput="checkStrength(this.value)">
                    <i class='bx bx-lock-alt input-icon'></i>
                    <i class='bx bx-hide eye-toggle' id="togglePwd" onclick="togglePw('newPassword','togglePwd')"></i>
                </div>
                <!-- Strength Meter -->
                <div class="strength-meter-wrap">
                    <div class="strength-bar-row">
                        <div class="strength-bar-seg" id="seg1"></div>
                        <div class="strength-bar-seg" id="seg2"></div>
                        <div class="strength-bar-seg" id="seg3"></div>
                        <div class="strength-bar-seg" id="seg4"></div>
                    </div>
                    <div class="strength-label"><span class="label-text" id="strengthLabel">Belum ada kata sandi</span></div>
                </div>

                <div class="input-group-cyber">
                    <input type="password" name="confirm" id="confirmPassword" class="cyber-input"
                        placeholder="Konfirmasi Kata Sandi Baru" required autocomplete="new-password"
                        style="padding-left:50px;padding-right:48px;">
                    <i class='bx bx-lock-alt input-icon'></i>
                    <i class='bx bx-hide eye-toggle' id="toggleConf" onclick="togglePw('confirmPassword','toggleConf')"></i>
                </div>

                <button type="submit" class="btn-cyber-primary" style="width:100%;padding:14px;font-size:16px;min-height:44px;" id="submitBtn">
                    <i class='bx bx-shield-quarter' style="font-size:20px;"></i> Simpan Kata Sandi Baru
                </button>
            </form>

            <div class="auth-footer-links">
                <a href="<?= base_url('lupa-sandi') ?>"><i class='bx bx-arrow-back'></i> Mulai Ulang Proses</a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
    <script>
        function togglePw(inputId, iconId) {
            const inp = document.getElementById(inputId);
            const ico = document.getElementById(iconId);
            if (inp.type === 'password') {
                inp.type = 'text';
                ico.classList.replace('bx-hide', 'bx-show');
            } else {
                inp.type = 'password';
                ico.classList.replace('bx-show', 'bx-hide');
            }
        }
        function setReq(id, ok) {
            const el = document.getElementById(id);
            el.classList.toggle('ok', ok);
            el.classList.toggle('fail', !ok);
            el.classList.replace(ok ? 'bx-info-circle' : 'bx-check-circle', ok ? 'bx-check-circle' : 'bx-info-circle');
        }
        function checkStrength(val) {
            const len = val.length >= 8;
            const up  = /[A-Z]/.test(val);
            const lo  = /[a-z]/.test(val);
            const num = /[0-9]/.test(val);
            const sym = /[!@#$%^&*()_\-+=\[\]{};':"|,.<>/?~`]/.test(val);
            setReq('reqLen', len); setReq('reqUp', up); setReq('reqLo', lo);
            setReq('reqNum', num); setReq('reqSym', sym);
            const score = [len, up, lo, num, sym].filter(Boolean).length;
            const segs = ['seg1','seg2','seg3','seg4'];
            segs.forEach((s, i) => {
                const el = document.getElementById(s);
                el.classList.remove('weak','medium','strong');
                if (i < score) {
                    el.classList.add(score <= 2 ? 'weak' : score <= 3 ? 'medium' : 'strong');
                }
            });
            const label = document.getElementById('strengthLabel');
            const colors = { 0: '#94a3b8', 1: '#f43f5e', 2: '#f43f5e', 3: '#f59e0b', 4: '#22c55e', 5: '#16a34a' };
            const labels = { 0: 'Belum ada kata sandi', 1: 'Sangat Lemah', 2: 'Lemah', 3: 'Cukup', 4: 'Kuat', 5: 'Sangat Kuat ✓' };
            label.textContent = labels[score] || 'Sangat Kuat ✓';
            label.style.color = colors[score] || '#16a34a';
        }
    </script>
</body>
</html>
