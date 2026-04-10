<?php
declare(strict_types=1);

require_once 'config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?error=' . urlencode('Méthode non autorisée.'));
    exit;
}

$url = $_POST['url'] ?? '';
$url = normalizeUrl($url);

if ($url === '') {
    header('Location: index.php?error=' . urlencode('Veuillez saisir une URL.'));
    exit;
}

if (!isValidUrl($url)) {
    header('Location: index.php?error=' . urlencode('L’URL saisie est invalide.'));
    exit;
}

$stmt = $pdo->prepare('SELECT short_code FROM short_urls WHERE original_url = :original_url LIMIT 1');
$stmt->execute(['original_url' => $url]);
$existing = $stmt->fetch();

if ($existing) {
    $shortCode = $existing['short_code'];
} else {
    $shortCode = getUniqueShortCode($pdo);

    $stmt = $pdo->prepare(
        'INSERT INTO short_urls (original_url, short_code) VALUES (:original_url, :short_code)'
    );
    $stmt->execute([
        'original_url' => $url,
        'short_code' => $shortCode
    ]);
}

$scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$dir = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$shortUrl = $scheme . '://' . $host . $dir . '/go.php?c=' . urlencode($shortCode);

header(
    'Location: index.php?success=1'
    . '&short_url=' . urlencode($shortUrl)
    . '&original_url=' . urlencode($url)
);
exit;