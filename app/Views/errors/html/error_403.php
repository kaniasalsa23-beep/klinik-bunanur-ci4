<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | Bunanur Medical</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #fff5f7 0%, #fdf2f8 50%, #fce7f3 100%);
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
        }
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.65;
        }
        .orb-1 {
            width: 380px;
            height: 380px;
            background: rgba(225, 29, 72, 0.22);
            top: -100px;
            left: -80px;
        }
        .orb-2 {
            width: 420px;
            height: 420px;
            background: rgba(244, 63, 94, 0.20);
            bottom: -120px;
            right: -100px;
        }
        .error-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 580px;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1.5px solid rgba(225, 29, 72, 0.22);
            border-radius: 32px;
            padding: 48px 40px;
            text-align: center;
            box-shadow: 0 25px 60px -15px rgba(225, 29, 72, 0.20), 0 0 0 1px rgba(255, 255, 255, 0.8) inset;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .error-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 70px -15px rgba(225, 29, 72, 0.26);
        }
        .icon-badge {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, rgba(225, 29, 72, 0.15) 0%, rgba(244, 63, 94, 0.15) 100%);
            border: 1.5px solid rgba(225, 29, 72, 0.3);
            border-radius: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 46px;
            color: #e11d48;
            box-shadow: 0 12px 28px -6px rgba(225, 29, 72, 0.25);
        }
        .code-title {
            font-size: 72px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #e11d48 0%, #f43f5e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -2px;
        }
        .headline {
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
        }
        .description {
            font-size: 15px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 32px;
            max-width: 440px;
            margin-left: auto;
            margin-right: auto;
        }
        .actions-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            justify-content: center;
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            background: linear-gradient(135deg, #e11d48 0%, #f43f5e 100%);
            color: #ffffff;
            font-weight: 600;
            font-size: 14.5px;
            border-radius: 16px;
            text-decoration: none;
            box-shadow: 0 10px 24px -4px rgba(225, 29, 72, 0.35);
            transition: all 0.25s ease;
            border: none;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px -4px rgba(225, 29, 72, 0.45);
            color: #ffffff;
        }
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 26px;
            background: rgba(255, 255, 255, 0.9);
            color: #475569;
            font-weight: 600;
            font-size: 14.5px;
            border-radius: 16px;
            text-decoration: none;
            border: 1.5px solid rgba(225, 29, 72, 0.2);
            transition: all 0.25s ease;
        }
        .btn-secondary:hover {
            background: rgba(254, 242, 242, 0.9);
            color: #e11d48;
            border-color: #e11d48;
            transform: translateY(-2px);
        }
        .footer-note {
            margin-top: 30px;
            font-size: 12.5px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="error-card">
        <div class="icon-badge">
            <i class='bx bx-shield-x'></i>
        </div>
        <div class="code-title">403</div>
        <h1 class="headline">Akses Terbatas / Ditolak</h1>
        <p class="description">
            Anda tidak memiliki hak otorisasi untuk mengakses direktori atau sumber daya ini. Pastikan Anda telah masuk dengan peran (role) akun yang sesuai.
        </p>

        <div class="actions-wrap">
            <a href="<?= base_url('/') ?>" class="btn-primary">
                <i class='bx bx-home-heart'></i> Beranda Klinik
            </a>
            <a href="<?= base_url('login_pasien') ?>" class="btn-secondary">
                <i class='bx bx-user-check'></i> Masuk Ulang
            </a>
        </div>

        <p class="footer-note">Bunanur Medical & Healthcare Information System</p>
    </div>
</body>
</html>

