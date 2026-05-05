<?php

function upload_dj_photo(?array $file, ?string $existingPhoto = null): array
{
    if ($file === null || !isset($file['error'])) {
        return [$existingPhoto, null];
    }

    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return [$existingPhoto, null];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [$existingPhoto, "Erreur lors de l'envoi de la photo."];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];

    if (!isset($allowed[$mime])) {
        return [$existingPhoto, 'Format de photo non autorisé.'];
    }

    $uploadDir = __DIR__ . '/uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    $target = $uploadDir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        return [$existingPhoto, "Impossible d'enregistrer la photo."];
    }

    return ['uploads/' . $filename, null];
}
