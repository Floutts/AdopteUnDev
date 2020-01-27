<?php
function getPage($db){

    $lesPages['accueil'] = "actionAccueil";
    $lesPages['apropos'] = "actionApropos";
    $lesPages['mentions'] = "actionMentions";
    $lesPages['contact'] = "actionContact";
    $lesPages['profil'] = "actionProfil";
    $lesPages['modif-profil'] = "actionModifprofil";
    $lesPages['connexion'] = "actionConnexion";
    $lesPages['inscription'] = "actionInscription";
    $lesPages['bd'] = "actionBd";
    $lesPages['maintenance'] = "actionMaintenance";
    $lesPages['deconnexion'] = "actionDeconnexion";
    $lesPages['validation'] = "actionValidation";


    if ($db!=null) {
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 'accueil';
    }
    if (!isset($lesPages[$page])) {
        $page = 'accueil';
    }
    $contenu = $lesPages[$page];
}
else{
    $contenu = $lesPages['maintenance'];
}

    return $contenu;

}
?>