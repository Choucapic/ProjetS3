<?php

class Plage{


  protected $idPlage;

  protected $jour;

  protected $hDeb;

  protected $hFin;


/*  public function Plage($idPlage, $jour, $hDeb, $hFin){
      $this->idPlage = $idPlage;
      $this->jour = $jour;
      $this->hDeb = $hDeb;
      $this->hFin = $hFin;
  }*/

  public function getNextPlage($timeLimiteDeb, $timeLimiteFin, $temps, $id=-1) {
    if ($id != -1) $this->idPlage = $id;
    $hLimiteDeb = intval(substr($timeLimiteDeb, 0, 2));
    $hLimiteFin = intval(substr($timeLimiteFin, 0, 2));
    $hPlage = intval(substr($this->hFin, 0, 2));
    $mPlage = intval(substr($this->hFin, 3, 5));
    if ($hPlage >= $hLimiteFin) {
      $this->hFin = $timeLimiteDeb;
      $hPlage = $hLimiteDeb;
      $mPlage = 0;
      $this->jour += 1;
    }
    if ($mPlage + $temps >= 60) {
      $mPlage = ($mPlage + $temps)%60;
      $hPlage = $hPlage + 1;
      if ($hPlage >= $hLimiteFin) {
        $this->hFin = $timeLimiteDeb;
        $hPlage = $hLimiteDeb;
        $mPlage = 0 + $temps;
        $this->jour += 1;
      }
    } else {
      $mPlage = $mPlage + $temps;
    }
    $newIdPlage = $this->idPlage + 1;
    $newHFin = $hPlage . ":" . $mPlage . ":00";
    $stmt = myPDO::getInstance()->prepare(<<<SQL
           INSERT INTO `plage` (`idPlage`, `jour`, `hDeb`, `hFin`)
           VALUES ('{$newIdPlage}', '{$this->jour}', '{$this->hFin}', '{$newHFin}')
SQL
       ) ;
    $stmt->execute();
    return $this->idPlage+1;
  }


    public static function createFromId($idPlage){
		 $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idPlage, jour, hDeb, hFin
            FROM `plage`
            WHERE idPlage = ?
SQL
        ) ;
        $stmt->setFetchMode(PDO::FETCH_CLASS,__CLASS__) ;
        $stmt->execute(array($idPlage)) ;
        if (($object = $stmt->fetch()) !== false) {
            return $object ;
        }
        throw new Exception('Ligne non trouvée !') ;
    }

  public function getIdPlage(){
    return $this->idPlage;
  }

  public function getDeb(){
        $day = "2017-6-3";
      if($this->jour > 1)$day = "2017-6-4";
      $str = $day." ".$this->hDeb;
      $date = DateTime::createFromFormat('Y-n-j h:i:s', $str);
      return $date->format('Y,n,j,G,i');
  }

  public function getFin(){
       $day = "2017-6-3";
      if($this->jour > 1)$day = "2017-6-4";
      $str = $day." ".$this->hFin;
      $date = DateTime::createFromFormat('Y-n-j h:i:s', $str);
      return $date->format('Y,n,j,G,i');
  }

  public function getHDeb(){
    return $this->hDeb;
  }

  public function getHFin(){
    return $this->hFin;
  }
  public function setHDeb($hFin){
  $this->hFin = $hFin;
}

    public function setHFin($hFin){
    $this->hFin = $hFin;
  }

  public function getJour(){
    return $this->jour;
  }

    public function setJour($jour){
    $this->jour = $jour;
  }
}
