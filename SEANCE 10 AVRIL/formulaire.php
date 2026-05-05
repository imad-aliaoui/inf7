<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('formulaire.twig', [
    'form_action' => 'enregistrer.php',
    'admin_url' => 'admin_djs.php',
]);
