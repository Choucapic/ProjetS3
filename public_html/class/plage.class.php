<?php

class Plage{


  protected $idPlage;

  protected $jour;

  protected $hDeb;

  protected $hFin;

  public function Plage($idPlage, $jour, $hDeb, $hFin){
      $this->idPlage = $idPlage;
      $this->jour = $jour;
      $this->hDeb = $hDeb;
      $this->hFin = $hFin;
  }

  public function getIdPlage(){
    return $this->idPlage;
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
