<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';

$page = new WebPage('Inscription de Membre');

if (isset($_SESSION['login'])) {
	if ($_SESSION['type'] == 'Administrateur') {

		// For Equipes
		$stmt = myPDO::getInstance()->prepare(<<<SQL
						SELECT idEquipe, nom, idCat
						FROM equipe, club
						WHERE equipe.refClub = club.refClub
SQL
);
				$stmt->execute(array()) ;
				$equipes = array();
				while (($object = $stmt->fetch()) !== false) {
						$equipes[] = $object ;
					}
		$equipeHTML = "";
		foreach ($equipes as $equipe) {
		$equipeHTML .= "<option value=\"". $equipe['idEquipe'] ."\">". $equipe['nom'] . " - " . $equipe['idCat'] ."</option>";
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
				<div class="input-field" name="Type">
				 	<select id="insMembreSelect" name="Type">
					 	<option value="Organisateur">Organisateur</option>
					 	<option value="Coach">Coach</option>
					 	<option value="Arbitre">Arbitre</option>
					 	<option value="Joueur">Joueur</option>
					 	<option value="Benevole">Bénévole</option>
						</select>
						<label for="Type">Type de Membre</label>
				</div>
				<div class="input-field" name="idEquipe" id="idEquipeDiv" hidden>
					 <select name="idEquipe" id="selectIdEquipe">
						 {$equipeHTML}
						</select>
						<label for="Type">Equipe</label>
				</div>
				<div class="input-field col m6 s12">
					<input type="text" name="nom" class="validate" required/>
					<label for="nom">Nom</label>
				</div>
				<div class="input-field col m6 s12">
					<input type="text" name="prnm" class="validate" required/>
					<label for="prnm">Prénom</label>
				</div>
				<div class="input-field col m6 s12">
					<input type="email" name="mail" class="validate" required/>
					<label for="mail">Mail</label>
				</div>
				<div class="input-field col m6 s12" id="numLicenceDiv" hidden>
					<input id="numLicenceInput" type="text" name="numLicence" class="validate" disabled required/>
					<label for="numLicence">Numéro de Licence</label>
				</div>
				<div class="input-field col m6 s12">
					<input type="text" name="adresse" class="validate" required/>
					<label for="adresse">Adresse</label>
				</div>
				<div class="input-field col m6 s12">
					<input type="text" name="cp" class="validate" required/>
					<label for="cp">Code postal</label>
				</div>
				<div class="input-field col m6 s12">
					<input type="text" name="ville" class="validate" required/>
					<label for="ville">Ville</label>
				</div>
				<div class="input-field col m6 s12">
					<input type="text" name="numTel" class="validate" required/>
					<label for="numTel">Numéro de téléphone</label>
				</div>
				<div class="input-field col m6 s12" id="niveauArbitreDiv" hidden>
					<input id="niveauArbitreInput" type="text" name="niveauArbitre" class="validate" disabled required/>
					<label for="niveauArbitre">Niveau Arbitre</label>
				</div>
				<input type="hidden" name="type" value="insMembre"/>
			</div>
			<div class="row">
				<div class="input-field col m6 s12">
					<input id="passwordInput" type="password" name="password" class="validate" required/>
					<label for="password">Mot de passe</label>
					</div>
					<div class="input-field col m6 s12">
					<input id="passwordVerifyInput" type="password" name="passwordVerify" class="validate" required error/>
					<label for="passwordVerify">Retapez le mot de passe</label>
					</div>
					<p id="errorMessagePassword" class="center red-text">Les mots de passe doivent correspondre !</p>
			</div>
			<div class="btn-auth">
				<button class="btn blue darken-3 waves-effect waves-light" id="insMembreButton" type="submit" name="submit">
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
