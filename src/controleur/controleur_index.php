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
    $form = array();
    $form['valide'] = true;
    if (isset($_POST['btConnecter'])) {
        $inputEmail = $_POST['Email'];
        $inputPassword = $_POST['Mdp'];
        $_SESSION['login'] = $inputEmail;
        $_SESSION['role'] = 1;
        header("Location:index.php");
    }
        echo $twig->render('connexion.html.twig', array('form'=>$form));
}

function actionDeconnexion($twig){
    session_unset();
    session_destroy();
    header("Location:index.php");
}

function actionInscription($twig,$db)
{
    $form = array();
    if (isset($_POST['btInscrire'])) {
        $nbUnique = uniqid();
        $email = $_POST['Email'];
        $mdp = $_POST['Mdp'];
        $confMdp = $_POST['ConfMdp'];
        $nom = $_POST['Nom'];
        $prenom = $_POST['Prenom'];
        $role = $_POST['Role'];
        $form['valide'] = true;
        if ($mdp != $confMdp) {
            $form['valide'] = false;
            $form['message'] = 'Les mots de passe sont différents';
        } else {
            $Developpeur = new Developpeur($db);
            $exec = $Developpeur->insert($email, password_hash($mdp, PASSWORD_DEFAULT), $role, $nom, $prenom,$nbUnique);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème d\'insertion dans la table developpeur ';

            }
        }

            $form['email'] = $email;
            $form['role'] = $role;
        }

        echo $twig->render('inscription.html.twig', array('form' => $form));

}

    function actionBd($twig)
    {
        if (isset($_POST['BtDownloadM'])) {
            echo "mysqldump -u login4060 -permsZqJIUvcQzTw AdopteUnDev > ../src/bd/AdopteUnDev.sql";
            shell_exec("mysqldump -u login4060 -permsZqJIUvcQzTw AdopteUnDev > ../src/bd/AdopteUnDev.sql");
            echo(chmod("../src/bd/AdopteUnDev.sql", 0777));
        }
        if (isset($_POST['BtDownloadF'])) {
            echo "mysqldump  -u login4061 -pCHohAQLpbbYXomb AdopteUnDev > ../src/bd/AdopteUnDev.sql";
            shell_exec("mysqldump -u login4061 -pCHohAQLpbbYXomb AdopteUnDev > ../src/bd/AdopteUnDev.sql");
            echo(chmod("../src/bd/AdopteUnDev.sql", 0777));
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

    function actionMaintenance($twig)
    {
        echo $twig->render('maintenance.html.twig');
    }
