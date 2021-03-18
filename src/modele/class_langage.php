<?php

class Langage
{

    private $db;
    private $insert;
    private $select;
    private $deleteById;
    private $deleteLink;
    private $selectByDev;



    public function __construct($db)
    {
        $this->db = $db;
        $this->insert = $db->prepare("insert into langage(libelle) VALUES (:libelle)");
        $this->select = $db->prepare("SELECT id, libelle FROM langage l order by libelle ");
        $this->deleteById = $db->prepare("delete from langage where id = :id ");
        $this->deleteLink = $db->prepare("delete from code where idLang = :id ");
        $this->selectByDev = $db->prepare("select l.libelle from langage l inner join code on code.idLang = l.id inner join developpeur d on d.id = code.idDev WHERE d.email = :email");

    }

    public function insert($libelle)
    {
        $r = true;
        $this->insert->execute(array(':libelle' => $libelle));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function select(){
        $this->select->execute() ;
        if ($this->select->errorCode() !=0){
            print_r($this->select->errorInfo()) ;
        }
        return $this->select->fetchAll() ;
    }

    public function deleteById($id){
        $r = true;
        $this->deleteById->execute(array(':id'=>$id));
        if ($this->deleteById->errorCode()!=0){
            print_r($this->deleteById->errorInfo());
            $r=false;
        }
        return $r;
    }

    public function deleteLink($id){
        $r = true;
        $this->deleteLink->execute(array(':id'=>$id));
        if ($this->deleteLink->errorCode()!=0){
            print_r($this->deleteLink->errorInfo());
            $r=false;
        }
        return $r;
    }

    public function selectByDev($email){
        $this->selectByDev->execute(array(':email' => $email));
        if ($this->selectByDev->errorCode()!=0){
            print_r($this->selectByDev->errorInfo());
        }
        return $this->selectByDev->fetchAll();
    }

}


