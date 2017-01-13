<?php
require_once 'mypdo.include.php';
include_once 'plage.class.php';

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

	private $idNextMatch = null;

public function Match($idMatch = '', $idTerrain = '', $idLocal = '', $idVisiteur = '', $scoreLocal = '', $scoreVisiteur = '', $idArbitre1 = '', $idArbitre2 = '', $idPlage = '', $idNextMatch = '') {
			$this->idMatch = $idMatch;
			$this->idTerrain = $idTerrain;
			$this->idLocal = $idLocal;
			$this->idVisiteur = $idVisiteur;
			$this->scoreLocal = $scoreLocal;
			$this->scoreVisiteur = $scoreVisiteur;
			$this->idArbitre1 = $idArbitre1;
			$this->idArbitre2 = $idArbitre2;
			$this->idPlage = $idPlage;
			$this->idNextMatch = $idNextMatch;
		}


		public static function recursiveMatch($matchs, $id, &$plage, $idTerrain, $hDeb, $hFin) {
			 $result = array();
			 $nombreMatchs = count($matchs);
			 for ($i = 0; $i < $nombreMatchs; $i = $i+2) {
				 $plage = Plage::createFromId($plage)->getNextPlage($hDeb, $hFin, 30);
				 $matchs[$i]->setIdNextMatch($id);
				 $matchs[$i+1]->setIdNextMatch($id);
		     array_push($result, new Match($id, $idTerrain, $matchs[$i]->isWinner(), $matchs[$i+1]->isWinner(), 0, 0, 6, 6, $plage, -1));
				 $id++;
			 }
			 $nombreMatchs /= 2;
			 if ($nombreMatchs > 1) {
				 $plage = Plage::createFromId($plage)->getNextPlage($hDeb, $hFin, 30);
				 $newMatchs = Match::recursiveMatch($result, $id, $plage, $idTerrain, $hDeb, $hFin);
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

	public function getScoreLocal (){
		return $this->scoreLocal;
	}

	public function getScoreVisiteur (){
		return $this->scoreVisiteur;
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

	public function setIdNextMatch($idNextMatch){
		$this->idNextMatch = $idNextMatch;
	}

	public function getIdNextMatch($idNextMatch){
		return $this->idNextMatch;
	}

	public function isWinner() {
		if ($this->scoreLocal == $this->scoreVisiteur) {
			$result = ($this->scoreLocal == 0 && $this->scoreVisiteur == 0) ? 0 : 0;
		} else {
			$result = ($this->scoreLocal > $this->scoreVisiteur) ? $this->idLocal : $this->idVisiteur;
		}
		return $result;
	}

	public static function getAllMatchs(){
		$stmt = myPDO::getInstance()->prepare(<<<SQL
		SELECT *
		FROM `match`
		ORDER BY 1
SQL
	);
		$stmt->execute();
	 	$stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,__CLASS__);
        return $stmt->fetchAll();
}


	public static function createFromId($idMatch){
		 $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idMatch, idTerrain, idLocal, idVisiteur, scoreLocal, scoreVisiteur, idArbitre1, idArbitre2, idPlage, idNextMatch
            FROM `match`
            WHERE idMatch = ?
SQL
        ) ;
        $stmt->execute(array($idMatch)) ;
				$stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,__CLASS__) ;
        if (($object = $stmt->fetch()) !== false) {
            return $object ;
        }
        throw new Exception('match non trouvée !') ;
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
                REPLACE INTO `match`(`idMatch`,`idTerrain`, `idLocal`,
									 `idVisiteur`,`scoreLocal`, `scoreVisiteur`, `idArbitre1`,`idArbitre2`, `idPlage`, `idNextMatch`)
                               VALUES (:idMatch, :idTerrain, :idLocal, :idVisiteur, :scoreLocal, :scoreVisiteur, :idArbitre1, :idArbitre2, :idPlage, :idNextMatch)
SQL
);
            $stmt->execute(array(':idMatch' => $this ->idMatch,
																 ':idTerrain' => $this ->idTerrain,
                                 ':idLocal' => $this ->idLocal,
                                 ':idVisiteur' => $this ->idVisiteur,
																 ':scoreLocal' => $this ->scoreLocal,
																 ':scoreVisiteur' => $this ->scoreVisiteur,
                                 ':idArbitre1' => $this ->idArbitre1,
                                 ':idArbitre2' => $this ->idArbitre2,
                                 ':idPlage' => $this ->idPlage,
															   ':idNextMatch' => $this ->idNextMatch));
    }
}
