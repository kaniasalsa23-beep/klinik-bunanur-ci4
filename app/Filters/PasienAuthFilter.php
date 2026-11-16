<?php

namespace App\Filters;

use App\Libraries\JwtAuth;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;

/**
 * Enterprise Pasien RBAC Filter
 *
 * Validates dual-layer authentication (Active Session + Signed JWT HttpOnly Cookie).
 * Prevents vertical & horizontal privilege escalation from unauthorized roles (e.g. Bidan accessing Pasien routes).
 */
class PasienAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // 1. Deteksi konflik wewenang (Bidan mencoba masuk ke area Pasien)
        if ($session->has('bidan') && !$session->has('pasien')) {
            $bidanUser = $session->get('bidan')['username'] ?? 'unknown';
            $bidanId   = $session->get('bidan')['id'] ?? 'unknown';
            $ip        = $request->getIPAddress();
            $path      = $request->getUri()->getPath();

            log_message('warning', "[SECURITY RBAC] Bidan attempted to access Pasien route '{$path}': bidan_id='{$bidanId}', username='{$bidanUser}', IP='{$ip}'");

            return redirect()->to('/dashboard_bidan')
                ->with('error', 'Anda sedang login dengan akun Bidan. Halaman ini khusus untuk Pasien.');
        }

        // 2. Jika sesi pasien aktif
        if ($session->has('pasien')) {
            $pasien = $session->get('pasien');
            $jwtPayload = JwtAuth::getAuthUser();

            // Jika token JWT ada di cookie, validasi keselarasan role & identity
            if ($jwtPayload !== null) {
                if ($jwtPayload['role'] !== 'pasien' || (string)$jwtPayload['sub'] !== (string)$pasien['id']) {
                    log_message('warning', "[SECURITY RBAC INTEGRITY] Session and JWT role mismatch for Pasien route: pasien_id='{$pasien['id']}', IP=" . $request->getIPAddress());
                    // Deteksi anomali token manipulasi
                    $session->remove('pasien');
                    JwtAuth::clearCookie();
                    return redirect()->to('/login_pasien')
                        ->with('error', 'Integritas sesi JWT tidak cocok. Demi keamanan, silakan login kembali.');
                }
            } else {
                // Sesi aktif tetapi cookie JWT hilang/expired: segarkan JWT cookie otomatis
                $token = JwtAuth::generateToken($pasien['id'], 'pasien', $pasien['username'] ?? 'pasien');
                JwtAuth::setCookie($token);
            }

            return null;
        }

        // 3. Sesi tidak aktif: periksa keberadaan JWT token valid (Stateless recovery)
        $jwtPayload = JwtAuth::getAuthUser();
        if ($jwtPayload !== null && ($jwtPayload['role'] ?? '') === 'pasien') {
            $db = Database::connect();
            $pasien = $db->table('pasien')
                ->where('id', $jwtPayload['sub'])
                ->get()
                ->getRowArray();

            if ($pasien) {
                // Pulihkan sesi
                $session->set('pasien', [
                    'id'       => $pasien['id'],
                    'nama'     => $pasien['nama'],
                    'username' => $pasien['username'],
                    'email'    => $pasien['email'],
                    'foto'     => $pasien['foto']
                ]);
                $session->set('chat_limit', 5);
                return null;
            }

            JwtAuth::clearCookie();
        }

        // 4. Tidak terotentikasi sama sekali
        log_message('notice', "[SECURITY RBAC UNAUTHORIZED] Unauthenticated access to Pasien route '{$request->getUri()->getPath()}': IP=" . $request->getIPAddress());

        return redirect()->to('/login_pasien')
            ->with('error', 'Silakan login terlebih dahulu untuk mengakses layanan klinik.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }
}

