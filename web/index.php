<?php
session_start();
/* initialisation des fichiers TWIG */
require_once '../src/lib/vendor/autoload.php';
require_once '../src/config/routing.php';
require_once '../src/controleur/controleur_index.php';

$loader = new Twig_Loader_Filesystem('../src/vue/');
$twig = new Twig_Environment($loader, array());
$twig->addGlobal('session', $_SESSION);
$contenu = getPage();
// Exécution de la fonction souhaitée 
$contenu($twig);
?>