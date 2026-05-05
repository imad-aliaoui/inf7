<?php
require_once "auth.php";
require_dj_auth();
require_once "connexion.php";

$stmt = $pdo->query("SELECT id, nom, prenom, email FROM djs ORDER BY nom, prenom");
$djs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Back-office DJs</title>
</head>
<body>
<h1>Student PARTY CORP</h1>
<h2>Back-office DJs</h2>

<p><a href="formulaire.php">Retour au formulaire</a></p>

<?php if (empty($djs)) : ?>
    <p>Aucun DJ enregistré.</p>
<?php else : ?>
    <table border="1" cellpadding="6">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($djs as $dj) : ?>
            <tr>
                <td><?php echo htmlspecialchars($dj['nom']); ?></td>
                <td><?php echo htmlspecialchars($dj['prenom']); ?></td>
                <td><?php echo htmlspecialchars($dj['email']); ?></td>
                <td>
                    <a href="dj_detail.php?id=<?php echo (int)$dj['id']; ?>">Voir</a> |
                    <a href="dj_edit.php?id=<?php echo (int)$dj['id']; ?>">Modifier</a> |
                    <a href="dj_delete.php?id=<?php echo (int)$dj['id']; ?>">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</body>
</html>
