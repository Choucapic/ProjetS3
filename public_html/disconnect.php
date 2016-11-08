<?php

session_start();

include_once 'class/webpage.class.php';

$page = new WebPage('Disconnect');

if (isset($_SESSION['login'])) {
$page->appendContent(<<<HTML
<div class="container">
<h5 class="center"><i class="fa fa-check fa-5x green-text" aria-hidden="true"></i> <br> Vous vous êtes bien déconnecté, vous allez être redirigé vers l'accueil</h5>
</div>
HTML
);

$_SESSION = array();

session_destroy();
} else {
  $page->appendContent(<<<HTML
  <div class="container">
  <h5 class="center"> Vous n'êtes pas connecté, vous allez être redirigé vers l'accueil</h5>
  </div>
HTML
);
}

header( "refresh:3; url=index.php" );

echo $page->toHTML();
