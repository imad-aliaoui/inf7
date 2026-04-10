<?php
function afficher($nombres) {
    $pairs = [];
    $impairs = [];

    foreach ($nombres as $n) {
        if ($n % 2 == 0) {
            $pairs[] = $n;
        } else {
            $impairs[] = $n;
        }
    }

    sort($pairs);        // ordre croissant
    rsort($impairs);     // ordre décroissant

    echo "Nombres pairs (croissant) : ";
    print_r($pairs);
    echo "Nombres impairs (décroissant) : ";
    print_r($impairs);
}

$nombres = [5, 2, 9, 8, 1, 4, 7, 6];
afficher($nombres);
