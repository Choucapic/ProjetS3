<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';

$page = new WebPage('Visualisation des Clubs');

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

$HTML = '<div class="clubList blue">';
    foreach ($clubs as $club) {
      $HTML .= '<div class="row"><div class="col m6 s6"> <p style="padding-left: 15px; padding-top:15px;"> Nom : '.  $club['nom'] . '<br> Reference : '.  $club['refClub'] .'</p> </div> <div class="col m6 s6" style="padding-top:15px;"><a class="black waves-effect waves-light btn right" href="modifyClub.php?id='. $club['refClub'] .'" style="margin-right: 10px; margin-top: 18px;"><i class="material-icons left">mode_edit</i>Modifier</a></div></div><hr>';
    }
    $HTML .= '</div>';

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
