<?php
class Developpeur {
    private $db;
    private $insert;

    public function __construct($db)
    {
        $this->db = $db;
        $this->insert= $db->prepare("insert into developpeur(email, mdp, nom, prenom, idRole,NbUnique) values(:email, :mdp, :nom, :prenom, :role, :NbUnique)"); ;
    }

    public function insert($email,$mdp,$role,$nom,$prenom,$nbUnique){
        $r = true;
        $this->insert->execute(array(':email' => $email, ':mdp' => $mdp, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom, ':NbUnique' => $nbUnique));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }
}