<?php

abstract class Membre{

  /**
  * L'id du Membre
  * @var int
  **/
  abstract protected $_idMembre;

  /**
  * Le nom du Membre
  * @var
  **/
  abstract protected $_nom;

  /**
  * Le prénom du Membre
  * @var String
  **/
  abstract protected $_prnm;

  /**
  * Le mail du Membre
  * @var String
  **/
  abstract protected $_mail;

  /**
  * Accesseur de l'id du Membre
  * @return int
  **/
  public function getIdMembre(){
    return $this->_idMembre;
  }

  /**
  * Accesseur du nom du Membre
  * @return String
  **/
  public function getNom(){
    return $this->_nom;
  }

  /**
  * Accesseur du prénom du Membre
  * @return String
  **/
  public function getPrenom(){
    return $this->_prnm;
  }

  /**
  * Accesseur du mail du Membre
  * @return String 
  **/
  public function getMail(){
    return $this->_mail;
  }
}
?>
