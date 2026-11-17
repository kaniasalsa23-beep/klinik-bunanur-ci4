<?php

namespace App\Controllers;

use App\Models\GaleriBerandaModel;
use App\Models\BidanModel;
use App\Libraries\JwtAuth;
use App\Libraries\RateLimiter;

class Home extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = session();
        helper(['cookie', 'security']);
    }

    /**
     * Helper membuat soal matematika CAPTCHA sederhana
     */
    private function generateCaptcha(): array
    {
        $n1 = rand(1, 9);
        $n2 = rand(1, 9);
        $answer = $n1 + $n2;

        session()->set('captcha_answer', (string)$answer);

        return [
            'soal' => "{$n1} + {$n2} = ?",
            'n1'   => $n1,
            'n2'   => $n2
        ];
    }

    /**
     * Helper Rate Limiter Login Gagal (Maksimal 5 kali per 15 menit)
     */
    private function handleFailedLogin(string $username, string $ipAddress, string $errorMessage)
    {
        $fail = RateLimiter::recordFailedLogin($username, $ipAddress, $errorMessage, 5, 900);

        return redirect()->back()
            ->withInput()
            ->with('error', $fail['message']);
    }

public function index()
{
    $profilModel = new BidanModel();
    $galeriModel = new GaleriBerandaModel();

    $profil = $profilModel->first();
    if (empty($profil)) {
        $profil = [];
    }

    // Default Fallback Kaya Bahasa Indonesia untuk seluruh heading & deskripsi hero/tentang
    if (empty(trim($profil['hero_judul'] ?? ''))) {
        $profil['hero_judul'] = 'Perawatan Lembut & Penuh Kasih untuk Ibu dan Buah Hati';
    }
    if (empty(trim($profil['spesialis'] ?? ''))) {
        $profil['spesialis'] = !empty(trim($profil['nama'] ?? '')) ? $profil['nama'] : 'Klinik Pratama Kebidanan & Perawatan Holistik Ibu-Anak';
    }
    if (empty(trim($profil['hero_subjudul'] ?? ''))) {
        $profil['hero_subjudul'] = 'Layanan pemeriksaan kehamilan, persalinan nyaman, dan perawatan tumbuh kembang bayi dengan pendekatan medis modern yang hangat, aman, dan terpercaya.';
    }
    if (empty(trim($profil['tentang'] ?? ''))) {
        $profil['tentang'] = 'Klinik Bunanur didirikan dengan visi menghadirkan perawatan kebidanan yang hangat, profesional, dan berbasis bukti untuk mendukung kesehatan ibu dan anak.';
    }

    $data['profil'] = $profil;

    $data['pasien'] = session()->get('pasien');

    $galeri = $galeriModel
        ->orderBy('id', 'DESC')
        ->findAll();

    $data['galeriVideo'] = array_filter($galeri, function ($g) {
        return isset($g['tipe']) && $g['tipe'] == 'video';
    });

    $data['galeriFoto'] = array_filter($galeri, function ($g) {
        return isset($g['tipe']) && $g['tipe'] == 'foto';
    });

$testimoni = $this->db->table('testimoni t')
    ->select('
        t.id,
        t.rating,
        t.ulasan,
        t.foto,
        t.created_at,
        p.nama,
        p.foto AS foto_profil
    ')
    ->join('pasien p', 'p.id = t.pasien_id', 'left')
    ->where('t.approve', 'Selesai')
    ->orderBy('t.id', 'DESC')
    ->get()
    ->getResultArray();

if (empty($testimoni)) {
    $testimoni = [
        [
            'nama'        => 'Bunda Sarah Larasati',
            'rating'      => 5,
            'ulasan'      => 'Pelayanan di Klinik Bunanur luar biasa nyaman. Bidan sangat ramah, sabar, dan telaten memeriksa kehamilan. Fasilitasnya bersih dan bernuansa hangat.',
            'foto_profil' => 'default-hero.png',
            'foto'        => ''
        ],
        [
            'nama'        => 'Bunda Anisa Rahma',
            'rating'      => 5,
            'ulasan'      => 'Pijat bayi dan imunisasi di sini selalu jadi pilihan pertama keluarga kami. Buah hati tenang dan tidak rewel karena penanganannya sangat lembut.',
            'foto_profil' => 'default-hero.png',
            'foto'        => ''
        ],
        [
            'nama'        => 'Bunda Dwi Lestari',
            'rating'      => 5,
            'ulasan'      => 'Konsultasi kehamilan online sangat responsif dan membantu menenangkan kekhawatiran saya. Sangat merekomendasikan Klinik Bunanur!',
            'foto_profil' => 'default-hero.png',
            'foto'        => ''
        ]
    ];
}

$data['testimoni'] = $testimoni;

    return view('index', $data);
}

public function register()
{
    return view('pages/register');
}

public function loginForm()
{
    // Auto-login melalui cookie "Ingat Saya" (Remember Me) jika sesi belum aktif
    if (!session()->has('pasien')) {
        $rememberToken = get_cookie('remember_token_pasien');
        if ($rememberToken) {
            try {
                $decrypted = \Config\Services::encrypter()->decrypt(base64_decode($rememberToken));
                $payload = json_decode($decrypted, true);
                if (!empty($payload['id'])) {
                    $pasien = $this->db->table('pasien')->where('id', $payload['id'])->get()->getRowArray();
                    if ($pasien) {
                        $this->session->set('pasien', [
                            'id'       => $pasien['id'],
                            'nama'     => $pasien['nama'],
                            'username' => $pasien['username'],
                            'email'    => $pasien['email'],
                            'foto'     => $pasien['foto']
                        ]);
                        $this->session->set('chat_limit', 5);
                        return redirect()->to('/dashboard_pasien');
                    }
                }
            } catch (\Exception $e) {
                delete_cookie('remember_token_pasien');
            }
        }
    } else {
        return redirect()->to('/dashboard_pasien');
    }

    $captcha = $this->generateCaptcha();

    return view('pages/login_pasien', [
        'captcha' => $captcha
    ]);
}

    // Proses Login Pasien dengan Enterprise Rate Limiting, Account Lockout, Validasi CAPTCHA, Bcrypt Rehashing & JWT HttpOnly Cookie
    public function login()
    {
        $ipAddress = $this->request->getIPAddress();
        $endpoint  = 'login_pasien';

        // 1. Rate Limiting: 5 Permintaan per 15 Menit (900 detik)
        $rateCheck = RateLimiter::checkEndpointRateLimit($ipAddress, $endpoint, 5, 900);
        if (!$rateCheck['allowed']) {
            return redirect()->back()
                ->withInput()
                ->with('error', $rateCheck['message']);
        }

        // 2. Server-side Input Validation
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'password' => 'required',
            'captcha'  => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Semua bidang termasuk CAPTCHA wajib diisi dengan benar.');
        }

        $username   = trim((string)$this->request->getPost('username'));
        $password   = (string)$this->request->getPost('password');
        $rememberMe = (bool)$this->request->getPost('remember_me');

        // 3. Automated Account Lockout Check (15-Minute Cooldown)
        // Dilakukan SEBELUM query database & verifikasi password untuk mencegah timing attacks & credential stuffing
        $lockCheck = RateLimiter::isAccountLocked($username, $ipAddress);
        if ($lockCheck['is_locked']) {
            return redirect()->back()
                ->withInput()
                ->with('error', $lockCheck['message']);
        }

        // 4. Validasi CAPTCHA Matematika (Single-use verification)
        $userCaptcha     = trim((string)$this->request->getPost('captcha'));
        $expectedCaptcha = (string)session()->get('captcha_answer');
        session()->remove('captcha_answer');

        if ($expectedCaptcha === '' || $userCaptcha !== $expectedCaptcha) {
            return $this->handleFailedLogin($username, $ipAddress, 'Verifikasi CAPTCHA salah atau kedaluwarsa. Silakan hitung kembali.');
        }

        // 5. Query Kredensial Pengguna via Parameterized Query
        $query = $this->db->query(
            "SELECT * FROM pasien WHERE username = ?",
            [$username]
        );
        $pasien = $query->getRowArray();

        if (!$pasien) {
            return $this->handleFailedLogin($username, $ipAddress, 'Username tidak ditemukan');
        }

        // 6. Verifikasi Password (Constant-Time Verification)
        if (!password_verify($password, $pasien['password'])) {
            return $this->handleFailedLogin($username, $ipAddress, 'Password salah');
        }

        // 7. Automatic Password Rehashing (Upgrade otomatis ke Bcrypt cost 12 jika hash lama)
        if (password_needs_rehash($pasien['password'], PASSWORD_BCRYPT, ['cost' => 12])) {
            $newHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            $this->db->table('pasien')
                ->where('id', $pasien['id'])
                ->update(['password' => $newHash]);
        }

        // 8. Bersihkan State Kegagalan & Rate Limiter saat login berhasil
        RateLimiter::clearLoginState($username, $ipAddress, $endpoint);

        // 9. Mitigasi Session Fixation: Regenerasi Session ID
        session()->regenerate(true);

        // Update status online pasien
        $this->db->table('pasien')
            ->where('id', $pasien['id'])
            ->update([
                'last_seen' => date('Y-m-d H:i:s')
            ]);

        // Simpan sesi login
        $this->session->set('pasien', [
            'id'       => $pasien['id'],
            'nama'     => $pasien['nama'],
            'username' => $pasien['username'],
            'email'    => $pasien['email'],
            'foto'     => $pasien['foto']
        ]);
        $this->session->set('chat_limit', 5);

        // 10. Stateless JWT Token dalam HttpOnly Cookie (Strict Security)
        $jwtToken = JwtAuth::generateToken($pasien['id'], 'pasien', $pasien['username']);
        JwtAuth::setCookie($jwtToken);

        // 11. Opsi "Ingat Saya" (Remember Me) via Cookie Terenkripsi
        if ($rememberMe) {
            try {
                $payload = json_encode([
                    'id'       => $pasien['id'],
                    'username' => $pasien['username'],
                    'time'     => time()
                ]);
                $encryptedToken = base64_encode(\Config\Services::encrypter()->encrypt($payload));

                set_cookie([
                    'name'     => 'remember_token_pasien',
                    'value'    => $encryptedToken,
                    'expire'   => 86400 * 30, // Berlaku 30 hari
                    'path'     => '/',
                    'secure'   => JwtAuth::isHttps(),
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
            } catch (\Exception $e) {
                log_message('error', 'Gagal enkripsi remember me pasien: ' . $e->getMessage());
            }
        } else {
            delete_cookie('remember_token_pasien');
        }

        return redirect()->to('/dashboard_pasien');
    }

    // Dashboard Pasien
    public function dashboardPasien()
    {
        if (!session()->has('pasien')) {
            return redirect()->to('/login_pasien');
        }

        // Query status bidan secara dinamis (apakah ada bidan online siaga)
        $onlineBidan = $this->db
            ->table('bidan')
            ->where('status', 'online')
            ->orderBy('last_seen', 'DESC')
            ->get()
            ->getRowArray();

        $bidan = $onlineBidan ?: $this->db->table('bidan')->orderBy('id', 'ASC')->get()->getRowArray();
        $isBidanOnline = !empty($onlineBidan);

        return view('pages/dashboard_pasien', [
            'pasien'        => session()->get('pasien'),
            'bidan'         => $bidan,
            'isBidanOnline' => $isBidanOnline
        ]);
    }

    // Halaman Layanan Pasien
    public function layanan()
    {
        if (!$this->session->has('pasien')) {
            return redirect()->to('/login_pasien');
        }

        $pasien   = $this->session->get('pasien');
        $kategori = trim((string)$this->request->getGet('kategori'));
        $search   = trim((string)$this->request->getGet('search'));

        $builder = $this->db->table('layanan')->where('status', 'aktif');

        if (!empty($kategori) && in_array(strtolower($kategori), ['ibu', 'bayi'], true)) {
            $builder->where('LOWER(kategori)', strtolower($kategori));
        }

        if (!empty($search)) {
            $builder->groupStart()
                ->like('nama_layanan', $search)
                ->orLike('deskripsi', $search)
                ->groupEnd();
        }

        $layanan = $builder->orderBy('id', 'DESC')->get()->getResultArray();

        return view('pages/layanan', [
            'pasien'  => $pasien,
            'layanan' => $layanan,
            'aktif'   => $kategori,
            'search'  => $search
        ]);
    }

    // Halaman Layanan Publik (Daftar Layanan)
    public function daftarLayanan()
    {
        $kategori = trim((string)$this->request->getGet('kategori'));
        $search   = trim((string)$this->request->getGet('search'));

        $builder = $this->db->table('layanan')->where('status', 'aktif');

        if (!empty($kategori) && in_array(strtolower($kategori), ['ibu', 'bayi'], true)) {
            $builder->where('LOWER(kategori)', strtolower($kategori));
        }

        if (!empty($search)) {
            $builder->groupStart()
                ->like('nama_layanan', $search)
                ->orLike('deskripsi', $search)
                ->groupEnd();
        }

        $layanan = $builder->orderBy('id', 'DESC')->get()->getResultArray();

        return view('pages/daftar_layanan', [
            'layanan'  => $layanan,
            'kategori' => $kategori,
            'search'   => $search
        ]);
    }

    // Kirim Chat
    public function kirimChat()
    {
        if (!$this->session->has('pasien')) {
            return redirect()->to('/');
        }

        $id_pasien = $this->session->get('pasien')['id'];

        $total = $this->db->table('chat')
            ->where('id_pasien', $id_pasien)
            ->where('pengirim', 'user')
            ->countAllResults();

        if ($total >= 10) {
            return redirect()->to('/konsultasi')
                ->with('error', 'Batas konsultasi telah habis. Silakan lanjut melalui WhatsApp.');
        }

        $rules = [
            'pesan' => 'required|string|max_length[1000]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->to('/konsultasi')
                ->with('error', 'Pesan tidak boleh kosong dan maksimal 1000 karakter.');
        }

        $pesan = strip_tags(trim((string)$this->request->getPost('pesan')));

        $this->db->table('chat')->insert([
            'id_pasien'   => $id_pasien,
            'pesan'       => $pesan,
            'pengirim'    => 'user',
            'status'      => 'baru',
            'status_baca' => 'terkirim',
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/konsultasi')
            ->with('success', 'Pesan berhasil dikirim.');
    }

    public function simpanLayanan()
{
    return redirect()->to('/kelola_layanan');
}

public function ajukanKunjungan($id)
{
    if (!$this->session->has('pasien')) {
        return redirect()->to('/');
    }

    $pasien = $this->session->get('pasien');

    $layanan = $this->db->table('layanan')
        ->where('id', (int)$id)
        ->get()
        ->getRowArray();

    if (!$layanan) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data layanan tidak ditemukan.');
    }

    return view('pages/ajukan_kunjungan', [
        'pasien' => $pasien,
        'layanan' => $layanan
    ]);
}

public function prosesAjukanKunjungan()
{
    if (!$this->session->has('pasien')) {
        return redirect()->to('/');
    }

    $rules = [
        'layanan'             => 'required|numeric',
        'tanggal'             => 'required|valid_date',
        'jam'                 => 'required|string|max_length[10]',
        'nama'                => 'required|min_length[2]|max_length[100]',
        'usia'                => 'required|max_length[20]',
        'ortu'                => 'permit_empty|max_length[100]',
        'kategori_pendamping' => 'permit_empty|max_length[50]',
        'alamat'              => 'required|max_length[255]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->validator->listErrors());
    }

    $pasien = $this->session->get('pasien');

    $data = [
        'pasien_id'            => $pasien['id'],
        'layanan'              => (int)$this->request->getPost('layanan'),
        'tanggal'              => trim((string)$this->request->getPost('tanggal')),
        'jam'                  => trim((string)$this->request->getPost('jam')),

        'nama_pasien'          => trim((string)$this->request->getPost('nama')),
        'usia'                 => trim((string)$this->request->getPost('usia')),
        'nama_ortu'            => trim((string)$this->request->getPost('ortu')),
        'kategori_pendamping'  => trim((string)$this->request->getPost('kategori_pendamping')),
        'alamat'               => trim((string)$this->request->getPost('alamat')),

        'status'               => 'Menunggu'
    ];

    $this->db->table('kunjungan')->insert($data);

    return redirect()->to('/riwayat')
        ->with('success', 'Pengajuan kunjungan medis berhasil dikirim! Menunggu konfirmasi bidan.');
}

public function pdfKunjungan()
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $filter_tgl  = trim((string)$this->request->getGet('tgl'));
    $search_nama = trim((string)$this->request->getGet('q'));

    $builder = $this->db->table('kunjungan k')
        ->select('k.*, l.nama_layanan')
        ->join('layanan l', 'l.id = k.layanan', 'left');

    if (!empty($filter_tgl)) {
        $builder->where('k.tanggal', $filter_tgl);
    }

    if (!empty($search_nama)) {
        $builder->like('k.nama_pasien', $search_nama);
    }

    $kunjungan = $builder->orderBy('k.tanggal', 'DESC')->get()->getResultArray();

    $html = view('pages/pdf_kunjungan', [
        'kunjungan' => $kunjungan
    ]);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    $dompdf->stream('laporan_kunjungan.pdf', [
        'Attachment' => false
    ]);
    exit;
}

public function riwayat()
{
    if (!$this->session->has('pasien')) {
        return redirect()->to('/');
    }

    $pasien = $this->session->get('pasien');
    $idPasien = $pasien['id'];

    $db = \Config\Database::connect();

    $riwayat = $db->query("
        SELECT
            k.*,
            l.nama_layanan,
            (
                SELECT COUNT(*)
                FROM testimoni t
                WHERE t.kunjungan_id = k.id
            ) AS sudah_rating
        FROM kunjungan k
        LEFT JOIN layanan l ON l.id = k.layanan
        WHERE k.pasien_id = ?
        ORDER BY k.tanggal DESC
    ", [$idPasien])->getResultArray();

    $total = count($riwayat);

    $selesai = $db->table('kunjungan')
        ->where('pasien_id', $idPasien)
        ->where('status', 'Selesai')
        ->countAllResults();

    $menunggu = $db->table('kunjungan')
        ->where('pasien_id', $idPasien)
        ->where('status', 'Menunggu')
        ->countAllResults();

    return view('pages/riwayat', [
        'pasien'   => $pasien,
        'riwayat'  => $riwayat,
        'total'    => $total,
        'selesai'  => $selesai,
        'menunggu' => $menunggu
    ]);
}

public function profil()
{
    if (!session()->has('pasien')) {
        return redirect()->to('/login_pasien');
    }

    $pasienModel = new \App\Models\PasienModel();

    $id = session()->get('pasien')['id'];

    $pasien = $pasienModel->find($id);

    return view('pages/profil', [
        'pasien' => $pasien
    ]);
}

public function updateProfil()
{
    if (!session()->has('pasien')) {
        return redirect()->to('/login_pasien');
    }

    $pasienModel = new \App\Models\PasienModel();
    $id = (int)session()->get('pasien')['id'];

    $rules = [
        'nama'     => 'required|min_length[3]|max_length[100]',
        'username' => 'required|min_length[3]|max_length[50]|alpha_numeric',
        'email'    => 'required|valid_email|max_length[100]',
        'no_hp'    => 'required|numeric|min_length[10]|max_length[15]',
        'alamat'   => 'required|max_length[255]',
        'password' => [
            'rules'  => 'permit_empty|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};\':"\\\\|,.<>\/?~`]).{8,}$/]',
            'errors' => [
                'min_length'  => 'Password baru minimal harus berjumlah 8 karakter.',
                'regex_match' => 'Password baru wajib memuat kombinasi: minimal 1 huruf besar (A-Z), 1 huruf kecil (a-z), 1 angka (0-9), dan 1 simbol/karakter khusus (!@#$%^&* dll).'
            ]
        ]
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->validator->listErrors());
    }

    $data = [
        'nama'     => trim((string)$this->request->getPost('nama')),
        'username' => trim((string)$this->request->getPost('username')),
        'email'    => trim((string)$this->request->getPost('email')),
        'no_hp'    => trim((string)$this->request->getPost('no_hp')),
        'alamat'   => trim((string)$this->request->getPost('alamat')),
    ];

    // Password baru dengan Bcrypt cost factor 12
    $passwordBaru = (string)$this->request->getPost('password');
    if ($passwordBaru !== '') {
        $data['password'] = password_hash(
            $passwordBaru,
            PASSWORD_BCRYPT,
            ['cost' => 12]
        );
    }

    $fotoBase64 = $this->request->getPost('foto_base64');

    if (!empty($fotoBase64) && is_string($fotoBase64)) {
        if (preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $fotoBase64, $matches)) {
            $ext = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
            $fotoClean = preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $fotoBase64);
            $fotoClean = str_replace(' ', '+', $fotoClean);
            $decoded = base64_decode($fotoClean, true);

            if ($decoded !== false && strlen($decoded) <= 2097152) { // Maksimal 2MB
                $dir = FCPATH . 'assets/profile/';
                if (!is_dir($dir)) {
                    @mkdir($dir, 0755, true);
                }
                $namaFile = 'profil_' . bin2hex(random_bytes(8)) . '.' . $ext;
                file_put_contents($dir . $namaFile, $decoded);
                $data['foto'] = $namaFile;
            }
        }
    }

    $pasienModel->update($id, $data);

    // Ambil data terbaru
    $pasienBaru = $pasienModel->find($id);

    // Update session
    session()->set('pasien', $pasienBaru);

    return redirect()->to('/profil')
                     ->with('success', 'Profil berhasil diperbarui');
}

