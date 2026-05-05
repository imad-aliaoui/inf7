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
    if ($mime === false) {
        return [$existingPhoto, "Impossible de vérifier le type de fichier."];
    }

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];

    if (!isset($allowed[$mime])) {
        return [$existingPhoto, 'Format de photo non autorisé.'];
    }

    if (getimagesize($file['tmp_name']) === false) {
        return [$existingPhoto, "Le fichier n'est pas une image valide."];
    }

    $uploadDir = __DIR__ . '/uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0750, true);
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    $target = $uploadDir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        return [$existingPhoto, "Impossible d'enregistrer la photo."];
    }

    return ['uploads/' . $filename, null];
}
