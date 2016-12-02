<?php
require_once 'myPDO.include.php';

class Categorie{

	private $idCat = null;

	private $tpsJeu = null;

	private $terrain = null;


	public function setIdCat($idCat){
		$this->idCat = $idCat;
	}

	public function getIdCat(){
		return $this->idCat;
	}

	public function setTpsJeu($tpsJeu){
		$this->tpsJeu = $tpsJeu;
	}

	public function getTpsJeu(){
		return $this->tpsJeu;
	}

	public function setTerrain($terrain){
		$this->terrain = $terrain;
	}

	public function getTerrain(){
		return $this->terrain;
	}


	public static function createFromId($idCat){
		 $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idCat, tpsJeu, terrain
            FROM Categorie
            WHERE idCat = ?
SQL
        ) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__) ;
        $stmt->execute(array($idCat)) ;
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
                REPLACE INTO `Categorie`(`idCat`,`tpsJeu`, `terrain`)
                               VALUES (:idCat,:tpsJeu, :terrain)
SQL
);
            $stmt->execute(array(':idCat' => $this ->idCat,
                                 ':tpsJeu' => $this ->tpsJeu,
                                 ':terrain' => $this ->terrain;
            $this->idCat = myPDO::getInstance()->lastInsertId() ;
    }

		public static function getAll(){
        $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idCat, tpsJeu, terrain
            FROM Categorie
SQL
        ) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__) ;
        $stmt->execute(array($idCat)) ;
        $res = array();
        if (($object = $stmt->fetch()) !== false) {
            $res[] = $object ;
        }
        return $res;
        throw new Exception('Pas de catégorie') ;
    }
}