public function konsultasi()
{
    if (!$this->session->has('pasien')) {
        return redirect()->to('/login_pasien');
    }

    $pasien = $this->session->get('pasien');

    $chat = $this->db->table('chat')
        ->where('id_pasien', $pasien['id'])
        ->orderBy('id', 'ASC')
        ->get()
        ->getResultArray();

    // Ambil data bidan yang sedang online atau bidan utama
    $onlineBidan = $this->db->table('bidan')
        ->where('status', 'online')
        ->orderBy('last_seen', 'DESC')
        ->get()
        ->getRowArray();

    $bidan = $onlineBidan ?: $this->db->table('bidan')->orderBy('id', 'ASC')->get()->getRowArray();
    $isBidanOnline = !empty($onlineBidan);

    $total_pesan_pasien = $this->db->table('chat')
        ->where('id_pasien', $pasien['id'])
        ->where('pengirim', 'user')
        ->countAllResults();

    return view('pages/konsultasi', [
        'pasien'             => $pasien,
        'chat'               => $chat,
        'bidan'              => $bidan,
        'online_bidan'       => $isBidanOnline,
        'total_pesan_pasien' => $total_pesan_pasien,
        'limit_maksimal'     => 10
    ]);
}

public function rating()
{
    if (!$this->session->has('pasien')) {
        return redirect()->to('/');
    }

    $pasien = $this->session->get('pasien');
    $id_kunjungan = (int)$this->request->getGet('id');

    if ($id_kunjungan <= 0) {
        return redirect()->to('/riwayat')
            ->with('error', 'Parameter ID kunjungan tidak valid.');
    }

    // Strict Anti-IDOR Check: Kunjungan wajib milik pasien yang sedang login
    $kunjungan = $this->db->table('kunjungan')
        ->where('id', $id_kunjungan)
        ->where('pasien_id', $pasien['id'])
        ->get()
        ->getRowArray();

    if (!$kunjungan) {
        return redirect()->to('/riwayat')
            ->with('error', 'Akses ditolak (403 Forbidden): Data kunjungan tidak ditemukan atau bukan milik akun Anda.');
    }

    return view('pages/rating', [
        'id_kunjungan' => $id_kunjungan,
        'kunjungan'    => $kunjungan
    ]);
}

