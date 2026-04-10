<?php
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$email = $_POST['email'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$portfolio = $_POST['portfolio'] ?? '';
$date_soiree = $_POST['date_soiree'] ?? '';
$materiel = isset($_POST['materiel']) ? $_POST['materiel'] : 'Non';
$couleur = $_POST['couleur'] ?? '';

$nb_enceintes1 = (int)($_POST['nb_enceintes1'] ?? 0);
$puissance1 = (int)($_POST['puissance1'] ?? 0);
$nb_enceintes2 = (int)($_POST['nb_enceintes2'] ?? 0);
$puissance2 = (int)($_POST['puissance2'] ?? 0);

$puissance_totale = ($nb_enceintes1 * $puissance1) + ($nb_enceintes2 * $puissance2);

// Gestion simple du fichier photo
$nom_photo = '';
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $nom_photo = $_FILES['photo']['name'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affichage POST</title>
</head>
<body>

<h1>Student PARTY CORP - Résultat POST</h1>

<p><strong>Nom :</strong> <?php echo htmlspecialchars($nom); ?></p>
<p><strong>Prénom :</strong> <?php echo htmlspecialchars($prenom); ?></p>
<p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
<p><strong>Téléphone :</strong> <?php echo htmlspecialchars($telephone); ?></p>
<p><strong>Portfolio :</strong> <?php echo htmlspecialchars($portfolio); ?></p>
<p><strong>Date de la soirée :</strong> <?php echo htmlspecialchars($date_soiree); ?></p>
<p><strong>Matériel :</strong> <?php echo htmlspecialchars($materiel); ?></p>
<p><strong>Couleur favorite :</strong> <?php echo htmlspecialchars($couleur); ?></p>
<p><strong>Photo envoyée :</strong> <?php echo htmlspecialchars($nom_photo); ?></p>

<h2>Puissance des enceintes</h2>
<p>Chaîne 1 : <?php echo $nb_enceintes1; ?> enceinte(s) × <?php echo $puissance1; ?> W</p>
<p>Chaîne 2 : <?php echo $nb_enceintes2; ?> enceinte(s) × <?php echo $puissance2; ?> W</p>
<p><strong>Puissance totale :</strong> <?php echo $puissance_totale; ?> W</p>

<br>
<a href="formulaire.php">Retour au formulaire</a>

</body>
</html>