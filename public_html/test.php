<?php

include_once 'class/club.class.php';
include_once 'class/categorie.class.php';
include_once 'class/match.class.php';
include_once 'class/plage.class.php';
include_once 'class/terrain.class.php';
include_once 'class/equipe.class.php';

session_start();

include_once 'class/webpage.class.php';

$page = new WebPage('Test');

$club = new Club(1, 'REIMS', 'adresse', '51100', 'Betheny', '0651');
$categorie = new Categorie('Bons',40,1);
$categories[] = $categorie;
$equipe1 = new Equipe(1, 1, 1, 'Bons', 'Equipe 1');
$equipe2 = new Equipe(2, 1, 1, 'Bons', 'Equipe 2');
$equipe3 = new Equipe(3, 1, 1, 'Bons', 'Equipe 3');
$equipe4 = new Equipe(4, 1, 1, 'Bons', 'Equipe 4');
$equipe5 = new Equipe(5, 1, 1, 'Bons', 'Equipe 5');
$equipe6 = new Equipe(6, 1, 1, 'Bons', 'Equipe 6');
$equipe7 = new Equipe(7, 1, 1, 'Bons', 'Equipe 7');
$equipe8 = new Equipe(8, 1, 1, 'Bons', 'Equipe 8');
$equipe9 = new Equipe(9, 1, 1, 'Bons', 'Equipe 9');
$equipe10 = new Equipe(10, 1, 1, 'Bons', 'Equipe 10');
$equipe11 = new Equipe(11, 1, 1, 'Bons', 'Equipe 11');
$equipe12 = new Equipe(12, 1, 1, 'Bons', 'Equipe 12');
$equipe13 = new Equipe(13, 1, 1, 'Bons', 'Equipe 13');
$equipe14 = new Equipe(14, 1, 1, 'Bons', 'Equipe 14');
$equipe15 = new Equipe(15, 1, 1, 'Bons', 'Equipe 15');
$equipe16 = new Equipe(16, 1, 1, 'Bons', 'Equipe 16');
$equipes = array($equipe1, $equipe2, $equipe3, $equipe4, $equipe5, $equipe6, $equipe7, $equipe8, $equipe9, $equipe10, $equipe11, $equipe12, $equipe13, $equipe14, $equipe15, $equipe16);
foreach ($categories as $categorie) {
  $equipesCat = array();
  $matchs = array();
 foreach ($equipes as $equipe) {
   if ($equipe->getIdCat() == $categorie->getIdCat()) {
     array_push($equipesCat, $equipe);
   }
 }

 $nombreEquipes = count($equipesCat);
 if ($nombreEquipes%2 == 0 && $nombreEquipes%3 != 0) {
   for ($i = 0; $i < $nombreEquipes; $i = $i+2) {
     array_push($matchs, new Match($i/2, 1, $equipesCat[$i]->getIdEquipe(), $equipesCat[$i+1]->getIdEquipe(), 0, 0, 1, 2, 'Plage'));
   }
   $nombreEquipes /= 2;
   $idMatch = count($matchs);
   $newMatchs = Match::recursiveMatch($matchs, $idMatch);
   foreach ($newMatchs as $newMatch) {
     array_push($matchs, $newMatch);
   }
   $HTML = "";
   $counter = 0;
   $divider = 2;
   foreach ($matchs as $match) {
     if ($counter == 0) {
       $HTML .= "<p>";
     }
     if ($counter < count($equipesCat)/$divider) {
       $HTML .= " | " . $match->getIdLocal() . " VERSUS " . $match->getIdVisiteur() . " | ";
     }
     $counter++;
     if ($counter == count($equipesCat)/$divider) {
       $counter = 0;
       $divider *= 2;
       $HTML .= "</p>";
     }
   }
 } else {

 }

}


$page->appendContent(<<<HTML

<div class="container">

{$HTML}

</div>
HTML
);

echo $page->toHTML();
