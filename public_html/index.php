<?php

session_start();

include_once 'class/webpage.class.php';

$page = new WebPage('Amicale des jeunes de Betheny');

$page->appendContent(<<<HTML
<div class="container">
  <h5 class="center">Bienvenue !</h5>
  <p>Sur cette application vous pourrez : </p>
  <div class="row center">
    <div class="col l3 m6 s12">
    <i class="fa fa-trophy fa-5x fa-spin fa-fw" aria-hidden="true"></i>
    <p>Visualiser le planning des matchs et leurs résultats</p>
  </div>
    <div class="col l3 m6 s12">
      <i class="fa fa-wheelchair-alt fa-5x fa-spin fa-fw" aria-hidden="true"></i>
      <p>Gérer les équipes, les joueurs, les bénévoles et les matchs</p>
    </div>
    <div class="col l3 m6 s12"><h1>3</h1></div>
    <div class="col l3 m6 s12"><h1>4</h1></div>
  </div>
</div>
HTML
);

echo $page->toHTML();
