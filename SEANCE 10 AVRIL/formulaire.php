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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student PARTY CORP - Formulaire</title>
</head>
<body>

<h1>Student PARTY CORP</h1>
<h2>Formulaire d'inscription DJ</h2>

<p>
    Nombre de visites sur cette page :
    <strong><?php echo $_SESSION['nb_visites']; ?></strong>
</p>

<h3>Envoi avec GET</h3>
<form action="traitement_get.php" method="get">

    <fieldset>
        <legend>Informations personnelles</legend>

        <label for="nom_get">Nom :</label>
        <input type="text" id="nom_get" name="nom" required>
        <br><br>

        <label for="prenom_get">Prénom :</label>
        <input type="text" id="prenom_get" name="prenom" required>
        <br><br>

        <label for="email_get">E-mail :</label>
        <input type="email" id="email_get" name="email" required>
        <br><br>

        <label for="telephone_get">Numéro de téléphone :</label>
        <input type="tel" id="telephone_get" name="telephone">
        <br><br>

        <label for="portfolio_get">URL du portfolio :</label>
        <input type="url" id="portfolio_get" name="portfolio">
        <br><br>
    </fieldset>

    <br>

    <fieldset>
        <legend>Informations sur l'événement</legend>

        <label for="date_soiree_get">Date de la soirée :</label>
        <input type="date" id="date_soiree_get" name="date_soiree">
        <br><br>

        <label for="materiel_get">Le DJ vient-il avec son matériel ?</label>
        <input type="checkbox" id="materiel_get" name="materiel" value="Oui">
        <br><br>

        <label for="couleur_get">Couleur favorite :</label>
        <input type="color" id="couleur_get" name="couleur">
        <br><br>
    </fieldset>

    <br>

    <fieldset>
        <legend>Matériel audio</legend>

        <h4>Chaîne 1</h4>

        <label for="nb_enceintes1_get">Nombre d’enceintes :</label>
        <input type="number" id="nb_enceintes1_get" name="nb_enceintes1" min="0">
        <br><br>

        <label for="puissance1_get">Puissance (W) :</label>
        <input type="number" id="puissance1_get" name="puissance1" min="0">
        <br><br>

        <h4>Chaîne 2</h4>

        <label for="nb_enceintes2_get">Nombre d’enceintes :</label>
        <input type="number" id="nb_enceintes2_get" name="nb_enceintes2" min="0">
        <br><br>

        <label for="puissance2_get">Puissance (W) :</label>
        <input type="number" id="puissance2_get" name="puissance2" min="0">
        <br><br>
    </fieldset>

    <br>

    <input type="submit" value="Envoyer en GET">
    <input type="reset" value="Réinitialiser">
</form>

<hr>

<h3>Envoi avec POST</h3>
<form action="enregistrer.php" method="post" enctype="multipart/form-data">

    <fieldset>
        <legend>Informations personnelles</legend>

        <label for="nom_post">Nom :</label>
        <input type="text" id="nom_post" name="nom" required>
        <br><br>

        <label for="prenom_post">Prénom :</label>
        <input type="text" id="prenom_post" name="prenom" required>
        <br><br>

        <label for="email_post">E-mail :</label>
        <input type="email" id="email_post" name="email" required>
        <br><br>

        <label for="telephone_post">Numéro de téléphone :</label>
        <input type="tel" id="telephone_post" name="telephone">
        <br><br>

        <label for="portfolio_post">URL du portfolio :</label>
        <input type="url" id="portfolio_post" name="portfolio">
        <br><br>
    </fieldset>

    <br>

    <fieldset>
        <legend>Informations sur l'événement</legend>

        <label for="date_soiree_post">Date de la soirée :</label>
        <input type="date" id="date_soiree_post" name="date_soiree">
        <br><br>

        <label for="materiel_post">Le DJ vient-il avec son matériel ?</label>
        <input type="checkbox" id="materiel_post" name="materiel" value="Oui">
        <br><br>

        <label for="couleur_post">Couleur favorite :</label>
        <input type="color" id="couleur_post" name="couleur">
        <br><br>

        <label for="photo_post">Photo :</label>
        <input type="file" id="photo_post" name="photo" accept="image/*">
        <br><br>
    </fieldset>

    <br>

    <fieldset>
        <legend>Matériel audio</legend>

        <h4>Chaîne 1</h4>

        <label for="nb_enceintes1_post">Nombre d’enceintes :</label>
        <input type="number" id="nb_enceintes1_post" name="nb_enceintes1" min="0">
        <br><br>

        <label for="puissance1_post">Puissance (W) :</label>
        <input type="number" id="puissance1_post" name="puissance1" min="0">
        <br><br>

        <h4>Chaîne 2</h4>

        <label for="nb_enceintes2_post">Nombre d’enceintes :</label>
        <input type="number" id="nb_enceintes2_post" name="nb_enceintes2" min="0">
        <br><br>

        <label for="puissance2_post">Puissance (W) :</label>
        <input type="number" id="puissance2_post" name="puissance2" min="0">
        <br><br>
    </fieldset>

    <br>

    <input type="submit" value="Envoyer en POST">
    <input type="reset" value="Réinitialiser">
</form>

<hr>

<h3>Suppression d'un DJ par email</h3>
<form action="supprimer.php" method="post">
    <label for="email_suppression">Email à supprimer :</label>
    <input type="email" id="email_suppression" name="email" required>
    <input type="submit" value="Supprimer">
</form>

</body>
</html>
