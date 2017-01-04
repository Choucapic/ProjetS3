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

$HTML = '<ul id="clubClassement" class="collapsible" data-collapsible="expandable">';
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
      $HTML .= '<p> Equipe : '.  $club['nom'] . ' - ' . $equipe['idCat'] . ' || Coach : '. $equipe['nom'] . ' ' . $equipe['prnm'] .'</p> <hr>';
      }
    $HTML .= "</div> </li>";
    }
    $HTML .= '</ul>';

		// For categories
		$stmt = myPDO::getInstance()->prepare(<<<SQL
						SELECT idCat
						FROM categorie
SQL
);
		$stmt->execute(array()) ;
		$clubs = array();
		while (($object = $stmt->fetch()) !== false) {
			$categories[] = $object ;
		}

$HTML .= '<ul id="categorieClassement" class="collapsible" data-collapsible="expandable" hidden>';
		foreach ($categories as $categorie) {
			$HTML .= '<li>
				<div class="collapsible-header waves-effect"> Categorie
				'. $categorie['idCat'] .'
				</div>
				<div class="collapsible-body blue darken-2">';
			// For Equipes en fonction des categories
			$stmt = myPDO::getInstance()->prepare(<<<SQL
							SELECT equipe.idEquipe, idCat, nom, prnm
							FROM equipe, membre
							WHERE equipe.idCat = '{$categorie['idCat']}'
							AND equipe.idCoach = membre.idMembre
SQL
);
			$stmt->execute(array()) ;
			$equipes = array();
			while (($object = $stmt->fetch()) !== false) {
				$equipes[] = $object ;
			}
			foreach ($equipes as $equipe) {
			$HTML .= '<p> Equipe : '.  $club['nom'] . ' - ' . $equipe['idCat'] . ' || Coach : '. $equipe['nom'] . ' ' . $equipe['prnm'] .'</p> <hr>';
			}
		$HTML .= "</div> </li>";
		}
		$HTML .= '</ul>';

    $page->appendContent(<<<HTML
    <div class="container">
		<div class="row center">
		<h5> Mode de classement : </h5>
    <p>
      <input name="group1" type="radio" id="club" value="club" checked/>
      <label for="club">Club</label>

      <input name="group1" type="radio" id="categorie" value="categorie" />
      <label for="categorie">Categorie</label>
    </p>
  </div>

<script>
$( "input" ).on( "click", function() {
   if ($( "input:checked" ).val() == "club") {
		 $("#categorieClassement").prop('hidden', true);
		 $("#clubClassement").prop('hidden', false);
	 } else {
		 $("#categorieClassement").prop('hidden', false);
		 $("#clubClassement").prop('hidden', true);
	 }
});
</script>

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
