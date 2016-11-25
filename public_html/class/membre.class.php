<?php

  abstract class Membre{

  /**
  * L'id du Membre
  * @var int
  **/
  protected $idMembre;

  /**
  * Le nom du Membre
  * @var
  **/
    protected $nom;

  /**
  * Le prénom du Membre
  * @var String
  **/
    protected $prnm;

  /**
  * Le mail du Membre
  * @var String
  **/
    protected $mail;

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
