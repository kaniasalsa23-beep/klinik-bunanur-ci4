<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Base Site URL
     * --------------------------------------------------------------------------
     *
     * URL to your CodeIgniter root. Typically, this will be your base URL,
     * WITH a trailing slash:
     *
     * E.g., http://example.com/
     */
    public string $baseURL = 'http://localhost:8080/';

    /**
     * Allowed Hostnames in the Site URL other than the hostname in the baseURL.
     * If you want to accept multiple Hostnames, set this.
     *
     * @var list<string>
     */
    public array $allowedHostnames = [
        'localhost',
        '127.0.0.1',
        'klinikbunanur.my.id',
        'www.klinikbunanur.my.id',
        'klinikbunanur.infinityfreeapp.com',
    ];

    /**
     * --------------------------------------------------------------------------
     * Index File
     * --------------------------------------------------------------------------
     *
     * Typically, this will be your `index.php` file, unless you've renamed it to
     * something else. If you have configured your web server to remove this file
     * from your site URIs, set this variable to an empty string.
     */
    public string $indexPage = '';

    /**
     * --------------------------------------------------------------------------
     * URI PROTOCOL
     * --------------------------------------------------------------------------
     *
     * This item determines which server global should be used to retrieve the
     * URI string. The default setting of 'REQUEST_URI' works for most servers.
     * If your links do not seem to work, try one of the other delicious flavors:
     *
     *  'REQUEST_URI': Uses $_SERVER['REQUEST_URI']
     * 'QUERY_STRING': Uses $_SERVER['QUERY_STRING']
     *    'PATH_INFO': Uses $_SERVER['PATH_INFO']
     *
     * WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
     */
    public string $uriProtocol = 'REQUEST_URI';

    /*
    |--------------------------------------------------------------------------
    | Allowed URL Characters
    |--------------------------------------------------------------------------
    |
    | This lets you specify which characters are permitted within your URLs.
    | When someone tries to submit a URL with disallowed characters they will
    | get a warning message.
    |
    | As a security measure you are STRONGLY encouraged to restrict URLs to
    | as few characters as possible.
    |
    | By default, only these are allowed: `a-z 0-9~%.:_-`
    |
    | Set an empty string to allow all characters -- but only if you are insane.
    |
    | The configured value is actually a regular expression character group
    | and it will be used as: '/\A[<permittedURIChars>]+\z/iu'
    |
    | DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
    |
    */
    public string $permittedURIChars = 'a-z 0-9~%.:_\-';

    /**
     * --------------------------------------------------------------------------
     * Default Locale
     * --------------------------------------------------------------------------
     *
     * The Locale roughly represents the language and location that your visitor
     * is viewing the site from. It affects the language strings and other
     * strings (like currency markers, numbers, etc), that your program
     * should run under for this request.
     */
    public string $defaultLocale = 'en';

    /**
     * --------------------------------------------------------------------------
     * Negotiate Locale
     * --------------------------------------------------------------------------
     *
     * If true, the current Request object will automatically determine the
     * language to use based on the value of the Accept-Language header.
     *
     * If false, no automatic detection will be performed.
     */
    public bool $negotiateLocale = false;

    /**
     * --------------------------------------------------------------------------
     * Supported Locales
     * --------------------------------------------------------------------------
     *
     * If $negotiateLocale is true, this array lists the locales supported
     * by the application in descending order of priority. If no match is
     * found, the first locale will be used.
     *
     * IncomingRequest::setLocale() also uses this list.
     *
     * @var list<string>
     */
    public array $supportedLocales = ['en'];

    /**
     * --------------------------------------------------------------------------
     * Application Timezone
     * --------------------------------------------------------------------------
     *
     * The default timezone that will be used in your application to display
     * dates with the date helper, and can be retrieved through app_timezone()
     *
     * @see https://www.php.net/manual/en/timezones.php for list of timezones
     *      supported by PHP.
     */
    public string $appTimezone = 'Asia/Jakarta';

    /**
     * --------------------------------------------------------------------------
     * Default Character Set
     * --------------------------------------------------------------------------
     *
     * This determines which character set is used by default in various methods
     * that require a character set to be provided.
     *
     * @see http://php.net/htmlspecialchars for a list of supported charsets.
     */
    public string $charset = 'UTF-8';

    /**
     * --------------------------------------------------------------------------
     * Force Global Secure Requests
     * --------------------------------------------------------------------------
     *
     * If true, this will force every request made to this application to be
     * made via a secure connection (HTTPS). If the incoming request is not
     * secure, the user will be redirected to a secure version of the page
     * and the HTTP Strict Transport Security (HSTS) header will be set.
     */
    public bool $forceGlobalSecureRequests = false;

    /**
     * --------------------------------------------------------------------------
     * Reverse Proxy IPs
     * --------------------------------------------------------------------------
     *
     * If your server is behind a reverse proxy, you must whitelist the proxy
     * IP addresses from which CodeIgniter should trust headers such as
     * X-Forwarded-For or Client-IP in order to properly identify
     * the visitor's IP address.
     *
     * You need to set a proxy IP address or IP address with subnets and
     * the HTTP header for the client IP address.
     *
     * Here are some examples:
     *     [
     *         '10.0.1.200'     => 'X-Forwarded-For',
     *         '192.168.5.0/24' => 'X-Real-IP',
     *     ]
     *
     * @var array<string, string>
     */
    public array $proxyIPs = [];

    /**
     * --------------------------------------------------------------------------
     * Content Security Policy
     * --------------------------------------------------------------------------
     *
     * Enables the Response's Content Secure Policy to restrict the sources that
     * can be used for images, scripts, CSS files, audio, video, etc. If enabled,
     * the Response object will populate default values for the policy from the
     * `ContentSecurityPolicy.php` file. Controllers can always add to those
     * restrictions at run time.
     *
     * For a better understanding of CSP, see these documents:
     *
     * @see http://www.html5rocks.com/en/tutorials/security/content-security-policy/
     * @see http://www.w3.org/TR/CSP/
     */
    public bool $CSPEnabled = false;

    /**
     * --------------------------------------------------------------------------
     * Fonnte WhatsApp Gateway API Token
     * --------------------------------------------------------------------------
     * Token used for sending WhatsApp OTP server-to-server.
     */
    public string $fonnteToken = '';

    public function __construct()
    {
        parent::__construct();

        $this->fonnteToken = (string)env('FONNTE_TOKEN', (string)env('WHATSAPP_GATEWAY_TOKEN', (string)env('WHATSAPP_API_TOKEN', '')));

        $host = (string)($_SERVER['HTTP_HOST'] ?? '');
        $isLocal = str_contains($host, 'localhost') || str_contains($host, '127.0.0.1');

        // 1. CPANEL / REVERSE PROXY SSL: Deteksi dan normalisasi HTTPS sedini mungkin (HANYA untuk remote host)
        if (!$isLocal) {
            if (
                (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ||
                ((int)($_SERVER['SERVER_PORT'] ?? 80) === 443) ||
                (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') ||
                (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) === 'on') ||
                (isset($_SERVER['HTTP_X_FORWARDED_SCHEME']) && strtolower($_SERVER['HTTP_X_FORWARDED_SCHEME']) === 'https') ||
                (isset($_SERVER['HTTP_X_URL_SCHEME']) && strtolower($_SERVER['HTTP_X_URL_SCHEME']) === 'https') ||
                (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) === 'on') ||
                (isset($_SERVER['HTTP_CF_VISITOR']) && strpos($_SERVER['HTTP_CF_VISITOR'], 'https') !== false) ||
                (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && (int)$_SERVER['HTTP_X_FORWARDED_PORT'] === 443) ||
                in_array($host, ['klinikbunanur.my.id', 'www.klinikbunanur.my.id'], true) ||
                str_contains($host, 'infinityfreeapp.com')
            ) {
                $_SERVER['HTTPS']       = 'on';
                $_SERVER['SERVER_PORT'] = 443;
            }
        }

        // 2. SELALU bersihkan indexPage agar route bersih tanpa /index.php/
        $this->indexPage = '';

        // 3. Resolusi Base URL yang kebal cPanel reverse proxy, InfinityFree & Localhost
        $envBase = env('app.baseURL')
            ?: (getenv('app_baseURL')
            ?: (getenv('APP_BASEURL')
            ?: ($_SERVER['app_baseURL'] ?? ($_ENV['app_baseURL'] ?? null))));

        if (isset($_SERVER['HTTP_HOST']) && (
            in_array($_SERVER['HTTP_HOST'], ['klinikbunanur.my.id', 'www.klinikbunanur.my.id'], true) ||
            str_contains($_SERVER['HTTP_HOST'], 'infinityfreeapp.com')
        )) {
            // Domain produksi cPanel / InfinityFree SELALU HTTPS
            $this->baseURL = 'https://' . $_SERVER['HTTP_HOST'] . '/';
            $this->forceGlobalSecureRequests = true;
        } elseif ($envBase) {
            $this->baseURL = rtrim(trim((string)$envBase, "'\""), '/') . '/';
        } elseif (isset($_SERVER['VERCEL_URL']) || isset($_ENV['VERCEL_URL'])) {
            $host = $_SERVER['VERCEL_URL'] ?? $_ENV['VERCEL_URL'];
            $this->baseURL = 'https://' . $host . '/';
        } elseif (isset($_SERVER['HTTP_HOST'])) {
            $isHttps = (
                (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ||
                ((int)($_SERVER['SERVER_PORT'] ?? 80) === 443)
            );
            $protocol = $isHttps ? 'https://' : 'http://';
            $this->baseURL = $protocol . $_SERVER['HTTP_HOST'] . '/';
        }

        // 4. Kunci HTTPS jika domain produksi
        if (isset($_SERVER['HTTP_HOST']) && (
            in_array($_SERVER['HTTP_HOST'], ['klinikbunanur.my.id', 'www.klinikbunanur.my.id'], true) ||
            str_contains($_SERVER['HTTP_HOST'], 'infinityfreeapp.com')
        )) {
            $this->forceGlobalSecureRequests = true;
            if (strpos($this->baseURL, 'http://') === 0) {
                $this->baseURL = 'https://' . substr($this->baseURL, 7);
            }
        }

        // 5. Izinkan hostname runtime secara dinamis
        if (!empty($_SERVER['HTTP_HOST'])) {
            $rawHost = parse_url('http://' . $_SERVER['HTTP_HOST'], PHP_URL_HOST) ?: $_SERVER['HTTP_HOST'];
            if (!in_array($rawHost, $this->allowedHostnames, true)) {
                $this->allowedHostnames[] = $rawHost;
            }
        }
        if (!empty($_SERVER['VERCEL_URL']) && !in_array($_SERVER['VERCEL_URL'], $this->allowedHostnames, true)) {
            $this->allowedHostnames[] = $_SERVER['VERCEL_URL'];
        }
    }
}
