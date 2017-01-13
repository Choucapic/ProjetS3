<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';

$page = new WebPage('Modification de Membre');

if (isset($_SESSION['login'])) {
	if ($_SESSION['type'] == 'Administrateur') {
    if (isset($_GET['id'])) {

		// Pour Trouver le membre
		$stmt = myPDO::getInstance()->prepare(<<<SQL
						SELECT idEquipe, nom, prnm, mail, numLicence, numTel, adresse, cp, ville, niveauArbitre, Type
						FROM membre
						WHERE idMembre = {$_GET['id']}
SQL
);
    $stmt->execute(array());
		if (($object = $stmt->fetch()) !== false) {
			$infos = $object ;
      $formHTML = "";
		  foreach ($infos as $key => $value) {
      switch ($key) {
        case 'numLicence' :
          if ($infos['Type'] == 'Arbitre' || $infos['Type'] == 'Joueur' || $infos['Type'] == 'Coach') {
            $formHTML .= '<div class="input-field col m6 s12">
    					<input type="text" id="numLicence" name="numLicence" class="validate" value="'. ($value == 'NULL' ? '' : $value) . '" required/>
    					<label for="numLicence">Numéro de Licence</label>
    				</div>';
          }
          break;
        case 'niveauArbitre' :
          if ($infos['Type'] == 'Arbitre') {
            $formHTML .= '<div class="input-field col m6 s12">
    					<input id="niveauArbitre" type="text" name="niveauArbitre" class="validate" value="'. ($value == 'NULL' ? '' : $value) . '" required/>
    					<label for="niveauArbitre">Niveau Arbitre</label>
    				</div>';
          }
          break;
        case 'idEquipe' :
          if ($infos['Type'] == 'Joueur') {
            $formHTML .= '<div class="input-field" name="idEquipe">
    					 <select name="idEquipe" id="idEquipe">';
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
                    $equipes[] = $object;
                  }
            $equipeHTML = "";
            foreach ($equipes as $equipe) {
            $equipeHTML .= '<option '. ($equipe['idEquipe'] == $value ? 'selected' : '') .' value="'. $equipe['idEquipe'] .'">'. $equipe['nom'] . ' - ' . $equipe['idCat'] .'</option>';
            }
            $formHTML .= $equipeHTML . '</select>
						<label for="Type">Equipe</label>
				</div>';
          }
          break;
        case 'Type' :
          // Do Nothing, WOOOOOOOHOOOOOOOOOOO
          break;
        default :
          switch ($key) {
            case 'nom' :
              $name = "Nom";
              break;
            case 'prnm' :
              $name = "Prénom";
              break;
            case 'mail' :
              $name = "Mail";
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
          $formHTML .= '<div class="input-field col m6 s12">
  					<input type="' . ($key == 'mail' ? 'email' : 'text') . '" name="'. $key .'" class="validate" value="'. ($value == 'NULL' ? '' : $value) .'" required/>
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
        <input type="hidden" name="idMembre" value="{$_GET['id']}"/>
				<input type="hidden" name="type" value="modifyMembre"/>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<input id="password" type="password" name="password" class="validate"/>
					<label for="password">Mot de passe (laisser vide pour ne pas le changer)</label>
					</div>
			</div>
			<div class="btn-auth">
				<a class="btn red darken-3 waves-effect waves-light" id="delMembreButton" onclick="if (confirm('Voulez vous vraiment supprimer ce Membre ?')) window.location.href='script.php?type=delMembre&id={$_GET['id']}';" name="delete">
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
  <h5 class="center"> <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> L'id ne correspond à aucun Membre</h5>
  </div>
HTML
);

header( "refresh:5; url=index.php" );
}
}else {
  $page->appendContent(<<<HTML
  <div class="container">
  <h5 class="center"> <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> Aucun id n'a été spécifié</h5>
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
