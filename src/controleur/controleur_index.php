<?php

function actionAccueil($twig) {
        var_dump($_SESSION);
    echo $twig->render('index.html.twig', array());
}

function actionApropos($twig) {
    echo $twig->render('apropos.html.twig', array());
}

function actionMentions($twig) {
    echo $twig->render('mentions.html.twig', array());
}

function actionLangages($twig,$db) {
    $form = array();
    $langage = new Langage($db);
    if (isset($_POST['btAjouterLang'])) {
        $libelle = $_POST['langage'];
        $form['libelle'] = $libelle ;
        $exec = $langage->insert($libelle);

    }

    $liste = $langage -> select();
        echo $twig->render('ajoutLangages.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionContact($twig) {
    echo $twig->render('contact.html.twig', array());
}

function actionModifprofil($twig,$db){
    $form = array();
    $unDeveloppeur=NULL;
    $langage = new Langage($db);
    $code = new Code($db);
    if (isset($_SESSION['login'])) {
        $developpeur = new Developpeur($db);
        $unDeveloppeur = $developpeur->selectByEmail($_SESSION['login']);
        $liste = $langage -> select();
        var_dump($_POST);
        if (isset($_POST['btModifier'])){
            $idDev = $unDeveloppeur['id'];
            $langageConnu = $_POST['langage'] ;
            $form['valide']=true;
            foreach ($langageConnu as $idLang){
                echo $idDev.' '.$idLang;
                $unLangage = $code ->selectByDev($idLang,$idDev);
                if ($unLangage == NULL){
                    $exec = $code->insertLangage($idDev, $idLang);
                    if (!$exec) {
                        $form['valide'] = false;
                        $form['message'] = "problème d'insertion dans la table";
                    }
                }
            }
        }
    }

        echo $twig->render('modif-profil.html.twig', array('unDeveloppeur'=>$unDeveloppeur, 'liste' => $liste));

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
        $developpeur = new Developpeur($db);
        $unDeveloppeur=$developpeur->connect($Email);

        if($unDeveloppeur!=null){
            if(!password_verify($Mdp,$unDeveloppeur['mdp'])){
                $form['valide']=false;
                $form['message']='Login ou mot de passe incorrect';
            }
            else{
                if ($unDeveloppeur['validation'] == 0){

                    $form['valide']=false;
                    $form['valideEmail']=false;
                    $form['message']="Votre email n'a pas été vérifié";

                }else{
                    $_SESSION['login'] = $Email;
                    $_SESSION['role'] = $unDeveloppeur['idRole'];
                   // var_dump($unDeveloppeur);
                    header("Location:index.php");
                }

            }
        }
        else{
            $form['valide']=false;
            $form['message'] ='Login ou mot de passe incorrect';
        }
    }
    if (isset($_POST['btRenvoi'])){
        $form['renvoi'] = false;
    }
    if (isset($_POST['btRenvoiEmail'])) {
        $Email = $_POST['Email'];
        $developpeur = new Developpeur($db);
        $unDeveloppeur=$developpeur->selectByEmail($Email);
        if ($unDeveloppeur != NULL) {

            $email = $unDeveloppeur['email'];
            $nbUnique = $unDeveloppeur['nbUnique'];

            $serveur = $_SERVER['HTTP_HOST'];
            $script = $_SERVER["SCRIPT_NAME"];
            $message = "
            <html>
                <head>
                </head>
                <body>
                Bienvenue sur AdopteUnDev, Pour confirmer votre inscription, veuillez cliquer sur le lien ci contre           
                <a href=http://$serveur$script?page=validation&email=$email&nbUnique=$nbUnique'>Valider votre inscription</a>
                </body>
            </html>";
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            //$message = wordwrap($message, 70, "\r\n");
            mail($email, 'Inscription AdopteUnDev', $message, implode("\n", $headers));
            $form['renvoi'] = false;
            $form['EmailValide'] = true;
            $form['message'] = "Un mail a été renvoyé";
        } else{
            $form['renvoi'] = false;
            $form['EmailValide'] = false;
            $form['message'] = "Vous n'êtes pas inscrit, veuillez vous inscrire";
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
            $serveur = $_SERVER['HTTP_HOST'];
            $script = $_SERVER["SCRIPT_NAME"];
            $message = "
            <html>
                <head>
                </head>
                <body>
                Bienvenue sur AdopteUnDev, Pour confirmer votre inscription, veuillez cliquer sur le lien ci contre           
                <a href=http://$serveur$script?page=validation&email=$email&nbUnique=$nbUnique'>Valider votre inscription</a>
                </body>
            </html>"
             ;
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
                $exec = $developpeur->updateValidation($_GET['email']);
                if (!$exec){
                    $form['valide'] = false;
                    $form['message'] = 'Validation échouée (update)';
                } else{
                    $form['valide'] = true;
                    $form['message'] = 'Validation Réussie';
                }
            }
            else{
                $form['message'] = 'Validation échouée (nbUnique)';
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


    function ActionRecup($twig,$db){
    $form = array();

    if(isset($_POST['btMail'])){
        $form['valide'] = true;
        $developpeur = new Developpeur($db);
        $unDeveloppeur = $developpeur->selectByEmail($_POST['Email']);
        if ($unDeveloppeur!=null){
                $email = $_POST['Email'];
                $form['message'] = "Un email à été envoyé à l'adresse suivante : $email ";
            $serveur = $_SERVER['HTTP_HOST'];
            $script = $_SERVER["SCRIPT_NAME"];
            $message = "
            <html>
                <head>
                </head>
                <body>
                Bonjour, pour modifier votre mot de passe, veuillez cliquer sur le lien ci contre           
                <a href='http://$serveur$script?page=modifMdp&email=$email'>Modifier le mot de passe</a>
                </body>
            </html>
             ";
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            //$message = wordwrap($message, 70, "\r\n");
            mail($email, 'Inscription AdopteUnDev', $message, implode("\n",$headers));
            }
            else{
                $form['message'] = "Vous n'êtes pas inscrit";
                $form['valide'] = false;
            }
    }
    echo $twig->render('recupMdp.html.twig', array('form'=>$form));
}
function actionModifMdp($twig,$db){
    $form = array();
    if (isset($_GET['email']))
        $form['email'] = $_GET['email'];

    if (isset($_POST['btModif'])) {
        $email = $_POST['Email'];
        $mdp = $_POST['Mdp'];
        $confMdp = $_POST['ConfMdp'];
        $form['valide'] = true;
        if ($mdp != $confMdp) {
            $form['valide'] = false;
            $form['message'] = 'Les mots de passe sont différents';
        } else {
            $Developpeur = new Developpeur($db);
            $exec = $Developpeur->updateMdp($email,$mdp);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème de changement de mot de passe ';
            }
        }
    }
    echo $twig->render('modifMdp.html.twig',array('form'=>$form));
}
