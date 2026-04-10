<?php
declare(strict_types=1);

require_once 'config.php';

$code = trim($_GET['c'] ?? '');

if ($code === '') {
    http_response_code(400);
    echo 'Code de raccourcissement manquant.';
    exit;
}

$stmt = $pdo->prepare(
    'SELECT original_url
     FROM short_urls
     WHERE short_code = :short_code
     LIMIT 1'
);
$stmt->execute(['short_code' => $code]);
$link = $stmt->fetch();

if ($link === false) {
    http_response_code(404);
    echo 'Lien introuvable.';
    exit;
}

header('Location: ' . $link['original_url']);
exit;