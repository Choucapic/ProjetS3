<?php
require_once 'mypdo.include.php';

class Match{

	private $idMatch = null;

	private $idTerrain = null;

	private $idLocal = null;

	private $idVisiteur = null;

	private $scoreLocal = null;

	private $scoreVisiteur = null;

	private $idArbitre1 = null;

	private $idArbitre2 = null;

	private $idPlage = null;

	public function Match($idMatch, $idTerrain, $idLocal, $idVisiteur, $scoreLocal, $scoreVisiteur, $idArbitre1, $idArbitre2, $idPlage) {
			$this->idMatch = $idMatch;
			$this->idTerrain = $idTerrain;
			$this->idLocal = $idLocal;
			$this->idVisiteur = $idVisiteur;
			$this->scoreLocal = $scoreLocal;
			$this->scoreVisiteur = $scoreVisiteur;
			$this->idArbitre1 = $idArbitre1;
			$this->idArbitre2 = $idArbitre2;
			$this->idPlage = $idPlage;
		}

		public static function recursiveMatch($matchs, $id) {
			 $result = array();
			 $nombreMatchs = count($matchs);
			 for ($i = 0; $i < $nombreMatchs; $i = $i+2) {
		     array_push($result, new Match($id, 1, $matchs[$i]->isWinner(), $matchs[$i+1]->isWinner(), 0, 0, 1, 2, 'Plage'));
				 $id++;
			 }
			 $nombreMatchs /= 2;
			 if ($nombreMatchs > 1) {
				 $newMatchs = Match::recursiveMatch($result, $id);
				 foreach ($newMatchs as $newMatch) {
					 array_push($result, $newMatch);
				 }
			 }
			 return $result;
		}


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

	public function isWinner() {
		if ($this->scoreLocal == $this->scoreVisiteur) {
			$result = ($this->scoreLocal == 0 && $this->scoreVisiteur == 0) ? 'TBD' : 'Equality';
		} else {
			$result = ($this->scoreLocal > $this->scoreVisiteur) ? $this->idLocal : $this->idVisiteur;
		}
		return $result;
	}

	public function getAllMatchs(){
		$stmt = myPDO::getInstance()->prepare(<<<SQL
					 SELECT idMatch, idTerrain, idLocal, idVisiteur, idArbitre1, idArbitre2, idPlage
					 FROM Match
SQL
);
	 	$stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__);
		$stmt->execute();
		if (($object = $stmt->fetch()) !== false) {
				return $object ;
		}
		throw new Exception('Ligne non trouvée !') ;
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
                                 ':idPlage' => $this ->idPlage));
            $this->idMatch = myPDO::getInstance()->lastInsertId() ;
    }
}