public function registerProses()
{
    $ipAddress = $this->request->getIPAddress();
    $endpoint  = 'register_proses';

    // 1. Rate Limiting: 5 Permintaan per 15 Menit (900 detik)
    $rateCheck = RateLimiter::checkEndpointRateLimit($ipAddress, $endpoint, 5, 900);
    if (!$rateCheck['allowed']) {
        return redirect()->back()
            ->withInput()
            ->with('error', $rateCheck['message']);
    }

    // 2. Server-side Input Validation dengan Strong Password Policy
    $rules = [
        'nama'     => 'required|min_length[3]|max_length[100]',
        'username' => 'required|min_length[3]|max_length[50]|alpha_numeric',
        'email'    => 'required|valid_email|max_length[100]',
        'no_hp'    => 'required|numeric|min_length[10]|max_length[15]',
        'alamat'   => 'required|max_length[255]',
        'password' => [
            'rules'  => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};\':"\\\\|,.<>\/?~`]).{8,}$/]',
            'errors' => [
                'required'    => 'Password wajib diisi.',
                'min_length'  => 'Password minimal harus berjumlah 8 karakter.',
                'regex_match' => 'Password wajib memuat kombinasi: minimal 1 huruf besar (A-Z), 1 huruf kecil (a-z), 1 angka (0-9), dan 1 simbol/karakter khusus (!@#$%^&* dll).'
            ]
        ],
        'confirm'  => [
            'rules'  => 'required|matches[password]',
            'errors' => [
                'required' => 'Konfirmasi password wajib diisi.',
                'matches'  => 'Konfirmasi password tidak cocok dengan password yang dimasukkan.'
            ]
        ]
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->validator->listErrors());
    }

    $nama      = trim((string)$this->request->getPost('nama'));
    $username  = trim((string)$this->request->getPost('username'));
    $email     = trim((string)$this->request->getPost('email'));
    $no_hp     = trim((string)$this->request->getPost('no_hp'));
    $alamat    = trim((string)$this->request->getPost('alamat'));
    $password  = (string)$this->request->getPost('password');

    $cekUser = $this->db->table('pasien')
        ->where('username', $username)
        ->get()
        ->getRowArray();

    if ($cekUser) {
        return redirect()->back()->withInput()->with('error', 'Username sudah digunakan');
    }

    $cekEmail = $this->db->table('pasien')
        ->where('email', $email)
        ->get()
        ->getRowArray();

    if ($cekEmail) {
        return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar');
    }

    // 3. Enforce Bcrypt Cost Factor 12
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

    $this->db->table('pasien')->insert([
        'nama'     => $nama,
        'username' => $username,
        'email'    => $email,
        'no_hp'    => $no_hp,
        'alamat'   => $alamat,
        'password' => $hashedPassword
    ]);

    return redirect()->to('/login_pasien')
        ->with('success', 'Registrasi berhasil. Silakan login.');
}

