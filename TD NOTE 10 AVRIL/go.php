<?php
declare(strict_types=1);

require_once 'config.php';

$code = $_GET['c'] ?? '';
$code = trim($code);

if ($code === '') {
    http_response_code(400);
    echo 'Code de raccourcissement manquant.';
    exit;
}

$stmt = $pdo->prepare('SELECT id, original_url FROM short_urls WHERE short_code = :short_code LIMIT 1');
$stmt->execute(['short_code' => $code]);
$link = $stmt->fetch();

if (!$link) {
    http_response_code(404);
    echo 'Lien introuvable.';
    exit;
}

$update = $pdo->prepare('UPDATE short_urls SET clicks = clicks + 1 WHERE id = :id');
$update->execute(['id' => $link['id']]);

header('Location: ' . $link['original_url']);
exit;