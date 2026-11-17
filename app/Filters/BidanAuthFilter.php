<?php

namespace App\Filters;

use App\Libraries\JwtAuth;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Config\Services;

/**
 * Enterprise Bidan RBAC Filter
 *
 * Validates dual-layer authentication (Active Session + Signed JWT HttpOnly Cookie).
 * Strictly prevents vertical privilege escalation (Pasien trying to access Bidan administrative controls).
 */
class BidanAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // 1. Deteksi Eskalasi Wewenang Vertikal (Pasien mencoba masuk ke Dashboard Bidan)
        if ($session->has('pasien') && !$session->has('bidan')) {
            $pasienUser = $session->get('pasien')['username'] ?? 'unknown';
            $pasienId   = $session->get('pasien')['id'] ?? 'unknown';
            $ip         = $request->getIPAddress();
            $path       = $request->getUri()->getPath();

            log_message('warning', "[SECURITY RBAC VIOLATION] Unauthorized vertical privilege escalation attempt to Bidan route '{$path}': pasien_id='{$pasienId}', username='{$pasienUser}', IP='{$ip}'");

            if ($request->isAJAX()) {
                return Services::response()
                    ->setStatusCode(403)
                    ->setJSON(['error' => 'Akses ditolak (403 Forbidden): Hak akses Bidan diperlukan.']);
            }

            return redirect()->to('/dashboard_pasien')
                ->with('error', 'Akses ditolak (403 Forbidden): Akun Pasien tidak memiliki wewenang untuk mengakses halaman administratif Bidan.');
        }

        // 2. Jika sesi bidan aktif
        if ($session->has('bidan')) {
            $bidan = $session->get('bidan');
            $jwtPayload = JwtAuth::getAuthUser();

            // Validasi keselarasan token JWT di cookie
            if ($jwtPayload !== null) {
                if ($jwtPayload['role'] !== 'bidan' || (string)$jwtPayload['sub'] !== (string)$bidan['id']) {
                    log_message('warning', "[SECURITY RBAC INTEGRITY] Session and JWT role mismatch for Bidan route: bidan_id='{$bidan['id']}', IP=" . $request->getIPAddress());
                    $session->remove('bidan');
                    JwtAuth::clearCookie();
                    return redirect()->to('/login_bidan')
                        ->with('error', 'Integritas sesi Bidan tidak cocok. Demi keamanan, silakan login kembali.');
                }
            } else {
                // Segarkan JWT cookie otomatis jika sesi aktif
                $token = JwtAuth::generateToken($bidan['id'], 'bidan', $bidan['username'] ?? 'bidan');
                JwtAuth::setCookie($token);
            }

            // Validasi keberadaan akun aktif di Database (Anti-IDOR & Privilege Escalation Guard)
            $db = Database::connect();
            $checkActive = $db->table('bidan')->where('id', $bidan['id'])->get()->getRowArray();
            if (!$checkActive) {
                log_message('warning', "[SECURITY RBAC] Stale/deleted Bidan session detected: bidan_id='{$bidan['id']}', IP=" . $request->getIPAddress());
                $session->remove('bidan');
                $session->remove('id_bidan');
                $session->remove('role');
                JwtAuth::clearCookie();
                return redirect()->to('/login_bidan')
                    ->with('error', 'Akun Bidan tidak ditemukan atau telah dicabut wewenangnya.');
            }

            return null;
        }

        // 3. Sesi tidak aktif: periksa keberadaan JWT token valid (Stateless recovery)
        $jwtPayload = JwtAuth::getAuthUser();
        if ($jwtPayload !== null && ($jwtPayload['role'] ?? '') === 'bidan') {
            $db = Database::connect();
            $bidan = $db->table('bidan')
                ->where('id', $jwtPayload['sub'])
                ->get()
                ->getRowArray();

            if ($bidan) {
                $session->set('bidan', $bidan);
                return null;
            }

            JwtAuth::clearCookie();
        }

        // 4. Tidak terotentikasi sama sekali
        log_message('notice', "[SECURITY RBAC UNAUTHORIZED] Unauthenticated access to Bidan route '{$request->getUri()->getPath()}': IP=" . $request->getIPAddress());

        if ($request->isAJAX()) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['error' => 'Sesi Bidan telah berakhir. Silakan login kembali.']);
        }

        return redirect()->to('/login_bidan')
            ->with('error', 'Silakan login sebagai Bidan untuk mengakses portal ini.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }
}

