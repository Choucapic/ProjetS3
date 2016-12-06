<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';

$page = new WebPage('Inscription d\'Equipe');

if (isset($_SESSION['login'])) {
	if ($_SESSION['type'] == 'Administrateur') {


    // For coachs
    $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idMembre, nom, prnm
            FROM Membre
            WHERE Type = "Coach"
SQL
);
        $stmt->execute(array()) ;
        $coachs = array();
        while (($object = $stmt->fetch()) !== false) {
            $coachs[] = $object ;
          }
    $coachHTML = "";
    foreach ($coachs as $coach) {
    $coachHTML .= "<option value=\"". $coach['idMembre'] ."\">". $coach['nom'] . " " . $coach['prnm'] ."</option>";
    }

    // For clubs
    $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT refClub, nom
            FROM Club
SQL
);
        $stmt->execute(array()) ;
        $clubs = array();
        while (($object = $stmt->fetch()) !== false) {
            $clubs[] = $object ;
          }
    $clubHTML = "";
    foreach ($clubs as $club) {
    $clubHTML .= "<option value=\"". $club['refClub'] ."\">". $club['nom'] ."</option>";
    }

    // For categories
    $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT idCat
            FROM Categorie
SQL
);
        $stmt->execute(array()) ;
        $cats = array();
        while (($object = $stmt->fetch()) !== false) {
            $cats[] = $object ;
        }
    $catHTML = "";
    foreach ($cats as $cat) {
    $catHTML .= "<option value=\"". $cat['idCat'] ."\">". $cat['idCat'] ."</option>";
    }


		$page->appendCss(<<<CSS
		.form{
  	padding : 3em;
	}
CSS
);

		$page->appendContent(<<<HTML
		<h4 align="center">Inscription</h4>
		<form class="form" method="POST" action="script.php" class="col s12">
			<div class="row">
        <div class="input-field">
          <select id="insEquipeCoachSelect" name="idCoach">
            {$coachHTML}
          </select>
          <label for="Type">Coach</label>
        </div>
        <div class="input-field">
          <select id="insEquipeClubSelect" name="refClub">
            {$clubHTML}
          </select>
          <label for="Type">Club</label>
        </div>
        <div class="input-field">
          <select id="insEquipeCategorieSelect" name="idCat">
            {$catHTML}
          </select>
          <label for="Type">Catégorie</label>
        </div>
				<input type="hidden" name="type" value="insEquipe"/>
			</div>
			<div class="btn-auth">
				<button class="btn blue darken-3 waves-effect waves-light" type="submit" name="submit">
					Inscrire <i class="material-icons right">send</i>
				</button>
			</div>
		</form>
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
