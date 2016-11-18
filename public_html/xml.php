<?php

require_once 'class/webpage.class.php';

$page = new WebPage('Amicale des jeunes de Betheny');
$page->appendCss(<<<CSS
.form{
  padding : 3em;
}
CSS
);
$page->appendContent(<<<HTML
<h4 align="center">Inscription</h4>
<form class="form" method="REQUEST" action="save.php">
Nom du Club :<input type="text" name="nom"/>
Réference du Club : <input type="text" name="refClub"/>
Adresse du Club : <input type="text" name="adresse"/>
Code postal du Club : <input type="text" name="cp"/>
Ville du Club : <input type="text" name="ville"/>
Numéro de téléphone du Club : <input type="text" name="numTel"/>
Catégorie :
            <div class="row">
              <div class="input-field">
                <select>
                  <option value="" disabled selected>Choose your option</option>
                  <option value="1">Option 1</option>
                  <option value="2">Option 2</option>
                  <option value="3">Option 3</option>
                </select>
                <label>Materialize Select</label>
              </div>
							</div>
<div class="input-field" name="idCat">
							 <select>
								 <option value="U8-U9">U8-U9</option>
								 <option value="U10-U11">U10-U11</option>
								 <option value="U12-U13">U12-U13</option>
								 <option value="U14-U15">U14-U15</option>
								 <option value="U16-U17">U16-U17</option>
								 <option value="U18-U19-U20-Junior">U18-U19-U20-Junior</option>
								 <option value="senior">Sénior</option>
							 </select>
							 <label>Materialize Select</label>
						 </div>

Numéro de téléphone du Club : <input type="text" name="numTel"/>
<button type="submit">Envoyer</button>
</form>
HTML
);

echo $page->toHTML();
