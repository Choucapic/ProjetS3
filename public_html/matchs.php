<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';

$page =new WebPage('Gestion des matchs');

if(isset($_SESSION['login'])){
    if($_SESSION['type'] == 'Organisateur'){

       if(isset($_GET['option'])) {$option = $_GET['option']; }
        else { $option = "afficher"; }
      $page->appendContent(<<<HTML
        <div class="container">
          <nav>
            <div class="nav-wrapper blue darken-3">
              <ul id="nav-mobile" class="right hide-on-med-and-down">
    HTML
    );
      switch($option){
        case "afficher" :
        $page->appendContent(<<<HTML
                <li class ="active" ><a href="matchs.php?option=afficher">Afficher les matchs</a></li>
                <li ><a href="matchs.php?option=ajouter"> Ajouter match </a></li>
                <li ><a href="matchs.php?option=modifier"> Modifier les données des matchs </a></li>
    HTML
    );
    break;
      case "ajouter" :
      $page->appendContent(<<<HTML
            <li ><a href="matchs.php?option=afficher">Afficher les matchs</a></li>
            <li class="active" ><a href="matchs.php?option=ajouter"> Ajouter match </a></li>
            <li ><a href="matchs.php?option=modifier"> Modifier les données des matchs </a></li>
    HTML
    );
    break;
        case "modifier" :
          $page->appendContent(<<<HTML
          <li ><a href="matchs.php?option=afficher">Afficher les matchs</a></li>
          <li ><a href="matchs.php?option=ajouter"> Ajouter match </a></li>
          <li class="active"><a href="matchs.php?option=modifier"> Modifier les données des matchs </a></li>
    HTML
    );
          break;
        }
        $page->appendContent(<<<HTML
              <ul>
            </div>
          </nav>
          <p>{$option}</p>
        </div>
    HTML
    );
      switch ($option) {
        case 'afficher':
          #affiche tout les matchs du tournoi
          $page->appendContent(<<<HTML
          <div class="container">
            <h5 class="center"> Affichage des matchs </h5>
          </div>
    HTML
      );
          break;
        case 'ajouter':
          #affiche une interface pour ajouter un match
          $page->appendContent(<<<HTML
          <div class="container">
            <h5 class="center active"> Ajouter des matchs </h5>
          </div>
    HTML
      );
          break;
        case "modifier":
          #affiche une interface pour cherche un match selon une date, un numero  et/ou une equipe.
          $page->appendContent(<<<HTML
          <div class="container">
            <h5 class="center"> modifier des matchs </h5>
          </div>
    HTML
      );
          break;
        default:
        #affiche tout les matchs du tournoitype5>
        </div>
    HTML
    );
        }
    }else {
    $page->appendContent(<<<HTML
    <div class="container">
    <h5 class="center"> <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> Vous n'avez pas les droits requis, vous allez être redirigé vers l'accueil</h5>
    </div>
HTML
);

  header( "refresh:5; url=index.php" );
  }
} else {
  $page->appendContent(<<<HTML
  <div class="container">
  <h5 class="center"> <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> Vous n'êtes pas connecté, vous allez être redirigé vers l'accueil</h5>
  </div>
HTML
);

header( "refresh:5; url=index.php" );
}

echo $page->toHTML();
