<?php

session_start();

include_once 'class/webpage.class.php';

$page = new WebPage('Authentification');

if (isset($_SESSION['login'])) {

  $page->appendContent(<<<HTML
  <div class="container">
    <h5 class="center">Vous êtes déjà connecté</h5>
  </div>
HTML
);

header( "refresh:3; url=index.php" );

} else {
    $page->appendContent(<<<HTML
    <div class="container">
    <form id="connect" method="post" name="authentification" action="connect.php" class="col s12">
    <div class="row">
      <div class="input-field col m6 s12">
        <i class="material-icons prefix fa fa-at"></i>
        <input id="login" type="email" class="validate" name="login">
        <label for="login">Adresse Mail</label>
        </div>

        <div class="input-field col m6 s12">
        <i class="material-icons prefix fa fa-lock"></i>
        <input id="password" type="password" class="validate" name="password">
        <label for="password">Mot de passe</label>
        </div>
     </div>
     <div class="btn-auth">
     <button class="btn blue darken-3 waves-effect waves-light" type="submit" name="submit">Se connecter
     <i class="material-icons right">send</i>
     </button>
     </div>
     </form>
     </div>
HTML
);
}

echo $page->toHTML();
