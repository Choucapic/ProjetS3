<?php

class Benevole extends Membre{

  /**
  * Le numéro de téléphone du Bénévole
  * @var int
  **/
  protected $numTel;

  /**
  * L'adresse du Bénévole
  * @var String
  **/
  protected $adresse;

  /**
  * Le code postal du Bénévole
  * @var int
  **/
  protected $cp;

  /**
  * La ville du Bénévole
  * @var String
  **/
  protected $ville;

  /**
  * Constructeur du Bénévole
  **/
  public function Benevole(){}

  /**
  * Accesseur sur le numéro de téléphone du Bénévole
  * @return int
  **/
  public function getNumTel(){
    return $this->numTel;
  }

  /**
  * Accesseur sur l'adresse du Bénévole
  * @return String
  **/
  public function getAdresse(){
    return $this->adresse;
  }

  /**
  * Accesseur sur le code postal du Bénévole
  * @return String
  **/
  public function getAdresse(){
    return $this->codePostal;
  }

  /**
  * Accesseur sur la ville du Bénévole
  * @return String
  **/
  public function getVille(){
    return $this->ville;
  }

  /**
  * Accesseur sur l'organisateur ou non Bénévole
  * @return boolean
  **/
  public function getOrganisateur(){
    return $this->organisateur;
  }

  /**
  * Accesseur sur le mot de passe du Bénévole
  * @return String
  **/
  public function getPassword(){
    return $this->password;
  }

  public static function createFromId($idMembre){
     $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idMembre, nom, prnm, mail, numTel, adresse, cp, ville
            FROM Membre
            WHERE idMembre = ?
              AND Type = 'Benevole'
SQL
        ) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__) ;
        $stmt->execute(array($idMembre)) ;
        if (($object = $stmt->fetch()) !== false) {
            return $object ;
        }
        throw new Exception('Ligne non trouvée !') ;
    }
  }

  public static function createEmpty(){
    return new self();
  }

  public static function createFromArray(array $array){
    $self = new self() ;
    foreach ($self as $propriete => $value) {
      if (isset($array[ $propriete ])) {
        $self->$propriete = $array[ $propriete ] ;
      }
    }
    return $self ;
  }

  public function save(){
    $stmt = myPDO::getInstance()->prepare(<<<SQL
                REPLACE INTO `Membre`(`idMembre`, `nom`, `prnm`, `mail`, `numTel`, `adresse`, `cp`, `ville`)
                               VALUES (:idMembre, :nom, :prnm, :mail, :numTel, :adresse, :cp, :ville)
SQL
);
    $stmt->execute(array(':idMembre' => $this ->idMembre,
                         ':nom' => $this ->nom,
                         ':prnm' => $this ->prnm,
                         ':mail' => $this ->mail,
                         ':numTel' => $this ->numTel,
                         ':adresse' => $this ->adresse,
                         ':cp' => $this ->cp,
                         ':ville' => $this ->ville;
            $this->idMembre = myPDO::getInstance()->lastInsertId() ;
    }
}
?>
