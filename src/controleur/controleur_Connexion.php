<?php
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
            </html>"
        ;
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        //$message = wordwrap($message, 70, "\r\n");
        mail($email, 'Inscription AdopteUnDev', $message, implode("\n",$headers));
        $form['renvoi']=true;
        $form['message']= "Un mail a été renvoyé";

    }

    echo $twig->render('connexion.html.twig', array('form'=>$form));
}

function actionDeconnexion($twig){
    session_unset();
    session_destroy();
    header("Location:index.php");
}