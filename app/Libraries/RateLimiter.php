<?php

namespace App\Libraries;

use Config\Services;

/**
 * Enterprise Rate Limiter & Automated Account Lockout Service
 *
 * Implements:
 * 1. Fixed-window rate limiting per (IP + Endpoint) with 5 requests / 15 minutes (900s).
 * 2. Consecutive failed login tracker per (Identifier + IP) triggering a 15-minute (900s) Account Lockout on 5th failure.
 * 3. Pre-emptive lockout validation before database queries to mitigate credential stuffing & timing attacks.
 * 4. Automatic cache cleanup on successful login.
 */
class RateLimiter
{
    public const MAX_ATTEMPTS = 5;
    public const WINDOW_SECONDS = 900; // 15 Menit = 900 Detik
    public const LOCKOUT_SECONDS = 900; // 15 Menit = 900 Detik

    /**
     * Memeriksa rate limiting per IP + Endpoint.
     * Return: [
     *   'allowed'   => bool,
     *   'remaining' => int,
     *   'cooldown'  => int (detik tersisa jika diblokir)
     * ]
     */
    public static function checkEndpointRateLimit(string $ip, string $endpoint, int $max = self::MAX_ATTEMPTS, int $window = self::WINDOW_SECONDS): array
    {
        $cache = Services::cache();
        $key = 'rl_' . hash('sha256', $ip . '|' . $endpoint);

        $data = $cache->get($key);
        $now = time();

        if (is_array($data) && isset($data['count'], $data['expire_at'])) {
            if ($data['expire_at'] > $now) {
                $cooldown = $data['expire_at'] - $now;

                if ($data['count'] >= $max) {
                    log_message('warning', "[SECURITY RATE LIMIT] Rate limit exceeded on endpoint '{$endpoint}': IP='{$ip}', cooldown={$cooldown}s");
                    return [
                        'allowed'   => false,
                        'remaining' => 0,
                        'cooldown'  => $cooldown,
                        'message'   => "Terlalu banyak permintaan pada endpoint ini. Silakan tunggu " . self::formatTime($cooldown) . " sebelum mencoba kembali."
                    ];
                }

                $data['count']++;
                $cache->save($key, $data, $cooldown);

                return [
                    'allowed'   => true,
                    'remaining' => max(0, $max - $data['count']),
                    'cooldown'  => 0,
                    'message'   => ''
                ];
            }
        }

        // Rekor baru
        $cache->save($key, [
            'count'     => 1,
            'expire_at' => $now + $window
        ], $window);

        return [
            'allowed'   => true,
            'remaining' => $max - 1,
            'cooldown'  => 0,
            'message'   => ''
        ];
    }

    /**
     * Pengecekan awal apakah akun sedang dalam masa penguncian (Lockout).
     * Wajib dipanggil SEBELUM menjalankan verifikasi password database!
     * Return: [
     *   'is_locked'         => bool,
     *   'remaining_seconds' => int,
     *   'message'           => string
     * ]
     */
    public static function isAccountLocked(string $identifier, string $ip): array
    {
        $cache = Services::cache();
        $lockKey = 'account_lock_' . hash('sha256', strtolower(trim($identifier)) . '|' . $ip);

        $lockData = $cache->get($lockKey);
        $now = time();

        if (is_array($lockData) && isset($lockData['unlock_at'])) {
            if ($lockData['unlock_at'] > $now) {
                $remaining = $lockData['unlock_at'] - $now;
                log_message('warning', "[SECURITY BLOCKED] Login rejected by active Account Lockout: identifier='{$identifier}', IP='{$ip}', remaining={$remaining}s");
                return [
                    'is_locked'         => true,
                    'remaining_seconds' => $remaining,
                    'message'           => "Akun ini terkunci sementara demi keamanan karena terdeteksi 5 kali kegagalan login berturut-turut. Silakan tunggu " . self::formatTime($remaining) . " sebelum mencoba kembali."
                ];
            } else {
                // Lockout sudah berakhir
                $cache->delete($lockKey);
            }
        }

        return [
            'is_locked'         => false,
            'remaining_seconds' => 0,
            'message'           => ''
        ];
    }

    /**
     * Mencatat percobaan login yang gagal dan memicu Lockout pada kegagalan ke-5.
     * Return: [
     *   'is_locked'          => bool,
     *   'remaining_attempts' => int,
     *   'remaining_seconds'  => int,
     *   'message'            => string
     * ]
     */
    public static function recordFailedLogin(
        string $identifier,
        string $ip,
        string $baseErrorMessage = 'Username atau Password salah.',
        int $maxFails = self::MAX_ATTEMPTS,
        int $lockoutSeconds = self::LOCKOUT_SECONDS
    ): array {
        $cache = Services::cache();
        $cleanId = strtolower(trim($identifier));
        $hash = hash('sha256', $cleanId . '|' . $ip);

        $failKey = 'login_fail_' . $hash;
        $lockKey = 'account_lock_' . $hash;

        $fails = (int)$cache->get($failKey);
        $fails++;

        if ($fails >= $maxFails) {
            // Aktifkan Lockout selama 15 menit
            $unlockAt = time() + $lockoutSeconds;
            $cache->save($lockKey, ['unlock_at' => $unlockAt], $lockoutSeconds);
            $cache->delete($failKey);

            log_message('warning', "[SECURITY LOCKOUT TRIGGERED] Account locked due to 5 consecutive failures: identifier='{$cleanId}', IP='{$ip}', lockout={$lockoutSeconds}s");

            return [
                'is_locked'          => true,
                'remaining_attempts' => 0,
                'remaining_seconds'  => $lockoutSeconds,
                'message'            => "Batas percobaan terlampaui (5 kali gagal). Demi keamanan, akun terkunci selama " . self::formatTime($lockoutSeconds) . "."
            ];
        }

        // Simpan jumlah kegagalan dengan TTL sama dengan jendela lockout (900 detik)
        $cache->save($failKey, $fails, $lockoutSeconds);
        $sisa = $maxFails - $fails;

        log_message('warning', "[SECURITY LOGIN FAILURE] Failed login attempt: identifier='{$cleanId}', IP='{$ip}', failCount={$fails}/{$maxFails}, reason='{$baseErrorMessage}'");

        return [
            'is_locked'          => false,
            'remaining_attempts' => $sisa,
            'remaining_seconds'  => 0,
            'message'            => "{$baseErrorMessage} (Peringatan: Sisa kesempatan login: {$sisa} kali sebelum akun dikunci 15 menit)."
        ];
    }

    /**
     * Membersihkan seluruh state kegagalan login dan rate limiter setelah login berhasil.
     */
    public static function clearLoginState(string $identifier, string $ip, string $endpoint): void
    {
        $cache = Services::cache();
        $cleanId = strtolower(trim($identifier));
        $hash = hash('sha256', $cleanId . '|' . $ip);

        $cache->delete('login_fail_' . $hash);
        $cache->delete('account_lock_' . $hash);
        $cache->delete('rl_' . hash('sha256', $ip . '|' . $endpoint));
    }

    /**
     * Format detik menjadi format human-friendly dalam bahasa Indonesia.
     */
    public static function formatTime(int $seconds): string
    {
        if ($seconds < 60) {
            return "{$seconds} detik";
        }

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        if ($remainingSeconds === 0) {
            return "{$minutes} menit";
        }

        return "{$minutes} menit {$remainingSeconds} detik";
    }
}

