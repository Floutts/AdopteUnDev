<?php

function actionLangages($twig,$db){
    $langage = new Langage($db);
    $json = json_encode($liste = $langage->select());
    echo $json;
}
