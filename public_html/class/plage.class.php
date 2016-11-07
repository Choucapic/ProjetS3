<?php

class Plage{


  protected $idPlage;

  protected $jour;
  
  protected $hDeb;
  
  protected $hFin;

  public function Plage(){}


  public function getIdPlage(){
    return $this->idPlage;
  }

  public function getHDeb(){
    return $this->hDeb;
  }
  
  public function getHFin(){
    return $this->hFin;
  }

    public function setHFin($hFin){
    $this->hFin = $hFin;
  }
}
?>
