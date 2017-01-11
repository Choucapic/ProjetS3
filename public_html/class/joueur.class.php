<?php

class Joueur extends Membre{
  
  protected $numLicence;
  
  public function getNumLicence(){
    return $this->numLicence;
  }

  public static function createFromId($idMembre){
     $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idMembre, nom, prnm, mail, numLicence
            FROM `membre`
            WHERE idMembre = ?
              AND Type = 'Coach'
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
                REPLACE INTO `membre`(`idMembre`, `nom`, `prnm`, `mail`, `numLicence`)
                               VALUES (:idMembre, :nom, :prnm, :mail, :numLicence)
SQL
);
    $stmt->execute(array(':idMembre' => $this ->idMembre,
                         ':nom' => $this ->nom,
                         ':prnm' => $this ->prnm,
                         ':mail' => $this ->mail,
                         ':numLicence' => $this ->numLicence));
            $this->idMembre = myPDO::getInstance()->lastInsertId() ;
    }
  
}
?>