// ==================== BIDAN ====================

public function registerBidanForm()
{
    return view('pages/register_bidan');
}

public function registerBidan()
{
    $ipAddress = $this->request->getIPAddress();
    $endpoint  = 'register_bidan';

    // 1. Rate Limiting: 5 Permintaan per 15 Menit (900 detik)
    $rateCheck = RateLimiter::checkEndpointRateLimit($ipAddress, $endpoint, 5, 900);
    if (!$rateCheck['allowed']) {
        return redirect()->back()
            ->withInput()
            ->with('error', $rateCheck['message']);
    }

    // 2. Server-side Input Validation dengan Strong Password Policy
    $rules = [
        'nama'       => 'required|min_length[3]|max_length[100]',
        'username'   => 'required|min_length[3]|max_length[50]|alpha_numeric',
        'password'   => [
            'rules'  => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};\':"\\\\|,.<>\/?~`]).{8,}$/]',
            'errors' => [
                'required'    => 'Password wajib diisi.',
                'min_length'  => 'Password minimal harus berjumlah 8 karakter.',
                'regex_match' => 'Password wajib memuat kombinasi: minimal 1 huruf besar (A-Z), 1 huruf kecil (a-z), 1 angka (0-9), dan 1 simbol/karakter khusus (!@#$%^&* dll).'
            ]
        ],
        'konfirmasi' => [
            'rules'  => 'required|matches[password]',
            'errors' => [
                'required' => 'Konfirmasi password wajib diisi.',
                'matches'  => 'Konfirmasi password tidak cocok dengan password yang dimasukkan.'
            ]
        ]
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->validator->listErrors());
    }

    $nama       = trim((string)$this->request->getPost('nama'));
    $username   = trim((string)$this->request->getPost('username'));
    $password   = (string)$this->request->getPost('password');

    $cek = $this->db->table('bidan')
        ->where('username', $username)
        ->get()
        ->getRowArray();

    if ($cek) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Username sudah digunakan.');
    }

    // 3. Enforce Bcrypt Cost Factor 12
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

    $this->db->table('bidan')->insert([
        'nama'      => $nama,
        'username'  => $username,
        'password'  => $hashedPassword,
        'status'    => 'offline'
    ]);

    return redirect()->to('/login_bidan')
        ->with('success', 'Registrasi Bidan berhasil. Silakan login.');
}

public function loginBidanForm()
{
    // Auto-login melalui cookie "Ingat Saya" (Remember Me) jika sesi belum aktif
    if (!session()->has('bidan')) {
        $rememberToken = get_cookie('remember_token_bidan');
        if ($rememberToken) {
            try {
                $decrypted = \Config\Services::encrypter()->decrypt(base64_decode($rememberToken));
                $payload = json_decode($decrypted, true);
                if (!empty($payload['id'])) {
                    $bidan = $this->db->table('bidan')->where('id', $payload['id'])->get()->getRowArray();
                    if ($bidan) {
                        session()->set('bidan', $bidan);
                        return redirect()->to('/dashboard_bidan');
                    }
                }
            } catch (\Exception $e) {
                delete_cookie('remember_token_bidan');
            }
        }
    } else {
        return redirect()->to('/dashboard_bidan');
    }

    $captcha = $this->generateCaptcha();

    return view('pages/login_bidan', [
        'captcha' => $captcha
    ]);
}

