<?php

include_once 'mypdo.include.php';

class Equipe{

	protected $idEquipe = null;
	protected $idCoach = null;
	protected $refClub = null;
	protected $idCat = null;
	protected $name = null;

	/* public function Equipe($idEquipe, $idCoach, $refClub, $idCat) {
		$this->idEquipe = $idEquipe;
		$this->idCoach = $idCoach;
		$this->refClub = $refClub;
		$this->idCat = $idCat;
	}*/

	public function getIdEquipe(){
		return $this->idEquipe;
	}
	public function getIdCoach(){
		return $this->idCoach;
	}
	public function getRefClub(){
		return $this->refClub;
	}
	public function getIdCat(){
		return $this->idCat;
	}
	public function getName(){
		return $this->name;
	}

	public function setIdEquipe($idEquipe){
		$this->idEquipe = $idEquipe;
	}
	public function setIdCoach($idCoach){
		$this->idCoach = $idCoach;
	}
	public function setRefClub($refClub){
		$this->refClub = $refClub;
	}
	public function setIdCat($idCat){
		$this->idCat = $idCat;
	}
	public function setName($name){
		$this->name = $name;
	}

	public static function createFromId($idEquipe){
     $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idEquipe, idCoach, refClub, idCat
            FROM `equipe`
            WHERE idEquipe = ?
SQL
        ) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__) ;
        $stmt->execute(array($idEquipe)) ;
        if (($object = $stmt->fetch()) !== false) {
					$stmt = myPDO::getInstance()->prepare(<<<SQL
		             SELECT nom
		             FROM `club`
		             WHERE refClub = ?
SQL
		         ) ;
						 $stmt->execute(array($object->getRefClub())) ;
						 $club = $stmt->fetch();
						$object->name = $club['nom'] . " - " . $object->idCat ;
            return $object ;
        }
        throw new Exception('Equipe non trouvée !') ;
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

		public static function getAll(){
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idEquipe, idCoach, equipe.refClub, idCat
            FROM equipe
						WHERE idEquipe != 0
SQL
        ) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__) ;
        $stmt->execute() ;
        $res = array();
        while (($object = $stmt->fetch()) !== false) {
            $res[] = $object ;
        }
        return $res;
        throw new Exception('Pas d\'Equipe !') ;
    }

}
