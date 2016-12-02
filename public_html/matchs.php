<?php

session_start();

include_once 'class/webpage.class.php';

$page = new WebPage('Gestion des matchs');

if($_SESSION['type'] == 'Organisateur'){
  $option ="afficher";
  $page->appendContent(<<<HTML
    <div class="container">
      <nav>
        <div class="nav-wrapper blue darken-3">
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li class="active"><a href="matchs.php?option=afficher">Afficher les matchs</a></li>
            <li><a href="matchs.php?option=ajouter"> Ajouter match </a></li>
            <li><a href="matchs.php?option=modifier"> Modifier les données des matchs </a></li>
          <ul>
        </div>
      </nav>
    </div>
HTML
);
  switch ($option) {
    case "afficher":
      #affiche tout les matchs du tournoi
      $page->appendContent(<<<HTML
      <div class="container">
        <h5 class="center">
        <br> Affichage des matchs </h5>
      </div>
HTML
  );
      break;
    case "ajouter":
      #affiche une interface pour ajouter un match
      $page->appendContent(<<<HTML
      <div class="container">
        <h5 class="center">
        <br> Ajouter des matchs </h5>
      </div>
HTML
  );
      break;
    case "modifier":
      #affiche une interface pour cherche un match selon une date, un numero  et/ou une equipe.
      $page->appendContent(<<<HTML
      <div class="container">
        <h5 class="center">
        <br> modifier des matchs </h5>
      </div>
HTML
  );
      break;

    default:
    $page->appendContent(<<<HTML
    <div class="container">
      <h5 class="center">
      <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i>
      <br> Erreur... </h5>
    </div>
HTML
);
    $option="afficher";
    header("refresh:3; url=match.php");
      break;
  }

}
else {
  $page->appendContent(<<<HTML
  <div class="container">
    <h5 class="center">
    <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i>
    <br> Vous n'avez pas les droits d'accès pour cette page, vous allez être rediriger vers l''acceuil</h5>
  </div>

HTML
);
header( "refresh:3; url=index.php" );
}

echo $page->toHTML();