public function prosesLoginBidan()
{
    $ipAddress = $this->request->getIPAddress();
    $endpoint  = 'login_bidan';

    // 1. Rate Limiting: 5 Permintaan per 15 Menit (900 detik)
    $rateCheck = RateLimiter::checkEndpointRateLimit($ipAddress, $endpoint, 5, 900);
    if (!$rateCheck['allowed']) {
        return redirect()->back()
            ->withInput()
            ->with('error', $rateCheck['message']);
    }

    // 2. Server-side Input Validation
    $rules = [
        'username' => 'required|min_length[3]|max_length[50]',
        'password' => 'required',
        'captcha'  => 'required'
    ];
    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Semua bidang termasuk CAPTCHA wajib diisi dengan benar.');
    }

    $username   = trim((string)$this->request->getPost('username'));
    $password   = (string)$this->request->getPost('password');
    $rememberMe = (bool)$this->request->getPost('remember_me');

    // 3. Automated Account Lockout Check (15-Minute Cooldown)
    // Dilakukan SEBELUM query database & verifikasi password untuk mencegah timing attacks & credential stuffing
    $lockCheck = RateLimiter::isAccountLocked($username, $ipAddress);
    if ($lockCheck['is_locked']) {
        return redirect()->back()
            ->withInput()
            ->with('error', $lockCheck['message']);
    }

    // 4. Validasi CAPTCHA Matematika (Single-use verification)
    $userCaptcha     = trim((string)$this->request->getPost('captcha'));
    $expectedCaptcha = (string)session()->get('captcha_answer');
    session()->remove('captcha_answer');

    if ($expectedCaptcha === '' || $userCaptcha !== $expectedCaptcha) {
        return $this->handleFailedLogin($username, $ipAddress, 'Verifikasi CAPTCHA salah atau kedaluwarsa. Silakan hitung kembali.');
    }

    // 5. Query Kredensial Bidan via Parameterized Query
    $bidan = $this->db->table('bidan')
        ->where('username', $username)
        ->get()
        ->getRowArray();

    if (!$bidan) {
        return $this->handleFailedLogin($username, $ipAddress, 'Username tidak ditemukan');
    }

    // 6. Verifikasi Password (Constant-Time Verification)
    if (!password_verify($password, $bidan['password'])) {
        return $this->handleFailedLogin($username, $ipAddress, 'Password salah');
    }

    // 7. Automatic Password Rehashing (Upgrade otomatis ke Bcrypt cost 12 jika hash lama)
    if (password_needs_rehash($bidan['password'], PASSWORD_BCRYPT, ['cost' => 12])) {
        $newHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $this->db->table('bidan')
            ->where('id', $bidan['id'])
            ->update(['password' => $newHash]);
    }

    // 8. Bersihkan State Kegagalan & Rate Limiter saat login berhasil
    RateLimiter::clearLoginState($username, $ipAddress, $endpoint);

    // 9. Mitigasi Session Fixation: Regenerasi Session ID
    session()->regenerate(true);

    // Update status menjadi online
    $this->db->table('bidan')
        ->where('id', $bidan['id'])
        ->update([
            'status'    => 'online',
            'last_seen' => date('Y-m-d H:i:s')
        ]);

    // Ambil data terbaru
    $bidan = $this->db->table('bidan')
        ->where('id', $bidan['id'])
        ->get()
        ->getRowArray();

    // Simpan Sesi Login Bidan
    session()->set('bidan', $bidan);

    // 10. Stateless JWT Token dalam HttpOnly Cookie (Strict Security)
    $jwtToken = JwtAuth::generateToken($bidan['id'], 'bidan', $bidan['username']);
    JwtAuth::setCookie($jwtToken);

    // 11. Opsi "Ingat Saya" (Remember Me) via Cookie Terenkripsi
    if ($rememberMe) {
        try {
            $payload = json_encode([
                'id'       => $bidan['id'],
                'username' => $bidan['username'],
                'time'     => time()
            ]);
            $encryptedToken = base64_encode(\Config\Services::encrypter()->encrypt($payload));

            set_cookie([
                'name'     => 'remember_token_bidan',
                'value'    => $encryptedToken,
                'expire'   => 86400 * 30, // Berlaku 30 hari
                'path'     => '/',
                'secure'   => JwtAuth::isHttps(),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Gagal enkripsi remember me bidan: ' . $e->getMessage());
        }
    } else {
        delete_cookie('remember_token_bidan');
    }

    return redirect()->to('/dashboard_bidan');
}

public function dashboardBidan()
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $db    = $this->db;
    $bidan = session()->get('bidan');

    $jPasien = $db->table('pasien')->countAllResults();

    $jKunjungan = $db->table('kunjungan')
        ->where('status', 'Menunggu')
        ->countAllResults();

    $jKonsul = $db->table('chat')->countAllResults();

    $jTesti = $db->table('testimoni')->countAllResults();

    // Rekap data kunjungan bulanan tahun berjalan (1 - 12)
    $chart = $db->query("
        SELECT MONTH(tanggal) AS bln,
               COUNT(*) AS tot
        FROM kunjungan
        WHERE YEAR(tanggal) = YEAR(CURDATE())
        GROUP BY MONTH(tanggal)
        ORDER BY bln ASC
    ")->getResultArray();

    // Inisialisasi data 12 bulan (Januari - Desember) dengan default 0
    $dataChart = array_fill(1, 12, 0);

    foreach ($chart as $r) {
        $dataChart[(int)$r['bln']] = (int)$r['tot'];
    }

    // Mengubah ke indexed array 0..11 agar saat di-encode menghasilkan format array JSON murni [val1, val2, ...]
    $dataChartValues = array_values($dataChart);

    // Jika request melalui AJAX, kembalikan response JSON
    if ($this->request->isAJAX()) {
        return $this->response->setJSON([
            'status'    => 'success',
            'tahun'     => date('Y'),
            'dataChart' => $dataChartValues
        ]);
    }

    $kunjungan_terbaru = $db->query("
        SELECT
            kunjungan.*,
            layanan.nama_layanan,
            pasien.nama as nama_pasien
        FROM kunjungan
        JOIN layanan ON kunjungan.layanan = layanan.id
        JOIN pasien ON kunjungan.pasien_id = pasien.id
        ORDER BY kunjungan.id DESC
        LIMIT 6
    ")->getResultArray();

    return view('pages/dashboard_bidan', [
        'bidan'             => $bidan,
        'jPasien'           => $jPasien,
        'jKunjungan'        => $jKunjungan,
        'jKonsul'           => $jKonsul,
        'jTesti'            => $jTesti,
        'kunjungan_terbaru' => $kunjungan_terbaru,
        'dataChart'         => json_encode($dataChartValues)
    ]);
}

public function kelolaLayanan()
{
    $db = \Config\Database::connect();

    $kategori = $this->request->getGet('kategori');
    $search   = $this->request->getGet('search');

    $builder = $db->table('layanan');

    if (!empty($kategori)) {
        $builder->where('kategori', $kategori);
    }

    if (!empty($search)) {
        $builder->like('nama_layanan', $search);
    }

    $data['layanan'] = $builder
        ->orderBy('id','DESC')
        ->get()
        ->getResultArray();

    $data['filter'] = $kategori;
    $data['search'] = $search;

    $data['total'] = $db->table('layanan')->countAllResults();

    $data['ibu'] = $db->table('layanan')
        ->where('kategori','ibu')
        ->countAllResults();

    $data['bayi'] = $db->table('layanan')
        ->where('kategori','bayi')
        ->countAllResults();

    return view('pages/kelola_layanan', $data);
}

public function tambahLayanan()
{
    $db = \Config\Database::connect();

    if ($this->request->is('post')) {

        $textRules = [
            'nama'      => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'required|string|max_length[1000]',
            'kategori'  => 'required|in_list[ibu,bayi]',
            'durasi'    => 'permit_empty|string|max_length[50]',
            'harga'     => 'permit_empty|string|max_length[50]',
            'status'    => 'permit_empty|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($textRules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $namaFile = '';

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $valGambar = [
                'gambar' => [
                    'label'  => 'Gambar Layanan',
                    'rules'  => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,2048]',
                    'errors' => [
                        'uploaded' => 'Silakan pilih berkas gambar.',
                        'is_image' => 'Berkas gambar layanan harus berupa gambar valid.',
                        'mime_in'  => 'Format gambar harus bertipe JPG, JPEG, atau PNG.',
                        'max_size' => 'Ukuran gambar maksimal 2048 KB (2 MB).'
                    ]
                ]
            ];

            if (!$this->validate($valGambar)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', $this->validator->getError('gambar'));
            }

            $namaFile = $gambar->getRandomName();
            $gambar->move(FCPATH . 'assets/layanan/', $namaFile);
        }

        $data = [
            'nama_layanan' => trim((string)$this->request->getPost('nama')),
            'deskripsi'    => trim((string)$this->request->getPost('deskripsi')),
            'kategori'     => trim((string)$this->request->getPost('kategori')),
            'durasi'       => trim((string)$this->request->getPost('durasi')),
            'harga'        => trim((string)$this->request->getPost('harga')),
            'status'       => $this->request->getPost('status') ?: 'aktif',
            'gambar'       => $namaFile
        ];

        if ($db->table('layanan')->insert($data)) {

            return redirect()->to(base_url('kelola_layanan'))
                ->with('success', 'Layanan berhasil ditambahkan');

        } else {

            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan layanan.');

        }
    }

    return view('pages/tambah_layanan');
}

public function hapusLayanan($id)
{
    $id = (int)$id;
    $db = \Config\Database::connect();

    $layanan = $db->table('layanan')
        ->where('id',$id)
        ->get()
        ->getRowArray();

    if(!$layanan){
        return redirect()->to('kelola_layanan');
    }

    if(!empty($layanan['gambar'])){

        $path = FCPATH.'assets/layanan/'.$layanan['gambar'];

        if(file_exists($path)){
            unlink($path);
        }
    }

    $db->table('layanan')
        ->where('id',$id)
        ->delete();

    return redirect()->to('kelola_layanan')
        ->with('success','Layanan berhasil dihapus');
}

public function editLayanan($id)
{
    $id = (int)$id;
    $db = \Config\Database::connect();

    if ($this->request->getMethod() == 'POST') {

        $textRules = [
            'nama'      => 'required|min_length[3]|max_length[100]',
            'deskripsi' => 'required|string|max_length[1000]',
            'kategori'  => 'required|in_list[ibu,bayi]',
            'durasi'    => 'permit_empty|string|max_length[50]',
            'harga'     => 'permit_empty|string|max_length[50]',
            'status'    => 'permit_empty|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($textRules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $layanan = $db->table('layanan')
                      ->where('id', $id)
                      ->get()
                      ->getRowArray();

        $gambarBaru = $this->request->getFile('gambar');
        $namaGambar = $layanan['gambar'];

        if ($gambarBaru && $gambarBaru->isValid() && !$gambarBaru->hasMoved()) {

            $valGambar = [
                'gambar' => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,2048]'
            ];
            if (!$this->validate($valGambar)) {
                return redirect()->back()->withInput()->with('error', $this->validator->getError('gambar'));
            }

            $namaGambar = $gambarBaru->getRandomName();

            $gambarBaru->move(FCPATH . 'assets/layanan/', $namaGambar);

            if (!empty($layanan['gambar']) &&
                file_exists(FCPATH . 'assets/layanan/' . $layanan['gambar'])) {

                unlink(FCPATH . 'assets/layanan/' . $layanan['gambar']);
            }
        }

        $db->table('layanan')
            ->where('id', $id)
            ->update([
                'nama_layanan' => trim((string)$this->request->getPost('nama')),
                'kategori'     => trim((string)$this->request->getPost('kategori')),
                'durasi'       => trim((string)$this->request->getPost('durasi')),
                'deskripsi'    => trim((string)$this->request->getPost('deskripsi')),
                'harga'        => trim((string)$this->request->getPost('harga')),
                'status'       => $this->request->getPost('status') ?: 'aktif',
                'gambar'       => $namaGambar
            ]);

        return redirect()->to(base_url('kelola_layanan'))
                         ->with('success', 'Layanan berhasil diupdate');
    }

    $data['data'] = $db->table('layanan')
                       ->where('id', $id)
                       ->get()
                       ->getRowArray();

    if (!$data['data']) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    return view('pages/edit_layanan', $data);
}

public function updateLayanan($id)
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $id = (int)$id;

    $textRules = [
        'nama'      => 'required|min_length[3]|max_length[100]',
        'deskripsi' => 'required|string|max_length[1000]',
        'kategori'  => 'required|in_list[ibu,bayi]',
        'durasi'    => 'permit_empty|string|max_length[50]',
        'harga'     => 'permit_empty|string|max_length[50]',
        'status'    => 'permit_empty|in_list[aktif,nonaktif]'
    ];

    if (!$this->validate($textRules)) {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->validator->listErrors());
    }

    $layanan = $this->db
        ->table('layanan')
        ->where('id', $id)
        ->get()
        ->getRowArray();

    if (!$layanan) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $gambar = $layanan['gambar'];

    $file = $this->request->getFile('gambar');

    if ($file && $file->isValid() && !$file->hasMoved()) {

        $valGambar = [
            'gambar' => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,2048]'
        ];
        if (!$this->validate($valGambar)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getError('gambar'));
        }

        $gambar = $file->getRandomName();

        $path = FCPATH . 'assets/layanan';

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $file->move($path, $gambar);

        if (!empty($layanan['gambar']) && file_exists(FCPATH . 'assets/layanan/' . $layanan['gambar'])) {
            @unlink(FCPATH . 'assets/layanan/' . $layanan['gambar']);
        }
    }

    $this->db->table('layanan')
        ->where('id', $id)
        ->update([
            'nama_layanan' => trim((string)$this->request->getPost('nama')),
            'deskripsi'    => trim((string)$this->request->getPost('deskripsi')),
            'kategori'     => trim((string)$this->request->getPost('kategori')),
            'durasi'       => trim((string)$this->request->getPost('durasi')),
            'harga'        => trim((string)$this->request->getPost('harga')),
            'status'       => $this->request->getPost('status') ?: 'aktif',
            'gambar'       => $gambar
        ]);

    return redirect()->to('/kelola_layanan');
}

