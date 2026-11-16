<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * HTTP Security Headers Filter
 * Menambahkan header proteksi HTTP dasar ke setiap response:
 * - X-Frame-Options: SAMEORIGIN
 * - X-Content-Type-Options: nosniff
 * - X-XSS-Protection: 1; mode=block
 */
class SecureHeaders implements FilterInterface
{
    /**
     * Daftar HTTP Security Headers
     *
     * @var array<string, string>
     */
    protected array $headers = [
        'X-Frame-Options'        => 'SAMEORIGIN',
        'X-Content-Type-Options' => 'nosniff',
        'X-XSS-Protection'       => '1; mode=block',
        'Referrer-Policy'        => 'same-origin',
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        foreach ($this->headers as $header => $value) {
            $response->setHeader($header, $value);
        }

        return $response;
    }
}
