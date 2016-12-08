<?php

class Equipe{

	protected $idEquipe= null;
	protected $idCoach= null;
	protected $refClub= null;
	protected $idCat= null;
	protected $name = null;

	public function getIdEquipe{
		return $this->idEquipe;
	}
	public function getIdCoach{
		return $this->idCoach;
	}
	public function getRefClub{
		return $this->refClub;
	}
	public function getIdCat{
		return $this->idCat;
	}
	public function getName{
		return $this->name;
	}

	public static function createFromId($idEquipe){
     $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idEquipe, idCoach, refClub, idCat
            FROM Equipe
            WHERE idEquipe = ?
SQL
        ) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__) ;
        $stmt->execute(array($idEquipe)) ;
        if (($object = $stmt->fetch()) !== false) {
            return $object ;
        }
        $this->name = $this->refClub . $this->idCat ;
        throw new Exception('Equipa non trouvée !') ;
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
    $this->name = $this->refClub . $this->idCat ;
    return $self ;
  }

  public function save(){
    $stmt = myPDO::getInstance()->prepare(<<<SQL
                REPLACE INTO `Equipe`(`idEquipe`, `idCoach`, `refClub`, `idCat`)
                               VALUES (:idEquipe, :idCoach, :refClub, :idCat)
SQL
);
    $stmt->execute(array(':idEquipe' => $this ->idEquipe,
                         ':idCoach' => $this ->idCoach,
                         ':refClub' => $this ->refClub,
                         ':idCat' => $this ->idCat));
            $this->idEquipe = myPDO::getInstance()->lastInsertId() ;
    }



}