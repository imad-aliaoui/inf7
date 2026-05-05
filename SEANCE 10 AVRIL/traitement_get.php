<?php
$nom = $_GET['nom'] ?? '';
$prenom = $_GET['prenom'] ?? '';
$email = $_GET['email'] ?? '';
$telephone = $_GET['telephone'] ?? '';
$portfolio = $_GET['portfolio'] ?? '';
$date_soiree = $_GET['date_soiree'] ?? '';
$materiel = isset($_GET['materiel']) ? $_GET['materiel'] : 'Non';
$couleur = $_GET['couleur'] ?? '';

$nb_enceintes1 = (int)($_GET['nb_enceintes1'] ?? 0);
$puissance1 = (int)($_GET['puissance1'] ?? 0);
$nb_enceintes2 = (int)($_GET['nb_enceintes2'] ?? 0);
$puissance2 = (int)($_GET['puissance2'] ?? 0);

// Addition de deux chaînes d'enceintes
$puissance_totale = ($nb_enceintes1 * $puissance1) + ($nb_enceintes2 * $puissance2);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affichage GET</title>
</head>
<body>

<h1>Student PARTY CORP - Résultat GET</h1>

<p><strong>Nom :</strong> <?php echo htmlspecialchars($nom); ?></p>
<p><strong>Prénom :</strong> <?php echo htmlspecialchars($prenom); ?></p>
<p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
<p><strong>Téléphone :</strong> <?php echo htmlspecialchars($telephone); ?></p>
<p><strong>Portfolio :</strong> <?php echo htmlspecialchars($portfolio); ?></p>
<p><strong>Date de la soirée :</strong> <?php echo htmlspecialchars($date_soiree); ?></p>
<p><strong>Matériel :</strong> <?php echo htmlspecialchars($materiel); ?></p>
<p><strong>Couleur favorite :</strong> <?php echo htmlspecialchars($couleur); ?></p>

<h2>Puissance des enceintes</h2>
<p>Chaîne 1 : <?php echo $nb_enceintes1; ?> enceinte(s) × <?php echo $puissance1; ?> W</p>
<p>Chaîne 2 : <?php echo $nb_enceintes2; ?> enceinte(s) × <?php echo $puissance2; ?> W</p>
<p><strong>Puissance totale :</strong> <?php echo $puissance_totale; ?> W</p>

<br>
<a href="formulaire.php">Retour au formulaire</a>

</body>
</html>
