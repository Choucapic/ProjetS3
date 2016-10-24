<?php

include_once 'class/webpage.class.php';

$page = new WebPage('Authentification');

$page->appendContent(<<<HTML
<div class="container">
 <form method="post" name="authentification" action="#" class="col s12">
   <div class="row">
     <div class="input-field col m6 s12">
       <i class="material-icons prefix fa fa-at"></i>
       <input id="login" type="email" class="validate">
       <label for="login">Adresse Mail</label>
     </div>

     <div class="input-field col m6 s12">
       <i class="material-icons prefix fa fa-lock"></i>
       <input id="password" type="password" class="validate">
       <label for="password">Mot de passe</label>
     </div>
   </div>
   <div class="btn-auth">
   <button class="btn blue darken-3 waves-effect waves-light" type="submit" name="action">Se connecter
<i class="material-icons right">send</i>
</button>
</div>
 </form>
</div>
HTML
);

echo $page->toHTML();
