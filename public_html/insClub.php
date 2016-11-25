<?php

session_start();

require_once 'class/webpage.class.php';

$page = new WebPage('Inscription de Club');

if (isset($_SESSION['login'])) {
	if ($_SESSION['type'] == 'Administrateur') {


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
				<div class="input-field col m6 s12">
					<input type="text" name="nom" class="validate" required/>
					<label for="nom">Nom du Club</label>
				</div>
				<div class="input-field col m6 s12">
					<input type="text" name="refClub" class="validate" required/>
					<label for="refClub">Référence du Club</label>
				</div>
				<div class="input-field col m6 s12">
					<input type="text" name="adresse" class="validate" required/>
					<label for="adresse">Adresse du Club</label>
				</div>
				<div class="input-field col m6 s12">
					<input type="text" name="cp" class="validate" required/>
					<label for="cp">Code postal du Club</label>
				</div>
				<div class="input-field col m6 s12">
					<input type="text" name="ville" class="validate" required/>
					<label for="ville">Ville du Club</label>
				</div>
				<div class="input-field col m6 s12">
					<input type="text" name="numTel" class="validate" required/>
					<label for="numTel">Numéro de téléphone du Club</label>
				</div>
				<input type="hidden" name="type" value="insClub"/>
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
