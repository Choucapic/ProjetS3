<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';

$page = new WebPage('Visualisation des équipes');

if (isset($_SESSION['login'])) {
	if ($_SESSION['type'] == 'Administrateur') {

    // For clubs
    $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT refClub, nom
            FROM club
SQL
);
    $stmt->execute(array()) ;
    $clubs = array();
    while (($object = $stmt->fetch()) !== false) {
      $clubs[] = $object ;
    }

$HTML = '<ul class="collapsible" data-collapsible="expandable">';
    foreach ($clubs as $club) {
      $HTML .= '<li>
        <div class="collapsible-header waves-effect"> Club
        '. $club['nom'] .'
        </div>
        <div class="collapsible-body blue darken-2">';
      // For Equipes en fonction des clubs
      $stmt = myPDO::getInstance()->prepare(<<<SQL
              SELECT equipe.idEquipe, idCat, nom, prnm
              FROM equipe, membre
              WHERE equipe.refClub = {$club['refClub']}
              AND equipe.idCoach = membre.idMembre
SQL
);
      $stmt->execute(array()) ;
      $equipes = array();
      while (($object = $stmt->fetch()) !== false) {
        $equipes[] = $object ;
      }
      foreach ($equipes as $equipe) {
      $HTML .= '<p> Equipe : '.  $club['nom'] . ' - ' . $equipe['idCat'] . ' || Coach : '. $equipe['nom'] . ' ' . $equipe['prnm'] .'</p>';
      }
    $HTML .= "</div> </li>";
    }
    $HTML .= '</ul>';

    $page->appendContent(<<<HTML
    <div class="container">
    {$HTML}
    </div>
HTML
);

  } else {
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
