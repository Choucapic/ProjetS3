<?php

class Arbitre extends Membre{


  protected $numTel;
  
  protected $numLicence;
  
  protected $niveauMax;

  public function getNumTel(){
    return $this->numTel;
  }

  public function setNumTel($numTel){
    $this->numTel = $numTel;
  }

  public function getNumLicence(){
    return $this->numLicence;
  }

  public function setNumLicence($numLicence){
    $this->numLicence = $numLicence;
  }
  
  public function getNiveauMax(){
    return $this->niveauMax;
  }

  public function setNiveauMax($niveauMax){
    $this->niveauMax = $niveauMax;
  }

  public static function createFromId($idMembre){
     $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idMembre, nom, prnm, mail, numTel, numLicence, niveauMax
            FROM Membre
            WHERE idMembre = ?
              AND Type = 'Arbitre'
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
                REPLACE INTO `Membre`(`idMembre`, `nom`, `prnm`, `mail`, `numTel`, `numLicence`, `niveauMax`)
                               VALUES (:idMembre, :nom, :prnm, :mail, :numTel, :numLicence, :niveauMax)
SQL
);
    $stmt->execute(array(':idMembre' => $this ->idMembre,
                         ':nom' => $this ->nom,
                         ':prnm' => $this ->prnm,
                         ':mail' => $this ->mail,
                         ':numTel' => $this ->numTel,
                         ':numLicence' => $this ->numLicence,
                         ':niveauMax' => $this ->niveauMax;
            $this->idMembre = myPDO::getInstance()->lastInsertId() ;
    }
}
?>
