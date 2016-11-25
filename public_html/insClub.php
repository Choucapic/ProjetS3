<?php

require_once 'class/webpage.class.php';
require_once 'class/club.class.php';
/*
* Traitement 
*/

if(isset($_REQUEST['nom']) && isset($_REQUEST['refClub']) && isset($_REQUEST['adresse']) && isset($_REQUEST['cp']) && isset($_REQUEST['ville']) && isset($_REQUEST['numTel'])){
	$data = $_REQUEST;
	$club = Club::createFromArray($data);
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
<form class="form" method="REQUEST" action="insClub.php">
Nom du Club :<input type="text" name="nom"/>
Réference du Club : <input type="text" name="refClub"/>
Adresse du Club : <input type="text" name="adresse"/>
Code postal du Club : <input type="text" name="cp"/>
Ville du Club : <input type="text" name="ville"/>
Numéro de téléphone du Club : <input type="text" name="numTel"/>
<input type="submit" value="Envoyer"/>
HTML
);

echo $page->toHTML();