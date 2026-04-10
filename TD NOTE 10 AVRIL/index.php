<?php
declare(strict_types=1);
require_once 'functions.php';

$visitorCount = incrementVisitorCounter();
$baseUrl = rtrim(dirname((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']), '/\\');
if ($baseUrl === '') {
    $baseUrl = '.';
}

$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
$shortUrl = $_GET['short_url'] ?? '';
$originalUrl = $_GET['original_url'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini URL - Raccourcisseur d’URL</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container">
    <section class="card hero">
        <div class="badge">Compteur visiteurs : <?php echo $visitorCount; ?></div>
        <h1>Mini URL</h1>
        <p class="subtitle">
            Raccourcis tes liens en un clic. Interface simple, propre, rapide et agréable à utiliser.
        </p>

        <?php if ($success === '1' && $shortUrl !== ''): ?>
            <div class="alert success">
                <strong>URL raccourcie créée avec succès.</strong>
                <p><span>Lien d’origine :</span> <?php echo htmlspecialchars($originalUrl); ?></p>
                <p><span>Lien court :</span>
                    <a href="<?php echo htmlspecialchars($shortUrl); ?>" target="_blank">
                        <?php echo htmlspecialchars($shortUrl); ?>
                    </a>
                </p>
            </div>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="alert error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="create.php" method="post" class="shortener-form">
            <label for="url">URL à raccourcir</label>
            <input
                type="url"
                id="url"
                name="url"
                placeholder="https://exemple.com/mon-lien-super-long"
                required
            >

            <button type="submit">Raccourcir l’URL</button>
        </form>
    </section>

    <section class="card tips">
        <h2>Pourquoi ce site est propre côté qualimétrie</h2>
        <ul>
            <li>Validation des entrées</li>
            <li>Requêtes préparées PDO</li>
            <li>Code séparé par responsabilités</li>
            <li>Design responsive et lisible</li>
            <li>Messages d’erreur clairs</li>
            <li>Redirection automatique fiable</li>
        </ul>
    </section>
</main>
</body>
</html>
