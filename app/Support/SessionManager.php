<?php

namespace Support;

use Contracts\SessionInterface;

class SessionManager implements SessionInterface
{
    public function __construct(
        ?string $cacheExpire = null,
        ?string $cacheLimiter = null,
        array   $cookieParams = []
    )
    {
        if (session_status() === PHP_SESSION_NONE) {
            if (headers_sent()) {
                throw new \RuntimeException('Não é possível iniciar a sessão: headers já foram enviados.');
            }

            if ($cacheLimiter !== null) {
                session_cache_limiter($cacheLimiter);
            }

            if ($cacheExpire !== null) {
                session_cache_expire($cacheExpire);
            }

            $defaultCookie = [
                'lifetime' => 0,
                'path' => '/',
                'domain' => '',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Lax'
            ];

            session_set_cookie_params(array_merge($defaultCookie, $cookieParams));

            session_start();

            if (!isset($_SESSION)) {
                $_SESSION = [];
            }
        }
    }

    public function get(string $key): mixed
    {
        return $this->has($key) ? $_SESSION[$key] : null;
    }

    public function set(string $key, mixed $value): SessionInterface
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function regenerate(bool $deleteOldSession = true): void
    {
        session_regenerate_id($deleteOldSession);
    }
}