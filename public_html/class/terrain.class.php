<?php
require_once 'myPDO.include.php';

class Terrain{

	private $idTerrain = null; 

	private $interieur = null; 


	public function getTpsJeu($interrieur){
		return $this->interrieur;
	}

	public function setTpsJeu($interrieur){
		$this->interrieur = $interrieur;
	}

	public function getIdTerrain($idTerrain){
		return $this->idTerrain;
	}

	public function setIdTerrain($idTerrain){
		$this->idTerrain = $idTerrain;
	}

	public static function createFromId($idTerrain){
		 $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idTerrain, interieur
            FROM Terrain
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
                REPLACE INTO `Club`(`idTerrain`,`interieur`)
                               VALUES (:idTerrain,:interieur)
SQL
);
            $stmt->execute(array(':idTerrain' => $this ->idTerrain,
                                 ':interieur' => $this ->interieur;
            $this->idTerrain = myPDO::getInstance()->lastInsertId() ;
    }
}