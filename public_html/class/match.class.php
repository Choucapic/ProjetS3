<?php
require_once 'myPDO.include.php';

class Match{

	private $idMatch = null; 

	private $idTerrain = null; 

	private $idLocal = null;

	private $idVisiteur = null;

	private $idArbitre1 = null; 

	private $idArbitre2 = null;

	private $idPlage = null;


	public function setIdMatch($idMatch){
		$this->idMatch = $idMatch;
	}

	public function getIdMatch(){
		return $this->idMatch;
	}

	public function setIdTerrain($idTerrain){
		$this->idTerrain = $idTerrain;
	}

	public function getIdTerrain(){
		return $this->idTerrain;
	}

	public function setIdLocal($idLocal){
		$this->idLocal = $idLocal;
	}

	public function getIdLocal(){
		return $this->idLocal;
	}

	public function setIdVisiteur($idVisiteur){
		$this->idVisiteur = $idVisiteur;
	}

	public function getIdVisiteur(){
		return $this->idVisiteur;
	}

	public function setArbitre1($idArbitre1){
		$this->idArbitre1 = $idArbitre1;
	}

	public function getIdArbitre1(){
		return $this->idArbitre1;
	}

	public function setIdArbitre2($idArbitre2){
		$this->idArbitre2 = $idArbitre2;
	}

	public function getIdArbitre2(){
		return $this->idArbitre2;
	}

	public function setIdPlage($idPlage){
		$this->idPlage = $idPlage;
	}

	public function getIdPlage(){
		return $this->idPlage;
	}

	public static function createFromId($idMatch){
		 $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idMatch, idTerrain, idLocal, idVisiteur, idArbitre1, idArbitre2, idPlage
            FROM Match
            WHERE idMatch = ?
SQL
        ) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__) ;
        $stmt->execute(array($idMatch)) ;
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
                REPLACE INTO `Match`(`idMatch`,`idTerrain`, `idLocal`,
									 `idVisiteur`, `idArbitre1`,`idArbitre2`, `idPlage`)
                               VALUES (:idMatch,:name, :idLocal,:idVisiteur, :idArbitre1,
                                  :idArbitre2,
                                  :idPlage)
SQL
);
            $stmt->execute(array(':idMatch' => $this ->idMatch,
                                 ':name' => $this -> name,
                                 ':idLocal' => $this ->idLocal,
                                 ':idVisiteur' => $this ->idVisiteur,
                                 ':idArbitre1' => $this ->idArbitre1,
                                 ':idArbitre2' => $this ->idArbitre2,
                                 ':idPlage' => $this ->idPlage;
            $this->idMatch = myPDO::getInstance()->lastInsertId() ;
    }
}