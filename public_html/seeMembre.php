<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';

$page = new WebPage('Visualisation des Membres');

if (isset($_SESSION['login'])) {
	if ($_SESSION['type'] == 'Administrateur') {

    // For Type de membre
		$stmt = myPDO::getInstance()->prepare("SHOW COLUMNS FROM membre WHERE Field = 'Type'" );
			$stmt->execute() ;
			$object = $stmt->fetch();
		  preg_match("/^enum\(\'(.*)\'\)$/", $object['Type'], $matches);
		  $types = explode("','", $matches[1]);
			sort($types);

$HTML = '<ul class="collapsible" data-collapsible="expandable">';
    foreach ($types as $type) {
      $HTML .= '<li>
        <div class="collapsible-header waves-effect"> Membres
        '. ($type == 'Benevole' ? 'Bénévole' : $type)  .'
        </div>
        <div class="collapsible-body blue darken-1 memberCollapse">';
      // For Membre en fonction du type
      $stmt = myPDO::getInstance()->prepare(<<<SQL
              SELECT idMembre, nom, prnm, numTel
              FROM membre
              WHERE Type = '{$type}' AND idMembre != 0
SQL
);
      $stmt->execute(array()) ;
      $membres = array();
      while (($object = $stmt->fetch()) !== false) {
        $membres[] = $object ;
      }
      foreach ($membres as $membre) {
      $HTML .= '<div class="row member"><div class="col m6 s6"> <p style="padding-top: 15px;"> Nom : '.  $membre['nom'] . ' ' . $membre['prnm'] . '<br> Num Tel. : '.  $membre['numTel'] .'</p> </div> <div class="col m6 s6"><a class="black waves-effect waves-light btn right" href="modifyMembre.php?id='. $membre['idMembre'] .'" style="margin-right: 10px; margin-top: 18px;"><i class="material-icons left">mode_edit</i>Modifier</a></div></div><hr>';
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
