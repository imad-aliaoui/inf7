<?php
require_once "connexion.php";
require_once "upload.php";

$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email = trim($_POST['email'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$portfolio = trim($_POST['portfolio'] ?? '');
$date_soiree = $_POST['date_soiree'] ?? null;
$materiel = !empty($_POST['materiel']) ? 'Oui' : 'Non';
$couleur = trim($_POST['couleur'] ?? '');
$nb_enceintes = max(0, (int)($_POST['nb_enceintes'] ?? 0));
$puissance = max(0, (int)($_POST['puissance'] ?? 0));

$errors = [];
$instruction = null;

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

$puissance_totale = $nb_enceintes * $puissance;

$dj = null;
[$photo, $photo_error] = ['', null];
if (empty($errors)) {
    $stmt = $pdo->prepare("SELECT id FROM djs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $dj = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (empty($errors) && !$dj) {
    [$photo, $photo_error] = upload_dj_photo($_FILES['photo'] ?? null);
    if ($photo_error !== null) {
        $errors[] = $photo_error;
    }
}

if (!empty($errors)) {
    $message = "Votre inscription n'a pas pu être enregistrée.";
} elseif ($dj) {
    $message = "Adresse email déjà enregistrée.";
    $instruction = "Contactez l'administration pour modifier les informations.";
} else {
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
        'nb_enceintes1' => $nb_enceintes,
        'puissance1' => $puissance,
        'nb_enceintes2' => 0,
        'puissance2' => 0
    ]);

    $message = "Votre inscription a bien été enregistrée.";
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

<?php if ($instruction) : ?>
    <p><?php echo htmlspecialchars($instruction); ?></p>
<?php endif; ?>

<?php if (!empty($errors)) : ?>
    <ul>
        <?php foreach ($errors as $error) : ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h2>Informations enregistrées</h2>
<p><strong>Nom :</strong> <?php echo htmlspecialchars($nom); ?></p>
<p><strong>Prénom :</strong> <?php echo htmlspecialchars($prenom); ?></p>
<p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
<p><strong>Téléphone :</strong> <?php echo htmlspecialchars($telephone); ?></p>
<p><strong>Portfolio :</strong> <?php echo htmlspecialchars($portfolio); ?></p>
<p><strong>Date soirée :</strong> <?php echo htmlspecialchars($date_soiree); ?></p>
<p><strong>Matériel :</strong> <?php echo htmlspecialchars($materiel); ?></p>
<p><strong>Couleur :</strong> <?php echo htmlspecialchars($couleur); ?></p>
<p><strong>Photo :</strong>
    <?php if (!empty($photo)) : ?>
        <a href="<?php echo htmlspecialchars($photo); ?>" target="_blank" rel="noopener noreferrer">Voir la photo</a>
    <?php else : ?>
        Aucune photo
    <?php endif; ?>
</p>
<p><strong>Nombre d’enceintes :</strong> <?php echo $nb_enceintes; ?></p>
<p><strong>Puissance des enceintes :</strong> <?php echo $puissance; ?> W</p>
<p><strong>Puissance totale :</strong> <?php echo $puissance_totale; ?> W</p>

<br>
<a href="formulaire.php">Retour au formulaire</a>

</body>
</html>
