<?php
include_once 'mypdo.include.php';

class Terrain{

	private $idTerrain = null;

	private $interieur = null;

	/*public function Terrain($idTerrain, $interieur) {
		$this->idTerrain = $idTerrain;
		$this->interieur = $interieur;
	}*/


	public function getInterieur(){
		return $this->interieur;
	}

	public function setInterieur($interieur){
		$this->interieur = $interieur;
	}

	public function getIdTerrain(){
		return $this->idTerrain;
	}

	public function setIdTerrain($idTerrain){
		$this->idTerrain = $idTerrain;
	}

	public static function createFromId($idTerrain){
		 $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idTerrain, interieur
            FROM `terrain`
            WHERE idTerrain = ?
SQL
        ) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__) ;
        $stmt->execute(array($idTerrain)) ;
        if (($object = $stmt->fetch()) !== false) {
            return $object ;
        }
        throw new Exception('Ligne non trouvée !') ;
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
                REPLACE INTO `terrain`(`idTerrain`,`interieur`)
                               VALUES (:idTerrain,:interieur)
SQL
);
            $stmt->execute(array(':idTerrain' => $this ->idTerrain,
                                 ':interieur' => $this ->interieur));
            $this->idTerrain = myPDO::getInstance()->lastInsertId() ;
    }

    public static function getAllTerrains(){
    	$stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idTerrain, interieur
            FROM `terrain`
SQL
        ) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__) ;
        $stmt->execute() ;
        $arr= "'Terrain ";
        while (($object = $stmt->fetch()) !== false) {
            $arr.= $object->getIdTerrain()."', 'Terrain " ;
        }
        $arr.= "'";
        return $arr;
        throw new Exception('Pas de terrain') ;
    }
}
