<?php
declare(strict_types=1);

function normalizeUrl(string $url): string
{
    $url = trim($url);

    if ($url === '') {
        return '';
    }

    if (!preg_match('#^https?://#i', $url)) {
        $url = 'https://' . $url;
    }

    return $url;
}

function isValidUrl(string $url): bool
{
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

function generateShortCode(int $length = 6): string
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $maxIndex = strlen($characters) - 1;
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[random_int(0, $maxIndex)];
    }

    return $code;
}

function getUniqueShortCode(PDO $pdo, int $length = 6): string
{
    do {
        $code = generateShortCode($length);

        $stmt = $pdo->prepare('SELECT id FROM short_urls WHERE short_code = :short_code');
        $stmt->execute(['short_code' => $code]);
        $exists = $stmt->fetch();
    } while ($exists);

    return $code;
}

function incrementVisitorCounter(): int
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (function_exists('apcu_fetch') && ini_get('apc.enabled')) {
        if (!isset($_SESSION['counted_once'])) {
            apcu_inc('url_shortener_visitors', 1, $success);
            if (!$success) {
                apcu_store('url_shortener_visitors', 1);
            }
            $_SESSION['counted_once'] = true;
        }

        $count = apcu_fetch('url_shortener_visitors');
        return is_int($count) ? $count : 0;
    }

    $counterFile = __DIR__ . '/counter.txt';

    if (!file_exists($counterFile)) {
        file_put_contents($counterFile, '0');
    }

    if (!isset($_SESSION['counted_once'])) {
        $current = (int) file_get_contents($counterFile);
        $current++;
        file_put_contents($counterFile, (string) $current);
        $_SESSION['counted_once'] = true;
    }

    return (int) file_get_contents($counterFile);
}
