<?php
require_once "auth.php";
require_dj_auth();
require_once "connexion.php";

$email = trim($_POST['email'] ?? '');
$id = (int)($_POST['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM djs WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $message = $stmt->rowCount() > 0 ? "Suppression effectuée." : "Aucun DJ trouvé avec cet identifiant.";
} elseif ($email !== '') {
    $stmt = $pdo->prepare("DELETE FROM djs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $message = $stmt->rowCount() > 0 ? "Suppression effectuée." : "Aucun DJ trouvé avec cet email.";
} else {
    $message = "Aucun identifiant ou email fourni.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suppression</title>
</head>
<body>
<h1>Student PARTY CORP</h1>
<p><?php echo htmlspecialchars($message); ?></p>
<a href="formulaire.php">Retour</a>
</body>
</html>
