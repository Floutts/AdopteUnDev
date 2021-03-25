<?php
class Developpeur {
    private $db;
    private $insert;
    private $connect;
    private $select;
    private $selectByEmail;
    private $updateValidation;
    private $updateMdp;
    private $selectByDep;

    public function __construct($db)
    {
        $this->db = $db;
        $this->insert= $db->prepare("insert into developpeur(email, mdp, nom, prenom,codeDepartement,codeCommune, idRole,NbUnique,validation,dateInscrit) values(:email, :mdp, :nom, :prenom,:departement,:commune, :role, :NbUnique, :validation, :dateInscrit)"); ;
        $this->select= $db->prepare("select  `nom`, `prenom`, `email` FROM developpeur d WHERE email=:email");
        $this->selectByEmail = $db->prepare("select * from developpeur d where email=:email"); // penserz a utiliser select by email pour le profil et mettre tout ce qu'on veux dedans .
        $this->selectByDep = $db->prepare("select * from developpeur d where codeDepartement=:codeDepartement"); // penserz a utiliser select by email pour le profil et mettre tout ce qu'on veux dedans .
        $this->updateValidation= $db->prepare("update developpeur set validation=true where email=:email ");
        $this->connect= $db->prepare("select email, mdp ,idRole, validation from developpeur where email=:email");
        $this->updateMdp= $db->prepare("update developpeur set mdp=:mdp where email=:email");
    }


    public function insert($email,$mdp,$role,$nom,$prenom,$departement,$commune,$nbUnique,$valide,$dateInscrit){
        $r = true;
        $this->insert->execute(array(':email' => $email, ':mdp' => $mdp, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom,':departement' => $departement,':commune' => $commune, ':NbUnique' => $nbUnique,':validation' => $valide,':dateInscrit' => $dateInscrit));
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

    public function selectByDep($codeDepartement){
        $this->selectByDep->execute(array(':codeDepartement'=>$codeDepartement));
        if ($this->selectByDep->errorCode()!=0){
            print_r($this->selectByDep->errorInfo());
        }
        return $this->selectByDep->fetchAll();
    }

//    public function select($email){
//        $liste = $this->select->execute(array(':email'=>$email));
//        if ($this->select->errorCode()!=0){
//            print_r($this->select->errorInfo());
//        }
//        return $this->select->fetch();
//
//    }

    public function updateValidation($email){
        $r = true;
        $this->updateValidation->execute(array(':email'=>$email));
        if ($this->updateValidation->errorCode()!=0){
            print_r($this->updateValidation->errorInfo());
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

    public function updateMdp($email,$mdp){
        $r = true;
        $this->updateMdp->execute(array(':email'=>$email,':mdp'=>$mdp));
        if ($this->updateMdp->errorCode()!=0){
            print_r($this->updateMdp->errorInfo());
            $r=false;
        }
        return $r;
    }
}