<?php

function actionAccueil($twig) {
    echo $twig->render('index.html.twig', array());
}

function actionApropos($twig) {
    echo $twig->render('apropos.html.twig', array());
}

function actionMentions($twig) {
    echo $twig->render('mentions.html.twig', array());
}

function actionContact($twig) {
    echo $twig->render('contact.html.twig', array());
}

function actionProfil($twig) {
    echo $twig->render('profil.html.twig', array());
}

function actionConnexion($twig) {
    echo $twig->render('connexion.html.twig', array());
}

function actionInscription($twig) {
    echo $twig->render('inscription.html.twig',array());
}
function actionBd($twig){
    if (isset($_POST['BtUploadM'])) {
        shell_exec("mysqldump –nodate -u login4060 -permsZqJIUvcQzTw AdopteUnDev > /bd/AdopteUnDev.sql");
    }
    if (isset($_POST['BtUploadF'])) {
        shell_exec("mysqldump –nodate -u login4061 -pCHohAQLpbbYXomb AdopteUnDev > /bd/AdopteUnDev.sql");
    }
    if (isset($_POST['BtDownloadM'])) {
        shell_exec("mysql -u login4060 --password=ermsZqJIUvcQzTw AdopteUnDev < /bd/AdopteUnDev.sql");
    }
    if (isset($_POST['BtDownloadF'])) {
        shell_exec("mysql -u login4061 --password=CHohAQLpbbYXomb AdopteUnDev < /bd/AdopteUnDev.sql");
    }
    echo $twig->render('bd.html.twig', array());


}
