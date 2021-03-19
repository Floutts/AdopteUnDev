<?php


class Code
{
    private $db;
    private $insertLangage;
    private $selectByDev;
    private $delete;

     public function __construct($db)
     {
         $this->db = $db;
         $this->delete = $db->prepare("delete from `code` WHERE idDev=:idDev");
         $this->insertLangage = $db->prepare("insert into code(`idDev`, `idLang`) VALUES (:idDev,:idLang)");
         $this->selectByDev = $db->prepare("select idLang,idDev from code where idLang=:idLang and idDev=:idDev");
     }


    public function insertLangage($idDev, $idLang){
        $r = true;
        $this->insertLangage->execute(array(':idDev' => $idDev, ':idLang' => $idLang ));
        if ($this->insertLangage->errorCode() != 0) {
            print_r($this->insertLangage->errorInfo());
            $r = false;
        } return $r;
    }

    public function selectByDev($idLang, $idDev){
        $this->selectByDev->execute(array(':idLang' => $idLang , ':idDev' => $idDev));
        if ($this->selectByDev->errorCode()!=0){
            print_r($this->selectByDev->errorInfo());
        }
        return $this->selectByDev->fetch();
    }

    public function delete($idDev){
        $r = true;
        $this->delete->execute(array(':idDev'=>$idDev));
        if ($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
            $r=false;
        }
        return $r;
    }
}