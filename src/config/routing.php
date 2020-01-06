<?php
function getPage(){

    $lesPages['accueil'] = "actionAccueil";
    $lesPages['apropos'] = "actionApropos";
    $lesPages['mentions'] = "actionMentions";
    $lesPages['contact'] = "actionContact";
    $lesPages['profil'] = "actionProfil";
    $lesPages['connexion'] = "actionConnexion";

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    else{
        $page = 'accueil';
    }
    if (!isset($lesPages[$page])){
        $page = 'accueil';
    }
    $contenu = $lesPages[$page];
    return $contenu;

}
?>