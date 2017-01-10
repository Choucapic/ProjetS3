<?php

session_start();

include_once 'class/webpage.class.php';

$page = new WebPage('Amicale des jeunes de Betheny');

$page->appendContent(<<<HTML

<div class="container">

  <h5 class="center">Bienvenue !</h5>

  <div class="carousel">
    <a class="carousel-item" href="#one!"><img src="img/1.jpg"></a>
    <a class="carousel-item" href="#two!"><img src="img/2.jpg"></a>
    <a class="carousel-item" href="#three!"><img src="img/3.jpg"></a>
    <a class="carousel-item" href="#four!"><img src="img/4.jpg"></a>
    <a class="carousel-item" href="#five!"><img src="img/5.jpg"></a>
  </div>
  <div class="row center">
    <div class="col s4">
    <i class="fa fa-trophy fa-5x fa-fw" aria-hidden="true"></i>
    <p>Visualiser le planning des matchs et leurs résultats</p>
  </div>
    <div class="col s4">
      <i class="fa fa-calendar fa-5x fa-fw" aria-hidden="true"></i>
      <p>Gérer le planning et les scores</p>
    </div>
    <div class="col s4">
      <i class="fa fa-dribbble fa-5x fa-fw" aria-hidden="true"></i>
      <p>Gérer les équipes, les joueurs, les bénévoles et les matchs</p>
    </div>
  </div>
</div>
HTML
);
$page->appendJs(<<<JS
$(document).ready(function(){
      $('.carousel').carousel();
    });
JS
);


echo $page->toHTML();
