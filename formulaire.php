<?php
session_start();

if (!isset($_SESSION['nb_visites'])) {
    $_SESSION['nb_visites'] = 1;
} else {
    $_SESSION['nb_visites']++;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Student PARTY CORP - Formulaire</title>
</head>
<body>

<h1>Student PARTY CORP</h1>
<h2>Formulaire d'inscription DJ</h2>

<p>Nombre de visites sur cette page :
    <strong><?php echo $_SESSION['nb_visites']; ?></strong>
</p>

<h3>Envoi avec GET</h3>
<form action="traitement_get.php" method="get">
    <label>Nom :</label>
    <input type="text" name="nom" required><br><br>

    <label>Prénom :</label>
    <input type="text" name="prenom" required><br><br>

    <label>Email :</label>
    <input type="email" name="email" required><br><br>

    <label>Téléphone :</label>
    <input type="text" name="telephone"><br><br>

    <label>URL portfolio :</label>
    <input type="url" name="portfolio"><br><br>

    <label>Date de la soirée :</label>
    <input type="date" name="date_soiree"><br><br>

    <label>Vient avec son matériel ?</label>
    <input type="checkbox" name="materiel" value="Oui"><br><br>

    <label>Couleur favorite :</label>
    <input type="color" name="couleur"><br><br>

    <label>Nombre d’enceintes chaîne 1 :</label>
    <input type="number" name="nb_enceintes1" min="0"><br><br>

    <label>Puissance chaîne 1 :</label>
    <input type="number" name="puissance1" min="0"><br><br>

    <label>Nombre d’enceintes chaîne 2 :</label>
    <input type="number" name="nb_enceintes2" min="0"><br><br>

    <label>Puissance chaîne 2 :</label>
    <input type="number" name="puissance2" min="0"><br><br>

    <input type="submit" value="Envoyer en GET">
</form>

<hr>

<h3>Envoi avec POST</h3>
<form action="traitement_post.php" method="post" enctype="multipart/form-data">
    <label>Nom :</label>
    <input type="text" name="nom" required><br><br>

    <label>Prénom :</label>
    <input type="text" name="prenom" required><br><br>

    <label>Email :</label>
    <input type="email" name="email" required><br><br>

    <label>Téléphone :</label>
    <input type="text" name="telephone"><br><br>

    <label>URL portfolio :</label>
    <input type="url" name="portfolio"><br><br>

    <label>Date de la soirée :</label>
    <input type="date" name="date_soiree"><br><br>

    <label>Vient avec son matériel ?</label>
    <input type="checkbox" name="materiel" value="Oui"><br><br>

    <label>Couleur favorite :</label>
    <input type="color" name="couleur"><br><br>

    <label>Photo :</label>
    <input type="file" name="photo"><br><br>

    <label>Nombre d’enceintes chaîne 1 :</label>
    <input type="number" name="nb_enceintes1" min="0"><br><br>

    <label>Puissance chaîne 1 :</label>
    <input type="number" name="puissance1" min="0"><br><br>

    <label>Nombre d’enceintes chaîne 2 :</label>
    <input type="number" name="nb_enceintes2" min="0"><br><br>

    <label>Puissance chaîne 2 :</label>
    <input type="number" name="puissance2" min="0"><br><br>

    <input type="submit" value="Envoyer en POST">
</form>

</body>
</html>