<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';
include_once 'class/equipe.class.php';

$page = new WebPage('Modification de Match');

if (isset($_SESSION['login'])) {
	if ($_SESSION['type'] == 'Administrateur' || $_SESSION['type'] == 'Organisateur' || $_SESSION['type'] == 'Arbitre') {
    if (isset($_GET['id'])) {

		// Pour Trouver le club
		$stmt = myPDO::getInstance()->prepare(<<<SQL
						SELECT idMatch, idLocal, idVisiteur, scoreLocal, scoreVisiteur, idArbitre1, idArbitre2, idNextMatch
						FROM `match`
						WHERE idMatch = {$_GET['id']}
SQL
);
    $stmt->execute(array());
		if (($object = $stmt->fetch()) !== false) {
			$infos = $object ;
      $formHTML = "";
		  foreach ($infos as $key => $value) {
          switch ($key) {
            case 'scoreLocal' :
              $name = 'Score ' . Equipe::createFromId($infos['idLocal'])->getName();
              break;
            case 'scoreVisiteur' :
              $name = 'Score ' . Equipe::createFromId($infos['idVisiteur'])->getName();
              break;
            default :
              $name = "Inconnnu";
          }
          if ($key != 'idMatch' && $key != 'idLocal' && $key != 'idVisiteur' && $key != 'idArbitre1' && $key != 'idArbitre2' && $key != 'idNextMatch') {
          $formHTML .= '<div class="input-field col m6 s12">
  					<input type="text" name="'. $key .'" class="validate" value="'. ($value == 'NULL' ? '' : $value) .'" required/>
  					<label for="'. $key .'">'. $name .'</label>
  				</div>';
        }
      }
      $formHTML .= "</div>";
      // For Arbitre
      $stmt = myPDO::getInstance()->prepare(<<<SQL
              SELECT idMembre, nom, prnm
              FROM membre
              WHERE Type = 'Arbitre'
SQL
);
          $stmt->execute(array()) ;
          $arbitres = array();
          while (($object = $stmt->fetch()) !== false) {
              $arbitres[] = $object;
            }
        $formHTML .= '<div class="input-field" name="idArbitre1">
           <select name="idArbitre1" id="idArbitre1">';

        $arbitreHTML = "";
        foreach ($arbitres as $arbitre) {
        $arbitreHTML .= '<option '. ($arbitre['idMembre'] == $infos['idArbitre1'] ? 'selected' : '') .' value="'. $arbitre['idMembre'] .'">'. $arbitre['nom'] . ' ' . $arbitre['prnm'] .'</option>';
        }
        $formHTML .= $arbitreHTML . '</select>
        <label for="idArbitre1">Arbitre 1</label>
    </div>';

    $formHTML .= '<div class="input-field" name="idArbitre2">
       <select name="idArbitre2" id="idArbitre2">';

    $arbitreHTML = "";
    foreach ($arbitres as $arbitre) {
    $arbitreHTML .= '<option '. ($arbitre['idMembre'] == $infos['idArbitre2'] ? 'selected' : '') .' value="'. $arbitre['idMembre'] .'">'. $arbitre['nom'] . ' ' . $arbitre['prnm'] .'</option>';
    }
    $formHTML .= $arbitreHTML . '</select>
    <label for="idArbitre2">Arbitre 2</label>
</div>';


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
        <input type="hidden" name="idMatch" value="{$_GET['id']}"/>
        <input type="hidden" name="idNextMatch" value="{$infos['idNextMatch']}"/>
				<input type="hidden" name="type" value="modifyMatch"/>
			</div>
			<div class="btn-auth">
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
  <h5 class="center"> <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> La référence ne correspond à aucun Match</h5>
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
