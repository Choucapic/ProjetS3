<?php

abstract class Membre{

  /**
  * L'id du Membre
  * @var int
  **/
  abstract protected $idMembre;

  /**
  * Le nom du Membre
  * @var
  **/
  abstract protected $nom;

  /**
  * Le prénom du Membre
  * @var String
  **/
  abstract protected $prnm;

  /**
  * Le mail du Membre
  * @var String
  **/
  abstract protected $mail;

  /**
  * Accesseur de l'id du Membre
  * @return int
  **/
  public function getIdMembre(){
    return $this->idMembre;
  }

  /**
  * Accesseur du nom du Membre
  * @return String
  **/
  public function getNom(){
    return $this->nom;
  }

  /**
  * Accesseur du prénom du Membre
  * @return String
  **/
  public function getPrenom(){
    return $this->prnm;
  }

  /**
  * Accesseur du mail du Membre
  * @return String 
  **/
  public function getMail(){
    return $this->mail;
  }
}
?>
