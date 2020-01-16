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
    $form = array();
    if (isset($_POST['btInscrire'])){
        echo "fdsfse";
        $Email = $_POST['Email'];
        $Mdp = $_POST['Mdp'];
        $ConfMdp =$_POST['ConfMdp'];
        $Nom = $_POST['Nom'];
        $Prenom = $_POST['Prenom'];
        //$Role = $_POST['Role'];
        $form['valide'] = true;
        if ($Mdp!=$ConfMdp){
            $form['valide'] = false;
            $form['message'] = 'Les mots de passe sont différents';
        }

        $form['email'] = $Email;
      //  $form['role'] = $role;
    }

    echo $twig->render('inscription.html.twig',array('form'=>$form));
}
function actionBd($twig){
    if (isset($_POST['BtDownloadM'])) {
        echo "mysqldump -u login4060 -permsZqJIUvcQzTw AdopteUnDev > ../src/bd/AdopteUnDev.sql";
        shell_exec("mysqldump -u login4060 -permsZqJIUvcQzTw AdopteUnDev > ../src/bd/AdopteUnDev.sql");
        echo (chmod("../src/bd/AdopteUnDev.sql",0777));
    }
    if (isset($_POST['BtDownloadF'])) {
        echo "mysqldump  -u login4061 -pCHohAQLpbbYXomb AdopteUnDev > ../src/bd/AdopteUnDev.sql";
        shell_exec("mysqldump -u login4061 -pCHohAQLpbbYXomb AdopteUnDev > ../src/bd/AdopteUnDev.sql");
        echo (chmod("../src/bd/AdopteUnDev.sql",0777));
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

function actionMaintenance($twig){
    echo $twig->render('maintenance.html.twig');
}