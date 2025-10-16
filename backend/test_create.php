<?php
$_POST['titre'] = 'Event Test Auto Sfax';
$_POST['description'] = 'Test création auto avec notifs pour Sfax ! Rejoignez-nous pour une action locale.';
$_POST['categorie'] = 1;
$_POST['pays'] = 'Tunisie';
$_POST['ville'] = 'Sfax';

$_SERVER["REQUEST_METHOD"] = "POST";  // Force POST

include 'signalement.php';  // Le bon fichier
?>