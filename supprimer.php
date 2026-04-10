<?php
require_once("connexion.php");

$email = $_POST['email'] ?? '';

if (!empty($email)) {
    $sql = "DELETE FROM djs WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    if ($stmt->rowCount() > 0) {
        $message = "Suppression effectuée.";
    } else {
        $message = "Aucun DJ trouvé avec cet email.";
    }
} else {
    $message = "Email non fourni.";
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