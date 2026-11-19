<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pasien - Bunanur Medical Center</title>

    <!-- Master Glassmorphism 3D CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #fff5f7 0%, #fdf2f8 50%, #fce7f3 100%);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden;
        }

        .register-container {
            width: 100%;
            max-width: 580px;
            position: relative;
            z-index: 10;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1.5px solid rgba(244, 63, 94, 0.18);
            border-radius: 32px;
            padding: 45px 40px;
            box-shadow: 0 25px 60px -15px rgba(244, 63, 94, 0.15), 0 0 40px rgba(255, 255, 255, 0.8) inset;
        }

        .header-brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo-wrap {
            width: 74px;
            height: 74px;
            margin: 0 auto 16px;
            border-radius: 22px;
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(244, 63, 94, 0.35);
            padding: 10px;
        }

        .logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .header-brand h1 {
            font-size: 26px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .header-brand p {
            color: #64748b;
            font-size: 14px;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(244, 63, 94, 0.10);
            color: #f43f5e;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media(max-width: 580px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-grid .full { grid-column: span 1; }
        }

        .form-grid .full {
            grid-column: span 2;
        }

        .cyber-input-group {
            position: relative;
            margin-bottom: 16px;
        }

        .cyber-input-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #f43f5e;
            font-size: 20px;
            transition: all 0.3s;
        }

        .cyber-input {
            width: 100%;
            padding: 14px 18px 14px 50px;
            background: rgba(255, 255, 255, 0.95);
            border: 1.5px solid rgba(244, 63, 94, 0.18);
            border-radius: 16px;
            font-family: inherit;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: all 0.3s ease;
        }

        .cyber-input:focus {
            border-color: #f43f5e;
            box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.12);
            background: #ffffff;
        }

        .btn-register-submit {
            width: 100%;
            padding: 15px;
            margin-top: 10px;
            background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(244, 63, 94, 0.3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-register-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 32px rgba(244, 63, 94, 0.4);
        }

        .footer-login {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(244, 63, 94, 0.12);
            font-size: 14px;
            color: #64748b;
        }

        .footer-login a {
            color: #f43f5e;
            font-weight: 700;
            text-decoration: none;
            margin-left: 5px;
        }

        .footer-login a:hover {
            text-decoration: underline;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
            padding: 12px 18px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    
        @media(max-width: 768px) {
            .auth-wrapper { padding: 20px 14px !important; }
            .auth-card, .register-card { padding: 24px 16px !important; width: 95% !important; border-radius: 22px !important; }
        }
        @media(max-width: 480px) {
            .auth-card, .register-card { padding: 18px 12px !important; border-radius: 18px !important; }
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive-mobile.css') ?>">
</head>
<body>

<!-- 3D Canvas Background -->
<canvas id="cyberCanvas"></canvas>

<div class="register-container">
    <div class="register-card" data-tilt data-tilt-max="4" data-tilt-glare="true" data-tilt-max-glare="0.12">
        <div class="header-brand">
            <div class="logo-wrap">
                <img src="<?= base_url('assets/Logo.png') ?>" alt="Logo">
            </div>
            <div class="role-badge">
                <i class='bx bx-user-check'></i> Portal Pasien Baru
            </div>
            <h1>Pendaftaran Akun Pasien</h1>
            <p>Lengkapi formulir untuk membuat rekam medis digital Anda.</p>
        </div>

        <?php if(session()->getFlashdata('error')) : ?>
            <div class="alert-error">
                <i class='bx bx-error-circle' style="font-size: 18px;"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= base_url('register_proses') ?>">
            <?= csrf_field() ?>

            <div class="cyber-input-group">
                <i class='bx bx-user'></i>
                <input type="text" name="nama" class="cyber-input" placeholder="Nama Lengkap Sesuai KTP" required>
            </div>

            <div class="form-grid">
                <div class="cyber-input-group">
                    <i class='bx bx-id-card'></i>
                    <input type="text" name="username" class="cyber-input" placeholder="Username" required>
                </div>

                <div class="cyber-input-group">
                    <i class='bx bx-envelope'></i>
                    <input type="email" name="email" class="cyber-input" placeholder="Alamat Email" required>
                </div>
            </div>

            <div class="form-grid">
                <div class="cyber-input-group">
                    <i class='bx bx-phone'></i>
                    <input type="text" name="no_hp" class="cyber-input" placeholder="Masukkan Nomor WhatsApp" required>
                </div>

                <div class="cyber-input-group">
                    <i class='bx bx-map-pin'></i>
                    <input type="text" name="alamat" class="cyber-input" placeholder="Alamat Domisili" required>
                </div>
            </div>

            <div class="form-grid">
                <div class="cyber-input-group">
                    <i class='bx bx-lock-alt'></i>
                    <input type="password" name="password" class="cyber-input" placeholder="Kata Sandi" required>
                </div>

                <div class="cyber-input-group">
                    <i class='bx bx-check-shield'></i>
                    <input type="password" name="confirm" class="cyber-input" placeholder="Ulangi Kata Sandi" required>
                </div>
            </div>

            <button type="submit" name="register" class="btn-register-submit">
                <i class='bx bx-user-plus'></i> Selesaikan Pendaftaran
            </button>
        </form>

        <div class="footer-login">
            Sudah memiliki akun terdaftar? 
            <a href="<?= base_url('login_pasien') ?>">Masuk di sini</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
<script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
</body>
</html>
