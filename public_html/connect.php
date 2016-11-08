<?php

session_start();

include_once 'class/webpage.class.php';

$page = new WebPage('Connect');

if (isset($_SESSION['login'])) {
  $url="index";
  $message="Vous êtes déjà connecté";
  $time=3;
} else if (isset($_POST['submit'])) {

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
    $message='<i class="fa fa-check fa-5x green-text" aria-hidden="true"></i> <br> Vous êtes bien connecté, vous allez être redirigé vers l\'accueil';
    $time=3;
    } else {
      $url="auth";
      $message = '<i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> Mail ou de mot de passe incorrect <br> Vous allez être redirigé automatiquement';
      $time=5;
    }

  } else {
    $url="auth";
    $message = '<i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> Mail ou mot de passe vide <br> Vous allez être redirigé automatiquement';
    $time=5;
  }
}
$page->appendContent(<<<HTML
<div class="container">
<h5 class="center">{$message}</h5>
</div>
HTML
);

header( "refresh:".$time."; url=" . $url . ".php" );

echo $page->toHTML();
