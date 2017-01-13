<?php

include_once 'class/categorie.class.php';
include_once 'class/match.class.php';
include_once 'class/plage.class.php';
include_once 'class/equipe.class.php';
include_once 'class/webpage.class.php';

session_start();

$page = new WebPage('Test');

// On nettoie la table Match
$stmt = myPDO::getInstance()->prepare(<<<SQL
       DELETE FROM `match`
SQL
   ) ;
$stmt->execute();

// On nettoie la table Plage
$stmt = myPDO::getInstance()->prepare(<<<SQL
       DELETE FROM `plage`
SQL
   ) ;
$stmt->execute();

// On crée une plage qui correspond à l'heure de début de tournoi dans la journée
$stmt = myPDO::getInstance()->prepare(<<<SQL
       INSERT INTO `plage` (`idPlage`, `jour`, `hDeb`, `hFin`)
       VALUES ('1', '1', '08:00:00', '08:00:00')
SQL
   ) ;
$stmt->execute();

$plage = Plage::createFromId(1)->getNextPlage("08:00:00", "16:00:00", 30);
$categories = Categorie::getAll();
$equipes = Equipe::getAll();
$idMatchs = 0;
$HTML = "";
foreach ($categories as $categorie) {
  $equipesCat = array();
  $matchs = array();
 foreach ($equipes as $equipe) {
   if ($equipe->getIdCat() == $categorie->getIdCat()) {
     array_push($equipesCat, $equipe);
   }
 }
 if (count($equipesCat) != 0) {
 if ($idMatchs != 0) $plage = Plage::createFromId(1)->getNextPlage("08:00:00", "16:00:00", 30, $plage);
 $nombreEquipes = count($equipesCat);
 if ($nombreEquipes%2 == 0 && $nombreEquipes%3 != 0) {
   for ($i = 0; $i < $nombreEquipes; $i = $i+2) {
     array_push($matchs, new Match($idMatchs, $categorie->getTerrain(), $equipesCat[$i]->getIdEquipe(), $equipesCat[$i+1]->getIdEquipe(), 0, 0, 6, 6, $plage, -1));
     $plage = Plage::createFromId($plage)->getNextPlage("08:00:00", "16:00:00", 30);
     $idMatchs++;
   }
   $nombreEquipes /= 2;
   $newMatchs = Match::recursiveMatch($matchs, $idMatchs, $plage, $categorie->getTerrain());
   $idMatchs += count($newMatchs) + 1;
   foreach ($newMatchs as $newMatch) {
     array_push($matchs, $newMatch);
   }
   foreach ($matchs as $match) {
     $match->save();
   }
 }

}
}


$page->appendContent(<<<HTML

<div class="container">

{$HTML}

</div>
HTML
);

echo $page->toHTML();
