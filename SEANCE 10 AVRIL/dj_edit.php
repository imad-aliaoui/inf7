<?php
require_once "auth.php";
require_dj_auth();
require_once "connexion.php";
require_once "upload.php";

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

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

$errors = [];
$success = false;

if (!isset($error) && $_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM djs WHERE email = :email AND id <> :id");
        $stmt->execute(['email' => $email, 'id' => $id]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $errors[] = "Cet email est déjà utilisé par un autre DJ.";
        }
    }

    $photo = $dj['photo'];
    if (empty($errors)) {
        [$photo, $photoError] = upload_dj_photo($_FILES['photo'] ?? null, $dj['photo']);
        if ($photoError !== null) {
            $errors[] = $photoError;
        }
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE djs SET
                nom = :nom,
                prenom = :prenom,
                email = :email,
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
            WHERE id = :id");

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
            'puissance2' => 0,
            'id' => $id
        ]);

        $success = true;
        $dj = array_merge($dj, [
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
            'puissance2' => 0,
        ]);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier DJ</title>
</head>
<body>
<h1>Student PARTY CORP</h1>
<h2>Modifier un DJ</h2>

<p><a href="admin_djs.php">Retour à la liste</a></p>

<?php if (isset($error)) : ?>
    <p><?php echo htmlspecialchars($error); ?></p>
<?php else : ?>
    <?php if ($success) : ?>
        <p>Les informations ont été mises à jour.</p>
    <?php endif; ?>

    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $errorItem) : ?>
                <li><?php echo htmlspecialchars($errorItem); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="dj_edit.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo (int)$dj['id']; ?>">

        <fieldset>
            <legend>Informations personnelles</legend>

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($dj['nom']); ?>" required>
            <br><br>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($dj['prenom']); ?>" required>
            <br><br>

            <label for="email">E-mail :</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($dj['email']); ?>" required>
            <br><br>

            <label for="telephone">Numéro de téléphone :</label>
            <input type="tel" id="telephone" name="telephone" value="<?php echo htmlspecialchars($dj['telephone']); ?>">
            <br><br>

            <label for="portfolio">URL du portfolio :</label>
            <input type="url" id="portfolio" name="portfolio" value="<?php echo htmlspecialchars($dj['portfolio']); ?>">
            <br><br>
        </fieldset>

        <br>

        <fieldset>
            <legend>Informations sur l'événement</legend>

            <label for="date_soiree">Date de la soirée :</label>
            <input type="date" id="date_soiree" name="date_soiree" value="<?php echo htmlspecialchars($dj['date_soiree']); ?>">
            <br><br>

            <label for="materiel">Le DJ vient-il avec son matériel ?</label>
            <input type="checkbox" id="materiel" name="materiel" value="1" <?php echo $dj['materiel'] === 'Oui' ? 'checked' : ''; ?>>
            <br><br>

            <label for="couleur">Couleur favorite :</label>
            <input type="color" id="couleur" name="couleur" value="<?php echo htmlspecialchars($dj['couleur']); ?>">
            <br><br>

            <label for="photo">Photo du DJ :</label>
            <input type="file" id="photo" name="photo" accept="image/*">
            <?php if (!empty($dj['photo'])) : ?>
                <br><small>Photo actuelle : <a href="<?php echo htmlspecialchars($dj['photo']); ?>" target="_blank" rel="noopener noreferrer">voir</a></small>
            <?php endif; ?>
            <br><br>
        </fieldset>

        <br>

        <fieldset>
            <legend>Matériel audio</legend>

            <label for="nb_enceintes">Nombre d’enceintes :</label>
            <input type="number" id="nb_enceintes" name="nb_enceintes" min="0" value="<?php echo (int)$dj['nb_enceintes1']; ?>">
            <br><br>

            <label for="puissance">Puissance des enceintes (W) :</label>
            <input type="number" id="puissance" name="puissance" min="0" value="<?php echo (int)$dj['puissance1']; ?>">
            <br><br>
        </fieldset>

        <br>

        <input type="submit" value="Mettre à jour">
    </form>
<?php endif; ?>
</body>
</html>
