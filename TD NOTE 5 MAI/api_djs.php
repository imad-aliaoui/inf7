<?php
require_once "auth.php";
require_dj_auth(true);
require_once "connexion.php";

header('Content-Type: application/json; charset=UTF-8');

function json_response(array $payload, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function read_request_data(): array
{
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    if (stripos($contentType, 'application/json') !== false) {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }

    if (!empty($_POST)) {
        return $_POST;
    }

    $raw = file_get_contents('php://input');
    $data = [];
    parse_str($raw, $data);
    return is_array($data) ? $data : [];
}

function normalize_materiel($value): string
{
    if (is_bool($value)) {
        return $value ? 'Oui' : 'Non';
    }

    $value = strtolower((string)$value);
    return in_array($value, ['1', 'true', 'oui', 'yes'], true) ? 'Oui' : 'Non';
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($method === 'GET') {
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM djs WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $dj = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$dj) {
            json_response(['error' => 'DJ introuvable.'], 404);
        }
        json_response(['data' => $dj]);
    }

    $stmt = $pdo->query("SELECT * FROM djs ORDER BY id DESC");
    $djs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    json_response(['data' => $djs]);
}

if ($method === 'POST') {
    $data = read_request_data();

    $nom = trim($data['nom'] ?? '');
    $prenom = trim($data['prenom'] ?? '');
    $email = trim($data['email'] ?? '');

    $errors = [];
    if ($nom === '') {
        $errors[] = 'Le nom est obligatoire.';
    }
    if ($prenom === '') {
        $errors[] = 'Le prénom est obligatoire.';
    }
    if ($email === '') {
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email est invalide.";
    }

    $stmt = $pdo->prepare("SELECT id FROM djs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $errors[] = "Un DJ avec cet email existe déjà.";
    }

    if (!empty($errors)) {
        json_response(['errors' => $errors], 422);
    }

    $stmt = $pdo->prepare("INSERT INTO djs
        (nom, prenom, email, telephone, portfolio, date_soiree, materiel, couleur, photo, nb_enceintes1, puissance1, nb_enceintes2, puissance2)
        VALUES
        (:nom, :prenom, :email, :telephone, :portfolio, :date_soiree, :materiel, :couleur, :photo, :nb_enceintes1, :puissance1, :nb_enceintes2, :puissance2)");

    $stmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'telephone' => trim($data['telephone'] ?? ''),
        'portfolio' => trim($data['portfolio'] ?? ''),
        'date_soiree' => $data['date_soiree'] ?? null,
        'materiel' => normalize_materiel($data['materiel'] ?? false),
        'couleur' => trim($data['couleur'] ?? ''),
        'photo' => trim($data['photo'] ?? ''),
        'nb_enceintes1' => max(0, (int)($data['nb_enceintes'] ?? 0)),
        'puissance1' => max(0, (int)($data['puissance'] ?? 0)),
        'nb_enceintes2' => 0,
        'puissance2' => 0
    ]);

    json_response(['message' => 'DJ créé.', 'id' => (int)$pdo->lastInsertId()], 201);
}

if ($method === 'PUT') {
    if (!$id) {
        json_response(['error' => "L'identifiant est obligatoire."], 400);
    }

    $data = read_request_data();

    $stmt = $pdo->prepare("SELECT * FROM djs WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$existing) {
        json_response(['error' => 'DJ introuvable.'], 404);
    }

    $nom = trim($data['nom'] ?? $existing['nom']);
    $prenom = trim($data['prenom'] ?? $existing['prenom']);
    $email = trim($data['email'] ?? $existing['email']);

    $errors = [];
    if ($nom === '') {
        $errors[] = 'Le nom est obligatoire.';
    }
    if ($prenom === '') {
        $errors[] = 'Le prénom est obligatoire.';
    }
    if ($email === '') {
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email est invalide.";
    }

    $stmt = $pdo->prepare("SELECT id FROM djs WHERE email = :email AND id <> :id");
    $stmt->execute(['email' => $email, 'id' => $id]);
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $errors[] = "Un autre DJ utilise déjà cet email.";
    }

    if (!empty($errors)) {
        json_response(['errors' => $errors], 422);
    }

    $stmt = $pdo->prepare("UPDATE djs SET
            nom = :nom,
            prenom = :prenom,
            email = :email,
            telephone = :telephone,
            portfolio = :portfolio,
            date_soiree = :date_soiree,
            materiel = :materiel,
            couleur = :couleur,
            photo = :photo,
            nb_enceintes1 = :nb_enceintes1,
            puissance1 = :puissance1,
            nb_enceintes2 = :nb_enceintes2,
            puissance2 = :puissance2
        WHERE id = :id");

    $stmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'telephone' => trim($data['telephone'] ?? $existing['telephone']),
        'portfolio' => trim($data['portfolio'] ?? $existing['portfolio']),
        'date_soiree' => $data['date_soiree'] ?? $existing['date_soiree'],
        'materiel' => normalize_materiel($data['materiel'] ?? $existing['materiel']),
        'couleur' => trim($data['couleur'] ?? $existing['couleur']),
        'photo' => trim($data['photo'] ?? $existing['photo']),
        'nb_enceintes1' => max(0, (int)($data['nb_enceintes'] ?? $existing['nb_enceintes1'])),
        'puissance1' => max(0, (int)($data['puissance'] ?? $existing['puissance1'])),
        'nb_enceintes2' => 0,
        'puissance2' => 0,
        'id' => $id
    ]);

    json_response(['message' => 'DJ mis à jour.']);
}

if ($method === 'DELETE') {
    if (!$id) {
        json_response(['error' => "L'identifiant est obligatoire."], 400);
    }

    $stmt = $pdo->prepare("DELETE FROM djs WHERE id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() === 0) {
        json_response(['error' => 'DJ introuvable.'], 404);
    }

    json_response(['message' => 'DJ supprimé.']);
}

json_response(['error' => 'Méthode non autorisée.'], 405);
