<?php

function dj_admin_user(): string
{
    return getenv('DJ_ADMIN_USER') ?: 'admin';
}

function dj_admin_pass(): string
{
    return getenv('DJ_ADMIN_PASS') ?: 'admin123';
}

function require_dj_auth(bool $api = false): void
{
    $user = $_SERVER['PHP_AUTH_USER'] ?? null;
    $pass = $_SERVER['PHP_AUTH_PW'] ?? null;

    if ($user === null || $pass === null) {
        $header = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
        if (stripos($header, 'basic ') === 0) {
            $decoded = base64_decode(substr($header, 6), true);
            if ($decoded !== false && str_contains($decoded, ':')) {
                [$user, $pass] = explode(':', $decoded, 2);
            }
        }
    }

    $expectedUser = dj_admin_user();
    $expectedPass = dj_admin_pass();

    $isValid = $user !== null
        && $pass !== null
        && hash_equals($expectedUser, $user)
        && hash_equals($expectedPass, $pass);

    if ($isValid) {
        return;
    }

    if ($api) {
        http_response_code(401);
        header('Content-Type: application/json; charset=UTF-8');
        header('WWW-Authenticate: Basic realm="DJ API"');
        echo json_encode(['error' => 'Authentification requise.'], JSON_UNESCAPED_UNICODE);
    } else {
        header('WWW-Authenticate: Basic realm="DJ Admin"');
        header('Content-Type: text/html; charset=UTF-8');
        http_response_code(401);
        echo '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>Accès refusé</title></head><body><h1>Accès refusé</h1><p>Authentification requise.</p></body></html>';
    }

    exit;
}
