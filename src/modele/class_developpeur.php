<?php
class Developpeur {
    private $db;
    private $insert;
    private $connect;
    private $select;
    private $selectByEmail;
    private $update;

    public function __construct($db)
    {
        $this->db = $db;
        $this->insert= $db->prepare("insert into developpeur(email, mdp, nom, prenom, idRole,NbUnique,validation) values(:email, :mdp, :nom, :prenom, :role, :NbUnique, :validation)"); ;
        //$this->select= $db->prepare("")
        $this->selectByEmail = $db->prepare("select email,nbUnique from developpeur d where email=:email");
        $this->update= $db->prepare("update developpeur set validation=true where email=:email ");
        $this->connect= $db->prepare("select email, mdp from developpeur where email=:email");

    }


    public function insert($email,$mdp,$role,$nom,$prenom,$nbUnique,$valide){
        $r = true;
        $this->insert->execute(array(':email' => $email, ':mdp' => $mdp, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom, ':NbUnique' => $nbUnique,':validation' => $valide));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        } return $r;
    }

    public function selectByEmail($email){
        $this->selectByEmail->execute(array(':email'=>$email));
        if ($this->selectByEmail->errorCode()!=0){
            print_r($this->selectByEmail->errorInfo());
        }
        return $this->selectByEmail->fetch();
    }

    public function update($email){
        $r = true;
        $this->update->execute(array(':email'=>$email));
        if ($this->update->errorCode()!=0){
            print_r($this->update->errorInfo());
            $r=false;
        }
        return $r;
    }

    public function connect($email){
        $this->connect->execute(array(':email'=>$email));
        if ($this->connect->errorCode()!=0){
            print_r($this->connect->errorInfo());
        }
        return $this -> connect -> fetch() ;
    }
}