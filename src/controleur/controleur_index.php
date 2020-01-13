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
    if (isset($_POST['BtDownloadM'])) {
        echo "mysqldump –-no-data -u login4060 -permsZqJIUvcQzTw AdopteUnDev > ../src/bd/AdopteUnDev.sql";
        shell_exec("mysqldump -u login4060 -permsZqJIUvcQzTw AdopteUnDev > ../src/bd/AdopteUnDev.sql");
    }
    if (isset($_POST['BtDownloadF'])) {
        echo "mysqldump –-no-data -u login4061 -pCHohAQLpbbYXomb AdopteUnDev > ../src/bd/AdopteUnDev.sql";
        shell_exec("mysqldump -u login4061 -pCHohAQLpbbYXomb AdopteUnDev > ../src/bd/AdopteUnDev.sql");
    }
    if (isset($_POST['BtUploadM'])) {
        echo "mysql -u login4060 --password=ermsZqJIUvcQzTw AdopteUnDev < ../src/bd/AdopteUnDev.sql";
        shell_exec("mysql -u login4060 --password=ermsZqJIUvcQzTw AdopteUnDev < ../src/bd/AdopteUnDev.sql");
    }
    if (isset($_POST['BtUploadF'])) {
        echo "mysql -u login4061 --password=CHohAQLpbbYXomb AdopteUnDev < ../bd/AdopteUnDev.sql";
        shell_exec("mysql -u login4061 --password=CHohAQLpbbYXomb AdopteUnDev < ../src/bd/AdopteUnDev.sql");
    }
    echo $twig->render('bd.html.twig', array());


}
