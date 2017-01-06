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
$equipes = array($equipe1, $equipe2, $equipe3, $equipe4);
foreach ($categories as $categorie) {
 $equipesCat = array();
 foreach ($equipes as $equipe) {
   if ($equipe->getIdCat() == $categorie->getIdCat()) {
     array_push($equipesCat, $equipe);
   }
 }
 $matchs = array();
 if (count($equipesCat)%2 == 0) {
   for ($i = 0; $i < count($equipesCat); $i = $i+2) {
     array_push($matchs, new Match($i/2, 1, $equipesCat[$i]->getIdEquipe(), $equipesCat[$i+1]->getIdEquipe(), 0, 0, 1, 2, 'Plage'));
   }
 } else {

 }
}
var_dump($matchs);


$page->appendContent(<<<HTML

<div class="container">



</div>
HTML
);

echo $page->toHTML();
