<?php

function actionModifprofil($twig,$db){
    $form = array();
    $unDeveloppeur=NULL;
    $langage = new Langage($db);
    $code = new Code($db);
    if (isset($_SESSION['login'])) {
        $developpeur = new Developpeur($db);
        $unDeveloppeur = $developpeur->selectByEmail($_SESSION['login']);
        $liste = $langage -> select();
        if (isset($_POST['btModifier'])){
            $idDev = $unDeveloppeur['id'];
            if(isset($_POST['langage'])){
                $langageConnu = $_POST['langage'] ;

            }else{
                $langageConnu = NULL;
            }
            $form['valide']=true;
            $exec = $code->delete($idDev);
            if (!$exec){
                $form['valide'] = false;
                $form['message'] = "problème d'insertion dans la table";
            }
            if($langageConnu != NULL){
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

            if ($form['valide'] != false){
                $form['valide'] = true;
                $form['message'] = "Modification reussi";

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

