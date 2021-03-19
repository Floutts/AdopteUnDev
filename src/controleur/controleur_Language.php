<?php

function actionAjoutLangages($twig, $db)
{
    $form = array();
    $langage = new Langage($db);
    if (isset($_POST['btAjouterLang'])) {
        $libelle = $_POST['langage'];
        $form['libelle'] = $libelle;
        $exec = $langage->insert($libelle);

    }

    $liste = $langage->select();

    if(isset($_GET['idsup'])){
        $exec = $langage->deleteLink($_GET['idsup']);
        $exec2 = $langage->deleteById($_GET['idsup']);
        if (!$exec){
            $form['supprimer'] = false;
            $form['message'] = 'Problème de suppression dans la table code';
        }
        else{
            $form['supprimer'] = true;
            $form['message'] = 'Code supprimé avec succès';
        }
        if (!$exec2){
            $form['supprimer'] = false;
            $form['message'] = 'Problème de suppression dans la table langage';
        }
        else{
            $form['supprimer'] = true;
            $form['message'] = 'Langage supprimé avec succès';
        }
    }
    echo $twig->render('ajoutLangages.html.twig', array('form' => $form, 'liste' => $liste));

}




?>