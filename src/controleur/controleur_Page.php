<?php


function actionAccueil($twig)
{
    //var_dump($_SESSION);
    echo $twig->render('index.html.twig', array());
}

function actionApropos($twig)
{
    echo $twig->render('apropos.html.twig', array());
}

function actionMentions($twig)
{
    echo $twig->render('mentions.html.twig', array());
}

function actionContact($twig)
{
    echo $twig->render('contact.html.twig', array());
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


function actionModifMdp($twig, $db)
{
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
            $exec = $Developpeur->updateMdp($email, password_hash($mdp, PASSWORD_DEFAULT));
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème de changement de mot de passe ';
            } else{
                $form['valide'] = true;
                $form['message'] = 'Votre mot de passe a bien été modifié';
            }
        }
    }
    echo $twig->render('modifMdp.html.twig', array('form' => $form));
}
