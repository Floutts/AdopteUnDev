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

function actionModifprofil($twig,$db){
    $form = array();
    $unDeveloppeur=NULL;
    $developpeur = new Developpeur($db);
    $unDeveloppeur = $developpeur->selectByEmail($_SESSION['login']);

        echo $twig->render('modif-profil.html.twig', array());

}

function actionProfil($twig, $db){
    $form = array();
    $unDeveloppeur=NULL;
    if (isset($_SESSION['login'])) {
        $developpeur = new Developpeur($db);
        $unDeveloppeur = $developpeur->selectByEmail($_SESSION['login']);

    }

    echo $twig->render('profil.html.twig', array('unDeveloppeur'=>$unDeveloppeur));
}

function actionConnexion($twig,$db) {
    $form = array();
    $form['valide'] = true;
    if (isset($_POST['btConnecter'])) {
        $Email = $_POST['Email'];
        $Mdp = $_POST['Mdp'];
        $_SESSION['login'] = $Email;
        $_SESSION['role'] = 1;
        $developpeur = new Developpeur($db);
        $unDeveloppeur=$developpeur->connect($Email);
        if($unDeveloppeur!=null){
            if(!password_verify($Mdp,$unDeveloppeur['mdp'])){
                $form['valide']=false;
                $form['message']='Login ou mot de passe incorrect';
            }
            else{
                $_SESSION['login'] = $Email;
                $_SESSION['role'] = $unDeveloppeur['idRole'];
                header("Location:index.php");
            }
        }
        else{
            $form['valide']=false;
            $form['message'] ='Login ou mot de passe incorrect';
        }
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
        $valide = false;
        $form['valide'] = true;
        if ($mdp != $confMdp) {
            $form['valide'] = false;
            $form['message'] = 'Les mots de passe sont différents';
        } else {
            $dateInscrit=date("Y-m-d H:i:s");
            $Developpeur = new Developpeur($db);
            $exec = $Developpeur->insert($email, password_hash($mdp, PASSWORD_DEFAULT), $role, $nom, $prenom,$nbUnique,$valide,$dateInscrit);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème d\'insertion dans la table developpeur ';

            }
            $message = "
            <html>
                <head>
                </head>
                <body>
                Bienvenue sur AdopteUnDev, Pour confirmer votre inscription, veuillez cliquer sur le lien ci contre           
                <a href='http://serveur1.arras-sio.com/symfony4-4060/AdopteUnDev/web/index.php?page=validation&email=$email&nbUnique=$nbUnique'>Valider votre inscription</a>
                </body>
            </html>
             ";
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            //$message = wordwrap($message, 70, "\r\n");
            mail($email, 'Inscription AdopteUnDev', $message, implode("\n",$headers));
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

    function actionValidation($twig,$db){
        $form = array();
        if(isset($_GET['email'])){
            $developpeur = new Developpeur($db);
            $unDeveloppeur = $developpeur->selectByEmail($_GET['email']);
            if ($unDeveloppeur!=null){
                if ( $unDeveloppeur['nbUnique'] == $_GET['nbUnique']){
                    $exec = $developpeur->update($_GET['email']);
                        if (!$exec){
                            $form['valide'] = false;
                            $form['message'] = 'Validation échouée';
                        } else{
                            $form['valide'] = true;
                            $form['message'] = 'Validation Réussie';
                        }
                }
                else{
                    $form['message'] = 'Validation échouée';
                }
            }
            else{
                $form['message'] = 'Utilisateur incorrect';
            }
        }
        else{
            $form['message'] = 'Utilisateur non précisé';
        }
        echo $twig->render('validation.html.twig', array('form'=>$form));
    }


