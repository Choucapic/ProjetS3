<?php

require_once 'class/webpage.class.php';
require_once 'class/membre.class.php';
require_once 'class/club.class.php';

/*
* Traitement 
*/
var_dump($_REQUEST);

if(isset($_REQUEST['nom']) && isset($_REQUEST['refClub']) && isset($_REQUEST['adresse']) && isset($_REQUEST['cp']) && isset($_REQUEST['ville']) && isset($_REQUEST['numTel'])){
	$data = $_REQUEST;
	$club = Club::createFromArray($data);
	var_dump($club);
	$club->save();
}



/*
* Formulaire
*/

$page = new WebPage('Amicale des jeunes de Betheny');
$page->appendCss(<<<CSS
.form{
  padding : 3em;
}
CSS
);
$page->appendContent(<<<HTML
<h4 align="center">Inscription</h4>
<form class="form" method="REQUEST" action="insMembre.php">
 : <input type="text" name="refClub"/>
Adresse du Club : <input type="text" name="adresse"/>
Code postal du Club : <input type="text" name="cp"/>
Ville du Club : <input type="text" name="ville"/>
Numéro de téléphone du Club : <input type="text" name="numTel"/>

Nom du club :<div class="input-field" name="idCat">
<select name="refClub" size="1">
HTML
);

foreach( Club::getAllClub() as $club){
	if(isset($_REQUEST['refClub'])&&($club->getRefClub() == $club->getRefClub())) {
		$page->appendContent(<<<HTML
		<option value="{$club->getRefClub()}" selected> {$club->getNom()}</option>
HTML
);
	}
	else{
	$page->appendContent(<<<HTML
		<option value="{$club->getRefClub()}"> {$club->getNom()}</option>
</select>
</div>
<button type="submit">Envoyer</button>
</form>
HTML
);
}
}
echo $page->toHTML();