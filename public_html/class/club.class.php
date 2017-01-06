<?php
require_once 'mypdo.include.php';

class Club{

	private $refClub = null;

	private $nom = null;

	private $adresse = null;

	private $cp = null;

	private $ville = null;

	private $numTel = null;

	public function Club($refClub, $nom, $adresse, $cp, $ville, $numTel) {
		$this->refClub = $refClub;
		$this->nom = $nom;
		$this->adresse = $adresse;
		$this->cp = $cp;
		$this->ville = $ville;
		$this->numTel = $numTel;
	}

	public function setRefClub($refClub){
		$this->refClub = $refClub;
	}

	public function getRefClub(){
		return $this->refClub;
	}

	public function setNom($nom){
		$this->nom = $nom;
	}

	public function getNom(){
		return $this->nom;
	}

	public function setAdresse($adresse){
		$this->adresse = $adresse;
	}

	public function getAdresse(){
		return $this->adresse;
	}

	public function setCp($cp){
		$this->cp = $cp;
	}

	public function getCp(){
		return $this->cp;
	}

	public function setVille($ville){
		$this->ville = $ville;
	}

	public function getVille(){
		return $this->ville;
	}

	public function setNumTel($numTel){
		$this->numTel = $numTel;
	}

	public function getNumTel(){
		return $this->numTel;
	}

	public static function createFromId($refClub){
		 $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT refClub, nom, adresse, cp, ville, numTel
            FROM Club
            WHERE refClub = ?
SQL
        ) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__) ;
        $stmt->execute(array($refClub)) ;
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
                REPLACE INTO `club`(`refClub`,`nom`, `adresse`,
									 `cp`, `ville`,`numTel`)
                               VALUES (:refClub,:name, :adresse,:cp, :ville,
                                  :numTel)
SQL
);
            $stmt->execute(array(':refClub' => $this ->refClub,
                                 ':name' => $this->nom,
                                 ':adresse' => $this ->adresse,
                                 ':cp' => $this ->cp,
                                 ':ville' => $this ->ville,
                                 ':numTel' => $this ->numTel));
            $this->refClub = myPDO::getInstance()->lastInsertId() ;
    }
    public static function getAllClub(){
    	$stmt = myPDO::getInstance()->prepare(<<<SQL
    		SELECT refClub, nom, adresse, cp, ville, numTel
            FROM club
SQL
) ;
    	$stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__) ;
        $stmt->execute();
        if (($object = $stmt->fetch()) !== false) {
            return $object ;
        }
        throw new Exception('Aucun Club !') ;
    }

    }
