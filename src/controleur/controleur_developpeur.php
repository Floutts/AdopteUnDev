<?php

function actionListeDeveloppeur($twig, $db)
{
    $form = array();
    $developpeur = new Developpeur($db);
   
    echo $twig->render('listeDeveloppeur.html.twig', array());

}




?>