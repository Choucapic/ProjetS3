<?php

session_start();

include_once 'class/webpage.class.php';

/* -------------------- Déconnexion -------------------- */
if (isset($_GET['type'])) {
  if ($_GET['type'] == 'disconnection') {
    $pageName = 'Déconnexion';
    if (isset($_SESSION['login'])) {
      $error = false;
      $message = 'Vous vous êtes bien déconnecté, vous allez être redirigé vers l\'accueil';

      $_SESSION = array();

      session_destroy();
    } else {
      $error = true;
      $message = 'Vous n\'êtes pas connecté, vous allez être redirigé vers l\'accueil';
    }
    $time = 3;
    $url = 'index';
  } else {
    $error = true;
    $message = 'Problème de paramètre, vous allez être redirigé vers l\'accueil';
    $time = 5;
    $url = 'index';
  }
} else if (isset($_POST['type'])) {
  switch (isset($_POST['type'])) {
    /* -------------------- Connexion -------------------- */
    case 'connection' :
      $pageName = 'Connexion';
      if (isset($_SESSION['login'])) {
        $url="index";
        $error = true;
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
          $error = false;
          $message='Vous êtes bien connecté, vous allez être redirigé vers l\'accueil';
          $time=3;
          } else {
            $url="auth";
            $error = true;
            $message = 'Mail ou de mot de passe incorrect <br> Vous allez être redirigé automatiquement';
            $time=5;
          }

        } else {
          $error = true;
          $url="auth";
          $message = 'Mail ou mot de passe vide <br> Vous allez être redirigé automatiquement';
          $time=5;
        }
      }
      break;
    default :
    $error = true;
    $url = "index";
    $message = 'Demande inconnue, vous allez être redirigé vrs l\'accueil';
    $time = 3;
  }

}

$errorIcon = $error ? '<i class="fa fa-times fa-5x red-text" aria-hidden="true"></i>' : '<i class="fa fa-check fa-5x green-text" aria-hidden="true"></i>';

$page = new WebPage($pageName);

$page->appendContent(<<<HTML
<div class="container">
<h5 class="center"> {$errorIcon} <br> {$message}</h5>
</div>
HTML
);

header( "refresh:".$time."; url=".$url.".php" );

echo $page->toHTML();
