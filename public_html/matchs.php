<?php

session_start();

include_once 'class/webpage.class.php';

$page = new Webpage("Gestion des matchs");
$select = "rien";
if($_SESSION['type'] == "organisateur" ){
  $page->appendContent(<<<HTML
    <nav class="navbar navbar-default">
      <div class="container">
        <ul class="nav navbar-nav">
          <li><a href="matchs.php?select=ajouter"> Ajouter match </a></li>
          <li><a href="matchs.php?select=ajouter"> Modifier les données des matchs </a></li>
        </ul>
      </div>
    </nav>
);


}
else {
  $page->appendContent(<<<HTML
  <div class="container">
  <h5 class="center"> <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> Vous n'avez pas les droits d'accès pour cette page, vous allez être rediriger vers l'acceuil</h5>
  </div>
HTML
  );
}

echo $page->toHTML();
