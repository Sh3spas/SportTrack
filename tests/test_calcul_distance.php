<?php

require_once "functions/CalculDistanceImpl.php";

use functions\CalculDistanceImpl as CalculDistanceImpl;

// Lecture du fichier JSON
$json = file_get_contents("tests/Activite1.json");

// Décodage du fichier JSON
$activite = json_decode($json, true);

// Calcul de la distance
$calculDistance = new CalculDistanceImpl();
$distance = $calculDistance->calculDistanceTrajet($activite["data"]);

// Affichage de la distance
echo "Distance parcourue : " . $distance . " km\n";
