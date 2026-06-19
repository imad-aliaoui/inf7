<?php
require_once "auth.php";
require_dj_auth();
require_once "connexion.php";

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    $error = "Identifiant manquant.";
} else {
    $stmt = $pdo->prepare("SELECT * FROM djs WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $dj = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dj) {
        http_response_code(404);
        $error = "DJ introuvable.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche DJ</title>
</head>
<body>
<h1>Student PARTY CORP</h1>
<h2>Fiche DJ</h2>

<p><a href="admin_djs.php">Retour à la liste</a></p>

<?php if (isset($error)) : ?>
    <p><?php echo htmlspecialchars($error); ?></p>
<?php else : ?>
    <p><strong>Nom :</strong> <?php echo htmlspecialchars($dj['nom']); ?></p>
    <p><strong>Prénom :</strong> <?php echo htmlspecialchars($dj['prenom']); ?></p>
    <p><strong>Email :</strong> <?php echo htmlspecialchars($dj['email']); ?></p>
    <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($dj['telephone']); ?></p>
    <p><strong>Portfolio :</strong> <?php echo htmlspecialchars($dj['portfolio']); ?></p>
    <p><strong>Date de la soirée :</strong> <?php echo htmlspecialchars($dj['date_soiree']); ?></p>
    <p><strong>Matériel :</strong> <?php echo htmlspecialchars($dj['materiel']); ?></p>
    <p><strong>Couleur favorite :</strong> <?php echo htmlspecialchars($dj['couleur']); ?></p>
    <p><strong>Photo :</strong>
        <?php if (!empty($dj['photo'])) : ?>
            <a href="<?php echo htmlspecialchars($dj['photo']); ?>" target="_blank" rel="noopener noreferrer">Voir la photo</a>
        <?php else : ?>
            Aucune photo
        <?php endif; ?>
    </p>
    <p><strong>Nombre d’enceintes :</strong> <?php echo (int)$dj['nb_enceintes1']; ?></p>
    <p><strong>Puissance des enceintes :</strong> <?php echo (int)$dj['puissance1']; ?> W</p>
<?php endif; ?>
</body>
</html>