public function updateLastSeen()
{
    if (!session()->has('bidan')) {
        return;
    }

    $id = session()->get('bidan')['id'];

    $this->db->table('bidan')
        ->where('id', $id)
        ->update([
            'last_seen' => date('Y-m-d H:i:s')
        ]);

    return $this->response->setJSON([
        'status' => 'ok'
    ]);
}

public function pasienAktif()
{
    $db = \Config\Database::connect();

    $data['pasien'] = $db->table('pasien')
        ->orderBy('nama', 'ASC')
        ->get()
        ->getResultArray();

    return view('pages/pasien_aktif', $data);
}

public function hapusPasien($id)
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $id = (int)$id;
    $db = \Config\Database::connect();

    // Hapus seluruh data berelasi agar tidak ada orphaned record
    $db->table('chat')->where('id_pasien', $id)->delete();
    $db->table('kunjungan')->where('pasien_id', $id)->delete();
    $db->table('testimoni')->where('pasien_id', $id)->delete();
    $db->table('pasien')->where('id', $id)->delete();

    return redirect()->to(site_url('pasien_aktif'))
                     ->with('success', 'Data member pasien beserta seluruh riwayatnya berhasil dihapus');
}

public function konsultasiBidan($idPasien = null)
{
if (!session()->has('bidan')) {
return redirect()->to('/login_bidan');
}
$db = \Config\Database::connect();

// =========================
// DATA DEFAULT
// =========================
$data = [
    'jPasien'     => 0,
    'jPending'    => 0,
    'jKonsul'     => 0,
    'chat_list'   => [],
    'idPasien'    => $idPasien,
    'pasien'      => null,
    'chat_detail' => []
];

// =========================
// STATISTIK
// =========================
$jPasien = $db->table('chat')
    ->select('COUNT(DISTINCT id_pasien) as total')
    ->get()
    ->getRow();

$data['jPasien'] = $jPasien ? (int)$jPasien->total : 0;

$data['jPending'] = $db->table('chat')
    ->where('pengirim', 'user')
    ->where('status_baca', 'terkirim')
    ->countAllResults();

$data['jKonsul'] = $db->table('chat')
    ->countAllResults();

// =========================
// LIST CHAT PASIEN
// =========================
$data['chat_list'] = $db->query("
    SELECT
        p.id AS id_pasien,
        p.nama,
        p.foto,
        MAX(c.created_at) AS last_time,

        (
            SELECT c2.pesan
            FROM chat c2
            WHERE c2.id_pasien = p.id
            ORDER BY c2.id DESC
            LIMIT 1
        ) AS last_chat,

        (
            SELECT COUNT(*)
            FROM chat c3
            WHERE c3.id_pasien = p.id
            AND c3.pengirim = 'user'
            AND c3.status_baca = 'terkirim'
        ) AS belum_dibaca

    FROM pasien p
    INNER JOIN chat c
        ON c.id_pasien = p.id

    GROUP BY p.id, p.nama, p.foto
    HAVING COUNT(c.id) > 0

    ORDER BY last_time DESC
")->getResultArray();

// =========================
// DETAIL CHAT
// =========================
if (!empty($idPasien)) {

    // Tandai pesan user sebagai dibaca
    $db->table('chat')
        ->where('id_pasien', $idPasien)
        ->where('pengirim', 'user')
        ->where('status_baca', 'terkirim')
        ->update([
            'status_baca' => 'dibaca'
        ]);

    // Data pasien
    $data['pasien'] = $db->table('pasien')
        ->where('id', $idPasien)
        ->get()
        ->getRowArray();

    // Detail chat
    $data['chat_detail'] = $db->table('chat')
        ->where('id_pasien', $idPasien)
        ->orderBy('id', 'ASC')
        ->get()
        ->getResultArray();

    // Jika pasien tidak ditemukan
    if (!$data['pasien']) {
        return redirect()->to('/konsultasi_bidan');
    }
}

return view('pages/konsultasi_bidan', $data);
}

public function kirimBalasan()
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $rules = [
        'id_pasien' => 'required|numeric',
        'balasan'   => 'required|string|max_length[1000]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Balasan pesan wajib diisi dan maksimal 1000 karakter.');
    }

    $db = \Config\Database::connect();

    $idPasien = (int)$this->request->getPost('id_pasien');
    $balasan  = strip_tags(trim((string)$this->request->getPost('balasan')));

    $db->table('chat')->insert([
        'id_pasien'   => $idPasien,
        'pesan'       => $balasan,
        'pengirim'    => 'bidan',
        'status'      => 'dibalas',
        'status_baca' => 'dibaca',
        'created_at'  => date('Y-m-d H:i:s')
    ]);

    return redirect()->to('/konsultasi_bidan/' . $idPasien);
}

public function hapusChat($idPasien)
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $idPasien = (int)$idPasien;
    $db = \Config\Database::connect();

    $db->table('chat')
        ->where('id_pasien', $idPasien)
        ->delete();

    return redirect()->to('/konsultasi_bidan')
        ->with('success', 'Riwayat chat berhasil dihapus');
}

