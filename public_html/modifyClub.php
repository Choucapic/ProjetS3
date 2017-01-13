<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';

$page = new WebPage('Modification de Club');

if (isset($_SESSION['login'])) {
	if ($_SESSION['type'] == 'Administrateur') {
    if (isset($_GET['id'])) {

		// Pour Trouver le club
		$stmt = myPDO::getInstance()->prepare(<<<SQL
						SELECT refClub, nom, adresse, cp, ville, numTel
						FROM club
						WHERE refClub = {$_GET['id']}
SQL
);
    $stmt->execute(array());
		if (($object = $stmt->fetch()) !== false) {
			$infos = $object ;
      $formHTML = "";
		  foreach ($infos as $key => $value) {
          switch ($key) {
            case 'nom' :
              $name = "Nom";
              break;
            case 'refClub' :
              $name = "Reference du Club";
              break;
            case 'adresse' :
              $name = "Adresse";
              break;
            case 'numTel' :
              $name = "Numéro de Téléphone";
              break;
            case 'cp' :
              $name = "Code Postal";
              break;
            case 'ville' :
              $name = "Ville";
              break;
            default :
              $name = "Inconnnu";
          }
          if ($key != 'refClub') {
          $formHTML .= '<div class="input-field col m6 s12">
  					<input type="text" name="'. $key .'" class="validate" value="'. ($value == 'NULL' ? '' : $value) .'" required/>
  					<label for="'. $key .'">'. $name .'</label>
  				</div>';
        }
		}

		$page->appendCss(<<<CSS
		.form{
  	padding : 3em;
	}
CSS
);

		$page->appendContent(<<<HTML

		<h4 align="center">Modification</h4>
		<form class="form" method="POST" action="script.php" class="col s12">
			<div class="row">
				{$formHTML}
        <input type="hidden" name="refClub" value="{$_GET['id']}"/>
				<input type="hidden" name="type" value="modifyClub"/>
			</div>
			<div class="btn-auth">
			<a class="btn red darken-3 waves-effect waves-light" id="delCLubButton" onclick="if (confirm('Voulez vous vraiment supprimer ce Club ?')) window.location.href='script.php?type=delClub&id={$_GET['id']}';" name="delete">
				Supprimer <i class="material-icons right">clear</i>
			</a>
				<button class="btn blue darken-3 waves-effect waves-light" id="insMembreButton" type="submit" name="submit">
					Modifier <i class="material-icons right">send</i>
				</button>
			</div>
		</form>
HTML
);
} else {
  $page->appendContent(<<<HTML
  <div class="container">
  <h5 class="center"> <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> La référence ne correspond à aucun Club</h5>
  </div>
HTML
);

header( "refresh:5; url=index.php" );
}
}else {
  $page->appendContent(<<<HTML
  <div class="container">
  <h5 class="center"> <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> Aucune référence n'a été spécifié</h5>
  </div>
HTML
);

header( "refresh:5; url=index.php" );
}
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
