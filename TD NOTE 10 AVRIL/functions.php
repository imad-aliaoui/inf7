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

function incrementVisitorCounter(PDO $pdo): int
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!isset($_SESSION['counted_once'])) {
        $update = $pdo->prepare(
            'UPDATE app_stats
             SET stat_value = stat_value + 1
             WHERE stat_key = :stat_key'
        );
        $update->execute(['stat_key' => 'visitor_count']);

        $_SESSION['counted_once'] = true;
    }

    $select = $pdo->prepare(
        'SELECT stat_value
         FROM app_stats
         WHERE stat_key = :stat_key
         LIMIT 1'
    );
    $select->execute(['stat_key' => 'visitor_count']);

    $result = $select->fetch();

    return $result ? (int) $result['stat_value'] : 0;
}