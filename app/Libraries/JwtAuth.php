<?php

namespace App\Libraries;

use Config\Encryption;

/**
 * Enterprise Stateless JWT Helper
 * 
 * Implements cryptographically secure HMAC-SHA256 (HS256) JWTs stored strictly
 * in hardened HttpOnly SameSite=Lax cookies with automatic HTTPS detection.
 */
class JwtAuth
{
    public const COOKIE_NAME = 'auth_token';
    public const DEFAULT_TTL = 7200; // 2 Jam (7200 detik)

    /**
     * Mengambil cryptographic secret key dari konfigurasi Encryption CI4.
     */
    private static function getSecretKey(): string
    {
        // Prioritaskan JWT_SECRET dari .env
        $rawKey = env('JWT_SECRET', '');

        // Fallback ke Encryption key dari CI4
        if (empty($rawKey)) {
            $config = config(Encryption::class);
            $rawKey = $config->key ?? '';
        }

        if (str_starts_with($rawKey, 'hex2bin:')) {
            $bin = @hex2bin(substr($rawKey, 8));
            if ($bin !== false && strlen($bin) > 0) {
                return $bin;
            }
        }

        if (!empty($rawKey)) {
            return hash('sha256', $rawKey, true);
        }

        // Fallback salt jika encryption key belum terpasang
        return hash('sha256', 'Klinik-Bunanur-Enterprise-AppSec-Secret-2026', true);
    }

    /**
     * Standard URL-safe Base64 Encoding (RFC 7515).
     */
    public static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Standard URL-safe Base64 Decoding.
     */
    public static function base64UrlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return (string)base64_decode(strtr($data, '-_', '+/'), true);
    }

    /**
     * Menghasilkan JWT bertanda tangan HMAC-SHA256
     * Payload: ['sub' => $userId, 'role' => $role, 'username' => $username, 'iat' => time(), 'exp' => ..., 'jti' => ...]
     */
    public static function generateToken(int|string $sub, string $role, string $username, int $ttl = self::DEFAULT_TTL): string
    {
        $header = self::base64UrlEncode(json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256'
        ], JSON_UNESCAPED_SLASHES));

        $now = time();
        $payload = self::base64UrlEncode(json_encode([
            'sub'      => (string)$sub,
            'role'     => $role,
            'username' => $username,
            'iat'      => $now,
            'exp'      => $now + $ttl,
            'jti'      => bin2hex(random_bytes(16))
        ], JSON_UNESCAPED_SLASHES));

        $signatureRaw = hash_hmac('sha256', "{$header}.{$payload}", self::getSecretKey(), true);
        $signature = self::base64UrlEncode($signatureRaw);

        return "{$header}.{$payload}.{$signature}";
    }

    /**
     * Memverifikasi JWT secara konstan (Constant-Time Verification) & validasi kedaluwarsa.
     * Mengembalikan payload jika valid, atau null jika gagal.
     */
    public static function verifyToken(?string $token): ?array
    {
        if (empty($token) || !is_string($token)) {
            return null;
        }

        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }

        [$headerB64, $payloadB64, $sigB64] = $parts;

        // Hitung signature yang diharapkan
        $expectedSigRaw = hash_hmac('sha256', "{$headerB64}.{$payloadB64}", self::getSecretKey(), true);
        $providedSigRaw = self::base64UrlDecode($sigB64);

        // Constant-time comparison untuk mencegah timing attack
        if (!hash_equals($expectedSigRaw, $providedSigRaw)) {
            return null;
        }

        $headerJson = self::base64UrlDecode($headerB64);
        $header = json_decode($headerJson, true);
        if (!is_array($header) || ($header['alg'] ?? '') !== 'HS256') {
            return null;
        }

        $payloadJson = self::base64UrlDecode($payloadB64);
        $payload = json_decode($payloadJson, true);
        if (!is_array($payload)) {
            return null;
        }

        // Cek apakah token sudah expired
        $now = time();
        if (isset($payload['exp']) && $payload['exp'] < $now) {
            return null;
        }

        // Cek keberadaan sub & role
        if (empty($payload['sub']) || empty($payload['role'])) {
            return null;
        }

        return $payload;
    }

    /**
     * Deteksi apakah request berjalan melalui koneksi aman HTTPS.
     */
    public static function isHttps(): bool
    {
        if (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) === 'on' || $_SERVER['HTTPS'] === '1')) {
            return true;
        }
        if (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443) {
            return true;
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
            return true;
        }
        return false;
    }

    /**
     * Menyimpan token JWT ke dalam HttpOnly Cookie yang dikeraskan.
     */
    public static function setCookie(string $token, int $ttl = self::DEFAULT_TTL): void
    {
        helper('cookie');

        set_cookie([
            'name'     => self::COOKIE_NAME,
            'value'    => $token,
            'expire'   => $ttl,
            'path'     => '/',
            'domain'   => '',
            'secure'   => self::isHttps(),
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    /**
     * Menghapus cookie JWT secara menyeluruh saat logout.
     */
    public static function clearCookie(): void
    {
        helper('cookie');
        delete_cookie(self::COOKIE_NAME, '', '/');

        // Penghapusan eksplisit header cookie lintas peramban
        if (!headers_sent()) {
            setcookie(self::COOKIE_NAME, '', [
                'expires'  => time() - 3600,
                'path'     => '/',
                'domain'   => '',
                'secure'   => self::isHttps(),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
        }
    }

    /**
     * Mengambil dan memvalidasi JWT dari cookie saat ini.
     */
    public static function getAuthUser(): ?array
    {
        helper('cookie');
        $token = get_cookie(self::COOKIE_NAME);
        if (!$token) {
            return null;
        }

        return self::verifyToken($token);
    }
}

