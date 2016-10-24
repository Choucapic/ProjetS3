<?php

class Benevole extends Membre{

  /**
  * Le numéro de téléphone du Bénévole
  * @var int
  **/
  protected $_numTel;

  /**
  * L'adresse du Bénévole
  * @var String
  **/
  protected $_adresse;

  /**
  * Le code postal du Bénévole
  * @var int
  **/
  protected $_codePostal;

  /**
  * La ville du Bénévole
  * @var String
  **/
  protected $_ville;

  /**
  * Le Bénévole est un organisateur ou non
  * @var boolean
  **/
  protected $_organisateur;

  /**
  * Le mot de passe du Bénévole
  * @var String
  **/
  protected $_password;

  /**
  * Constructeur du Bénévole
  **/
  public function Benevole(){}

  /**
  * Accesseur sur le numéro de téléphone du Bénévole
  * @return int
  **/
  public function getNumTel(){
    return $this->_numTel;
  }

  /**
  * Accesseur sur l'adresse du Bénévole
  * @return String
  **/
  public function getAdresse(){
    return $this->_adresse;
  }

  /**
  * Accesseur sur la ville du Bénévole
  * @return String
  **/
  public function getVille(){
    return $this->_ville;
  }

  /**
  * Accesseur sur l'organisateur ou non Bénévole
  * @return boolean
  **/
  public function getOrganisateur(){
    return $this->_organisateur;
  }

  /**
  * Accesseur sur le mot de passe du Bénévole
  * @return String
  **/
  public function getPassword(){
    return $this->_password;
  }
}
?>
