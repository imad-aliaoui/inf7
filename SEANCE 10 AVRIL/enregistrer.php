<?php
require_once"connexion.php";

$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$email = $_POST['email'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$portfolio = $_POST['portfolio'] ?? '';
$date_soiree = $_POST['date_soiree'] ?? null;
$materiel = isset($_POST['materiel']) ? $_POST['materiel'] : 'Non';
$couleur = $_POST['couleur'] ?? '';
$nb_enceintes1 = (int)($_POST['nb_enceintes1'] ?? 0);
$puissance1 = (int)($_POST['puissance1'] ?? 0);
$nb_enceintes2 = (int)($_POST['nb_enceintes2'] ?? 0);
$puissance2 = (int)($_POST['puissance2'] ?? 0);

$photo = '';
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $photo = $_FILES['photo']['name'];
}

$puissance_totale = ($nb_enceintes1 * $puissance1) + ($nb_enceintes2 * $puissance2);

// Vérifier si l'email existe déjà
$sql = "SELECT * FROM djs WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);
$dj = $stmt->fetch(PDO::FETCH_ASSOC);

if ($dj) {
    // Mise à jour
    $sql = "UPDATE djs SET
                nom = :nom,
                prenom = :prenom,
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
            WHERE email = :email";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'telephone' => $telephone,
        'portfolio' => $portfolio,
        'date_soiree' => $date_soiree,
        'materiel' => $materiel,
        'couleur' => $couleur,
        'photo' => $photo,
        'nb_enceintes1' => $nb_enceintes1,
        'puissance1' => $puissance1,
        'nb_enceintes2' => $nb_enceintes2,
        'puissance2' => $puissance2,
        'email' => $email
    ]);

    $message = "Le DJ existe déjà : les informations ont été mises à jour.";
} else {
    // Insertion
    $sql = "INSERT INTO djs
            (nom, prenom, email, telephone, portfolio, date_soiree, materiel, couleur, photo, nb_enceintes1, puissance1, nb_enceintes2, puissance2)
            VALUES
            (:nom, :prenom, :email, :telephone, :portfolio, :date_soiree, :materiel, :couleur, :photo, :nb_enceintes1, :puissance1, :nb_enceintes2, :puissance2)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'telephone' => $telephone,
        'portfolio' => $portfolio,
        'date_soiree' => $date_soiree,
        'materiel' => $materiel,
        'couleur' => $couleur,
        'photo' => $photo,
        'nb_enceintes1' => $nb_enceintes1,
        'puissance1' => $puissance1,
        'nb_enceintes2' => $nb_enceintes2,
        'puissance2' => $puissance2
    ]);

    $message = "Nouveau DJ inséré dans la table.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrement DJ</title>
</head>
<body>

<h1>Student PARTY CORPORATION</h1>
<p><?php echo htmlspecialchars($message); ?></p>

<h2>Informations enregistrées</h2>
<p><strong>Nom :</strong> <?php echo htmlspecialchars($nom); ?></p>
<p><strong>Prénom :</strong> <?php echo htmlspecialchars($prenom); ?></p>
<p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
<p><strong>Téléphone :</strong> <?php echo htmlspecialchars($telephone); ?></p>
<p><strong>Portfolio :</strong> <?php echo htmlspecialchars($portfolio); ?></p>
<p><strong>Date soirée :</strong> <?php echo htmlspecialchars($date_soiree); ?></p>
<p><strong>Matériel :</strong> <?php echo htmlspecialchars($materiel); ?></p>
<p><strong>Couleur :</strong> <?php echo htmlspecialchars($couleur); ?></p>
<p><strong>Photo :</strong> <?php echo htmlspecialchars($photo); ?></p>
<p><strong>Puissance totale :</strong> <?php echo $puissance_totale; ?> W</p>

<br>
<a href="formulaire.php">Retour au formulaire</a>

</body>
</html>
