<?php

session_start();

include_once 'class/webpage.class.php';

$page = new WebPage('Connect');

if (isset($_POST['submit'])) {

  $login  = (isset($_POST['login'])) ? htmlentities(trim($_POST['login'])) : '';
  $password   = (isset($_POST['password'])) ? sha1(htmlentities(trim($_POST['password'])))   : '';

  if (($login != '') && ($password != '')) {
    include_once 'class/mypdo.include.class.php';


    $pdo = myPDO::getInstance();
    $stmt = $pdo->prepare(<<<SQL
                          SELECT nom, prnm, mail, password, type
                          FROM membre
                          WHERE mail = "{$login}" AND password = "{$password}"
SQL
                          ) ;

    $stmt->execute();
    if (($result = $stmt->fetch()) !== false) {
    $_SESSION['login'] = $result['mail'];
    $_SESSION['nom'] = $result['nom'];
    $_SESSION['prenom'] = $result['prnm'];
    $_SESSION['type'] = $result['type'];

    $url="index";
    $message="Vous êtes bien connecté, vous allez être redirigé vers l'accueil";
    } else {
      $url="auth";
      $message = "Problème de mail ou de mot de passe <br> Vous allez être redirigé automatiquement";
    }

  } else {
    $url="auth";
    $message = "Mail ou mot de passe vide <br> Vous allez être redirigé automatiquement";
  }
}
$page->appendContent(<<<HTML
<div class="container">
<h5 class="center">{$message}</h5>
</div>
HTML
);

header( "refresh:5; url=" . $url . ".php" );

echo $page->toHTML();