public function kunjunganBidan()
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $filter_tgl  = $this->request->getGet('tgl');
    $search_nama = $this->request->getGet('q');

    $builder = $this->db->table('kunjungan k');
    $builder->select('k.*, l.nama_layanan');
    $builder->join('layanan l', 'l.id = k.layanan', 'left');

    if (!empty($filter_tgl)) {
        $builder->where('k.tanggal', $filter_tgl);
    }

    if (!empty($search_nama)) {
        $builder->like('k.nama_pasien', $search_nama);
    }

    $kunjungan = $builder
        ->orderBy('k.id', 'DESC')
        ->get()
        ->getResultArray();

    // Statistik
    $today = $this->db->table('kunjungan')
        ->where('tanggal', date('Y-m-d'))
        ->countAllResults();

    $pending = $this->db->table('kunjungan')
        ->where('status', 'Menunggu')
        ->countAllResults();

    $done = $this->db->table('kunjungan')
        ->where('status', 'Selesai')
        ->countAllResults();

    $total_kunjungan = count($kunjungan);

    return view('pages/kunjungan_bidan', [
        'kunjungan'       => $kunjungan,
        'today'           => $today,
        'pending'         => $pending,
        'done'            => $done,
        'total_kunjungan' => $total_kunjungan,
        'filter_tgl'      => $filter_tgl,
        'search_nama'     => $search_nama,
        'bidan'           => session()->get('bidan')
    ]);
}

public function aksiKunjungan($aksi, $id)
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $id     = (int)$id;
    $status = '';
    $msg    = '';

    switch ($aksi) {
        case 'approve':
            $status = 'disetujui';
            $msg    = 'Pengajuan kunjungan medis berhasil disetujui.';
            break;

        case 'done':
            $status = 'selesai';
            $msg    = 'Kunjungan medis berhasil diselesaikan.';
            break;

        case 'tolak':
            $status = 'Gagal';
            $msg    = 'Pengajuan kunjungan medis telah ditolak.';
            break;
    }

    if ($status != '') {
        $this->db->table('kunjungan')
            ->where('id', $id)
            ->update([
                'status' => $status
            ]);
    }

    return redirect()->to('/kunjungan_bidan')->with('success', $msg ?: 'Status kunjungan berhasil diperbarui.');
}

public function testimoniBidan()
{
    $db = \Config\Database::connect();

    $pending = $db->table('testimoni')
        ->where('approve', 'Menunggu')
        ->countAllResults();

    $approved = $db->table('testimoni')
        ->where('approve', 'Selesai')
        ->countAllResults();

    $total_testi = $db->table('testimoni')
        ->countAllResults();

    $testimoni = $db->table('testimoni t')
        ->select('t.*, p.nama as nama_pasien')
        ->join('pasien p', 'p.id = t.pasien_id', 'left')
        ->orderBy('t.id', 'DESC')
        ->get()
        ->getResultArray();

    return view('pages/testimoni_bidan', [
        'pending'      => $pending,
        'approved'     => $approved,
        'total_testi'  => $total_testi,
        'testimoni'    => $testimoni
    ]);
}

public function simpanRating()
{
    $db = \Config\Database::connect();
    $pasien = session()->get('pasien');

    if (!$pasien) {
        return redirect()->to('/login_pasien');
    }

    $rules = [
        'kunjungan_id' => 'required|numeric',
        'rating'       => 'required|in_list[1,2,3,4,5]',
        'ulasan'       => 'required|string|max_length[1000]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->validator->listErrors());
    }

    $kunjungan_id = (int)$this->request->getPost('kunjungan_id');

    // Cek apakah sudah pernah memberi rating
    $cek = $db->table('testimoni')
              ->where('kunjungan_id', $kunjungan_id)
              ->countAllResults();

    if ($cek > 0) {
        return redirect()->to('/riwayat')
                         ->with('error', 'Kunjungan ini sudah pernah diberi rating.');
    }

    // Ambil data kunjungan
    $kunjungan = $db->table('kunjungan k')
        ->select('k.*, l.nama_layanan')
        ->join('layanan l', 'l.id = k.layanan', 'left')
        ->where('k.id', $kunjungan_id)
        ->get()
        ->getRowArray();

    if (!$kunjungan) {
        return redirect()->to('/riwayat')
            ->with('error', 'Data kunjungan tidak ditemukan.');
    }

    // Otorisasi: cegah Horizontal Privilege Escalation
    if ((int)$kunjungan['pasien_id'] !== (int)$pasien['id']) {
        return redirect()->to('/riwayat')
            ->with('error', 'Akses ditolak: Anda hanya dapat memberi rating pada kunjungan medis Anda sendiri.');
    }

    $namaFoto = '';
    $foto = $this->request->getFile('foto');
    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        // Validasi ketat keamanan upload berkas bukti foto medis/ulasan
        $validationRules = [
            'foto' => [
                'label'  => 'Foto Bukti / Ulasan',
                'rules'  => 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
                'errors' => [
                    'uploaded' => 'Silakan pilih berkas foto untuk diunggah.',
                    'is_image' => 'Berkas yang diunggah harus berupa gambar yang valid.',
                    'mime_in'  => 'Format foto harus bertipe JPG, JPEG, atau PNG.',
                    'max_size' => 'Ukuran file foto maksimal 2048 KB (2 MB).'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getError('foto'));
        }

        $folder = FCPATH . 'assets/testimoni/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // Generate nama file acak aman untuk mencegah serangan penamaan & collision
        $namaFoto = $foto->getRandomName();
        $foto->move($folder, $namaFoto);
    }

    $ulasan = strip_tags(trim((string)$this->request->getPost('ulasan')));

    $data = [
        'pasien_id'    => $pasien['id'],
        'kunjungan_id' => $kunjungan_id,
        'rating'       => (int)$this->request->getPost('rating'),
        'ulasan'       => $ulasan,
        'pesan'        => $ulasan,
        'nama_layanan' => $kunjungan['nama_layanan'],
        'foto'         => $namaFoto,
        'approve'      => 'Menunggu',
        'created_at'   => date('Y-m-d H:i:s')
    ];

    $db->table('testimoni')->insert($data);
    return redirect()->to('/riwayat')
                     ->with('success', 'Terima kasih, rating berhasil dikirim.');
}

public function publishTestimoni($id)
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $id = (int)$id;
    $db = \Config\Database::connect();

    $db->table('testimoni')
        ->where('id', $id)
        ->update([
            'approve' => 'Selesai'
        ]);

    return redirect()->to('/testimoni_bidan')
        ->with('success', 'Testimoni berhasil dipublikasikan ke beranda utama.');
}

public function unpublishTestimoni($id)
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $id = (int)$id;
    $db = \Config\Database::connect();

    $db->table('testimoni')
        ->where('id', $id)
        ->update([
            'approve' => 'Menunggu'
        ]);

    return redirect()->to('/testimoni_bidan')
        ->with('success', 'Testimoni berhasil ditarik kembali ke status validasi.');
}

public function hapusTestimoni($id)
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $id = (int)$id;
    $db = \Config\Database::connect();

    $testi = $db->table('testimoni')->where('id', $id)->get()->getRowArray();
    if ($testi) {
        if (!empty($testi['foto'])) {
            $path = FCPATH . 'assets/testimoni/' . $testi['foto'];
            if (file_exists($path)) {
                @unlink($path);
            }
        }
        $db->table('testimoni')->where('id', $id)->delete();
    }

    return redirect()->to('/testimoni_bidan')
        ->with('success', 'Testimoni berhasil dihapus secara permanen.');
}

public function editProfilBidan()
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $bidanModel  = new BidanModel();
    $galeriModel = new GaleriBerandaModel();

    $bidan = session()->get('bidan');

    $data = [
        'bidan' => $bidanModel->find($bidan['id']),
        'galeri' => $galeriModel
            ->orderBy('id', 'DESC')
            ->findAll()
    ];

    return view('pages/edit_profil_bidan', $data);
}

public function tambahGaleri()
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $rules = [
        'judul_galeri' => 'required|string|max_length[100]',
        'tipe'         => 'required|in_list[foto,video]',
        'galeri'       => 'uploaded[galeri]|mime_in[galeri,image/jpg,image/jpeg,image/png,image/webp,video/mp4]|max_size[galeri,15360]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->to('/edit_profil_bidan')
            ->with('error', $this->validator->listErrors());
    }

    $galeriModel = new GaleriBerandaModel();
    $file = $this->request->getFile('galeri');

    if (!$file || !$file->isValid()) {
        return redirect()->to('/edit_profil_bidan')
            ->with('error', 'File tidak valid.');
    }

    $namaFile = $file->getRandomName();

    $sliderDir = FCPATH . 'assets/slider/';
    if (!is_dir($sliderDir)) {
        mkdir($sliderDir, 0755, true);
    }

    $file->move($sliderDir, $namaFile);

    $galeriModel->insert([
        'tipe'      => $this->request->getPost('tipe'),
        'file_name' => $namaFile,
        'judul'     => trim((string)$this->request->getPost('judul_galeri')),
        'urutan'    => 0
    ]);

    return redirect()->to('/edit_profil_bidan')
                     ->with('success', 'galeri_add');
}

