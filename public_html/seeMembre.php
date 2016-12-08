<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';

$page = new WebPage('Visualisation des Membres');

if (isset($_SESSION['login'])) {
	if ($_SESSION['type'] == 'Administrateur') {

    // For clubs
    $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT Type
            FROM membre
SQL
);
    $stmt->execute(array()) ;
    $types = array();
    while (($object = $stmt->fetch()) !== false) {
      $types[] = $object ;
    }

$HTML = '<ul class="collapsible" data-collapsible="expandable">';
    foreach ($types as $type) {
      $HTML .= '<li>
        <div class="collapsible-header waves-effect"> Membres
        '. ($type['Type'] == 'Benevole' ? 'Bénévole' : $type['Type'])  .'
        </div>
        <div class="collapsible-body blue darken-2">';
      // For Equipes en fonction des clubs
      $stmt = myPDO::getInstance()->prepare(<<<SQL
              SELECT idMembre, nom, prnm, numTel
              FROM membre
              WHERE Type = '{$type['Type']}'
SQL
);
      $stmt->execute(array()) ;
      $membres = array();
      while (($object = $stmt->fetch()) !== false) {
        $membres[] = $object ;
      }
      foreach ($membres as $membre) {
      $HTML .= '<p> Nom : '.  $membre['nom'] . ' ' . $membre['prnm'] . ' || Num Tel. : '.  $membre['numTel'] .'</p>';
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
