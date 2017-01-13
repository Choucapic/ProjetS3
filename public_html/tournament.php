<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';
include_once 'class/categorie.class.php';

$page = new WebPage('Nouveau Tournoi');

if (isset($_SESSION['login'])) {
	if ($_SESSION['type'] == 'Administrateur') {

        $formHTML = "";
        $categories = Categorie::getAll();
        $formHTML .= "<h5 class='center'> Catégories </h5> <div class='center'>";
        foreach ($categories as $categorie) {
          $formHTML .= '
  					<input type="checkbox" name="categories[]" class="validate" value="'. $categorie->getIdCat() .'" id="'. $categorie->getIdCat() .'" />
  					<label style="margin:20px; margin-top:5px;" for="'. $categorie->getIdCat() .'">'. $categorie->getIdCat() .'</label>
  				';
 }
 $formHTML .= "</div>";

 $formHTML .= '<div class="input-field col m6 s12"><p class="center"> Heure de début </p> <input type="time" id="hDeb" name="hDeb" value="08:00"> </div>
 <div class="input-field col m6 s12"><p class="center"> Heure de fin </p> <input type="time" id="hFin" name="hFin" value="18:00"> </div>';

		$page->appendCss(<<<CSS
		.form{
  	padding : 3em;
	}
CSS
);

		$page->appendContent(<<<HTML

		<form class="form" method="POST" action="script.php" class="col s12">
			<div class="row">
				{$formHTML}
				<input type="hidden" name="type" value="newTournament"/>
			</div>
			<div class="btn-auth">
      <button class="btn blue darken-3 waves-effect waves-light" id="insMembreButton" type="submit" name="submit">
        Créer <i class="material-icons right">send</i>
      </button>
			</div>
      <h5 class="red-text center">Créer un tournoi effacera le précédent ! </h5>
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
