<?php
require_once "auth.php";
require_dj_auth();
require_once "connexion.php";

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    $error = "Identifiant manquant.";
} else {
    $stmt = $pdo->prepare("SELECT id, nom, prenom, email FROM djs WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $dj = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dj) {
        http_response_code(404);
        $error = "DJ introuvable.";
    }
}

$success = false;

if (!isset($error) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("DELETE FROM djs WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $success = $stmt->rowCount() > 0;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer DJ</title>
</head>
<body>
<h1>Student PARTY CORP</h1>
<h2>Supprimer un DJ</h2>

<p><a href="admin_djs.php">Retour à la liste</a></p>

<?php if (isset($error)) : ?>
    <p><?php echo htmlspecialchars($error); ?></p>
<?php elseif ($success) : ?>
    <p>Le DJ a été supprimé.</p>
<?php else : ?>
    <p>Confirmer la suppression de <?php echo htmlspecialchars($dj['prenom'] . ' ' . $dj['nom']); ?> (<?php echo htmlspecialchars($dj['email']); ?>).</p>
    <form action="dj_delete.php" method="post">
        <input type="hidden" name="id" value="<?php echo (int)$dj['id']; ?>">
        <input type="submit" value="Confirmer la suppression">
    </form>
<?php endif; ?>
</body>
</html>
