<?php



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
        $departement = $_POST['departements'];
        $commune = $_POST['communes'];
        $role = $_POST['Role'];
        $valide = 0;
        $form['valide'] = true;
        if ($mdp != $confMdp) {
            $form['valide'] = false;
            $form['message'] = 'Les mots de passe sont différents';
        } else {
            $dateInscrit=date("Y-m-d H:i:s");
            $Developpeur = new Developpeur($db);
            $exec = $Developpeur->insert($email, password_hash($mdp, PASSWORD_DEFAULT), $role, $nom, $prenom,$departement,$commune,$nbUnique,$valide,$dateInscrit);
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
                <a href='http://$serveur$script?page=validation&email=$email&nbUnique=$nbUnique'>Valider votre inscription</a>
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