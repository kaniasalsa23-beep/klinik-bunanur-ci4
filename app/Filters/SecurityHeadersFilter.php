<?php

namespace App\Filters;

use App\Libraries\JwtAuth;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Enterprise HTTP Security Headers Filter (Helmet Equivalent)
 *
 * Enforces hardened security headers across all incoming requests and outgoing responses:
 * - Anti-Clickjacking (X-Frame-Options: DENY)
 * - MIME-sniffing prevention (X-Content-Type-Options: nosniff)
 * - Cross-Site Scripting filter (X-XSS-Protection: 1; mode=block)
 * - Referrer privacy (Referrer-Policy: strict-origin-when-cross-origin)
 * - Feature policy restriction (Permissions-Policy)
 * - HTTPS enforcement (HSTS: max-age=31536000; includeSubDomains)
 * - Content-Security-Policy (CSP) tailored for Chart.js, 3D Canvas, Boxicons, and CropperJS
 * - Server info disclosure mitigation (Removing X-Powered-By)
 */
class SecurityHeadersFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Menyembunyikan identitas server PHP sedini mungkin
        if (function_exists('header_remove')) {
            @header_remove('X-Powered-By');
        }
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // 1. Anti-Clickjacking (SAMEORIGIN agar embed internal milik klinik tetap bekerja)
        $response->setHeader('X-Frame-Options', 'SAMEORIGIN');

        // 2. MIME Sniffing Defense
        $response->setHeader('X-Content-Type-Options', 'nosniff');

        // 3. Browser XSS Filter Protection
        $response->setHeader('X-XSS-Protection', '1; mode=block');

        // 4. Referrer Policy
        $response->setHeader('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 5. Permissions / Feature Policy
        $response->setHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        // 6. Strict Transport Security (HSTS) jika koneksi HTTPS
        if (JwtAuth::isHttps()) {
            $response->setHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // 7. Balanced Content Security Policy (CSP)
        // Mendukung Chart.js, Font Awesome 6, Cyber Canvas 3D, Vanilla Tilt, CropperJS,
        // Google Fonts, Unpkg Boxicons, Swiper, dan domain produksi klinikbunanur.my.id
        $cspDirectives = [
            "default-src 'self' https://klinikbunanur.my.id https://www.klinikbunanur.my.id",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://klinikbunanur.my.id https://www.klinikbunanur.my.id https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com",
            "style-src 'self' 'unsafe-inline' https://klinikbunanur.my.id https://www.klinikbunanur.my.id https://fonts.googleapis.com https://unpkg.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net",
            "font-src 'self' data: https://klinikbunanur.my.id https://www.klinikbunanur.my.id https://fonts.gstatic.com https://unpkg.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net",
            "img-src 'self' data: blob: https://klinikbunanur.my.id https://www.klinikbunanur.my.id https:",
            "media-src 'self' blob: https://klinikbunanur.my.id https://www.klinikbunanur.my.id https:",
            "connect-src 'self' https://klinikbunanur.my.id https://www.klinikbunanur.my.id https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com https://api.fonnte.com",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self' https://klinikbunanur.my.id https://www.klinikbunanur.my.id",
            "upgrade-insecure-requests"
        ];

        $response->setHeader('Content-Security-Policy', implode('; ', $cspDirectives));

        // 8. Hapus header X-Powered-By dari response object
        $response->removeHeader('X-Powered-By');

        return $response;
    }
}