public function hapusGaleri($id)
{
    $id = (int)$id;
    $galeriModel = new GaleriBerandaModel();

    $galeri = $galeriModel->find($id);

    if ($galeri) {

        $path = FCPATH . 'assets/slider/' . $galeri['file_name'];

        if (file_exists($path)) {
            unlink($path);
        }

        $galeriModel->delete($id);
    }

    return redirect()->to('/edit_profil_bidan');
}

public function updateProfilBidan()
{
    if (!session()->has('bidan')) {
        return redirect()->to('/login_bidan');
    }

    $bidanModel = new \App\Models\BidanModel();

    $bidan = session()->get('bidan');
    $id = $bidan['id'];

    $bidanLama = $bidanModel->find($id);

    $rules = [
        'nama'      => 'required|min_length[3]|max_length[100]',
        'username'  => 'required|min_length[3]|max_length[50]|alpha_numeric',
        'email'     => 'required|valid_email|max_length[100]',
        'whatsapp'  => 'required|numeric|min_length[10]|max_length[15]',
        'password'  => [
            'rules'  => 'permit_empty|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};\':"\\\\|,.<>\/?~`]).{8,}$/]',
            'errors' => [
                'min_length'  => 'Password baru minimal harus berjumlah 8 karakter.',
                'regex_match' => 'Password baru wajib memuat kombinasi: minimal 1 huruf besar (A-Z), 1 huruf kecil (a-z), 1 angka (0-9), dan 1 simbol/karakter khusus (!@#$%^&* dll).'
            ]
        ]
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->validator->listErrors());
    }

    $dataUpdate = [
        'nama'              => trim((string)$this->request->getPost('nama')),
        'username'          => trim((string)$this->request->getPost('username')),
        'email'             => trim((string)$this->request->getPost('email')),
        'whatsapp'          => trim((string)$this->request->getPost('whatsapp')),
        'spesialis'         => trim((string)$this->request->getPost('spesialis')),
        'instagram'         => trim((string)$this->request->getPost('instagram')),
        'facebook'          => trim((string)$this->request->getPost('facebook')),
        'tiktok'            => trim((string)$this->request->getPost('tiktok')),
        'alamat'            => trim((string)$this->request->getPost('alamat')),
        'tentang'           => trim((string)$this->request->getPost('tentang')),
        'hero_judul'        => trim((string)$this->request->getPost('hero_judul')),
        'hero_subjudul'     => trim((string)$this->request->getPost('hero_subjudul')),
        'deskripsi_beranda' => trim((string)$this->request->getPost('deskripsi_beranda'))
    ];

    if (!empty($this->request->getPost('password'))) {
        $dataUpdate['password'] = password_hash(
            (string)$this->request->getPost('password'),
            PASSWORD_BCRYPT,
            ['cost' => 12]
        );
    }

    $path = FCPATH . 'assets/profile/';

    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    $foto = $this->request->getFile('foto');

    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        // Validasi ketat foto profil bidan
        $valFoto = [
            'foto' => [
                'label'  => 'Foto Profil Bidan',
                'rules'  => 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
                'errors' => [
                    'uploaded' => 'Silakan pilih berkas foto profil.',
                    'is_image' => 'Berkas harus berupa gambar valid.',
                    'mime_in'  => 'Format foto harus bertipe JPG, JPEG, atau PNG.',
                    'max_size' => 'Ukuran foto maksimal 2048 KB (2 MB).'
                ]
            ]
        ];

        if (!$this->validate($valFoto)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getError('foto'));
        }

        if (
            !empty($bidanLama['foto']) &&
            $bidanLama['foto'] != 'default.png'
        ) {

            $oldFile = $path . $bidanLama['foto'];

            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $namaFoto = $foto->getRandomName();

        $foto->move($path, $namaFoto);

        $dataUpdate['foto'] = $namaFoto;
    }

    $fotoTentang = $this->request->getFile('foto_tentang');

    if ($fotoTentang && $fotoTentang->isValid() && !$fotoTentang->hasMoved()) {
        // Validasi ketat foto banner klinik
        $valBanner = [
            'foto_tentang' => [
                'label'  => 'Banner Tentang Klinik',
                'rules'  => 'uploaded[foto_tentang]|is_image[foto_tentang]|mime_in[foto_tentang,image/jpg,image/jpeg,image/png]|max_size[foto_tentang,2048]',
                'errors' => [
                    'uploaded' => 'Silakan pilih berkas banner.',
                    'is_image' => 'Berkas banner harus berupa gambar valid.',
                    'mime_in'  => 'Format banner harus bertipe JPG, JPEG, atau PNG.',
                    'max_size' => 'Ukuran banner maksimal 2048 KB (2 MB).'
                ]
            ]
        ];

        if (!$this->validate($valBanner)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->getError('foto_tentang'));
        }

        if (!empty($bidanLama['foto_tentang'])) {

            $oldBanner = $path . $bidanLama['foto_tentang'];

            if (file_exists($oldBanner)) {
                unlink($oldBanner);
            }
        }

        $namaBanner = $fotoTentang->getRandomName();

        $fotoTentang->move($path, $namaBanner);

        $dataUpdate['foto_tentang'] = $namaBanner;
    }

$bidanModel->update($id, $dataUpdate);

$bidanBaru = $bidanModel->find($id);

session()->set('bidan', $bidanBaru);

return redirect()->to('/edit_profil_bidan')
    ->with('success', 'Profil berhasil diperbarui');
}

public function logoutBidan()
{
    helper('cookie');
    delete_cookie('remember_token_bidan');
    JwtAuth::clearCookie();

    if (session()->has('bidan')) {
        $bidan = session()->get('bidan');
        $id = $bidan['id'] ?? null;
        $username = $bidan['username'] ?? 'unknown';

        if ($id) {
            $this->db->table('bidan')
                ->where('id', $id)
                ->update([
                    'status'    => 'offline',
                    'last_seen' => date('Y-m-d H:i:s')
                ]);
        }

        log_message('info', "[SECURITY] Bidan logout: username='{$username}', id='{$id}', IP=" . $this->request->getIPAddress());
    }

    session()->destroy();

    return redirect()->to('/login_bidan')->with('success', 'Anda telah berhasil keluar dari akun Bidan.');
}

// Hapus Akun Pasien Permanen
public function hapusAkun()
{
    if (!session()->has('pasien')) {
        return redirect()->to('/login_pasien');
    }

    $id = (int)session()->get('pasien')['id'];

    // Hapus data relasi pasien
    $this->db->table('chat')->where('id_pasien', $id)->delete();
    $this->db->table('kunjungan')->where('pasien_id', $id)->delete();
    $this->db->table('testimoni')->where('pasien_id', $id)->delete();
    $this->db->table('pasien')->where('id', $id)->delete();

    // Hapus sesi & cookies
    helper('cookie');
    delete_cookie('remember_token_pasien');
    JwtAuth::clearCookie();
    $this->session->destroy();

    return redirect()->to('/')->with('success', 'Akun Anda beserta seluruh riwayat telah berhasil dihapus secara permanen.');
}

// Logout Universal (Pasien & Bidan)
public function logout()
{
    helper('cookie');

    if (session()->has('bidan')) {
        $bidan = session()->get('bidan');
        $id = $bidan['id'] ?? null;
        $username = $bidan['username'] ?? 'unknown';

        if ($id) {
            $this->db->table('bidan')
                ->where('id', $id)
                ->update([
                    'status'    => 'offline',
                    'last_seen' => date('Y-m-d H:i:s')
                ]);
        }

        log_message('info', "[SECURITY] Bidan logout via /logout: username='{$username}', id='{$id}', IP=" . $this->request->getIPAddress());
    }

    if (session()->has('pasien')) {
        $pasien = session()->get('pasien');
        $username = $pasien['username'] ?? 'unknown';
        $id = $pasien['id'] ?? null;
        log_message('info', "[SECURITY] Pasien logout: username='{$username}', id='{$id}', IP=" . $this->request->getIPAddress());
    }

    delete_cookie('remember_token_pasien');
    delete_cookie('remember_token_bidan');
    JwtAuth::clearCookie();

    $this->session->destroy();

    return redirect()->to('/')->with('success', 'Anda telah berhasil keluar dari akun.');
}
}