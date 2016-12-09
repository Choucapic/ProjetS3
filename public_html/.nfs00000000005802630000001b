<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/club.class.php';
include_once 'class/mypdo.include.php';

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
  switch ($_POST['type']) {
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
    /* -------------------- Inscription de Club -------------------- */
    case 'insClub' :
      $pageName = 'Inscription de Club';
      if (isset($_POST['nom']) && isset($_POST['refClub']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['ville']) && isset($_POST['numTel'])) {
        if ($_POST['nom'] != '' && $_POST['refClub'] != '' && $_POST['adresse'] != '' && $_POST['cp'] != '' && $_POST['ville'] != '' && $_POST['numTel'] != '') {
          $data = $_POST;
          $club = Club::createFromArray($data);
          $club->save();

          $error = false;
          $url="index";
          $message = 'Le club a bien été créé, <br> Vous allez être redirigé vers l\'accueil';
          $time=3;
        } else {
          $error = true;
          $url="insClub";
          $message = 'Un des champs est vide <br> Vous allez être redirigé automatiquement';
          $time=5;
        }
      } else {
        $error = true;
        $url="insClub";
        $message = 'Problème de création de club <br> Vous allez être redirigé automatiquement';
        $time=5;
      }
      break;
      /* -------------------- Inscription d'Equipe -------------------- */
      case 'insEquipe' :
      $pageName = 'Inscription d\'Equipe';
      if (isset($_POST['idCoach']) && isset($_POST['refClub']) && isset($_POST['idCat'])) {
        if ($_POST['idCoach'] != '' && $_POST['refClub'] != '' && $_POST['idCat'] != '') {
          $stmt = myPDO::getInstance()->prepare(<<<SQL
                      INSERT INTO `equipe` (`idEquipe`, `idCoach`, `refClub`, `idCat`) VALUES (NULL, '{$_POST['idCoach']}', '{$_POST['refClub']}', '{$_POST['idCat']}');
SQL
);
                  $stmt->execute();
          $error = false;
          $url="index";
          $message = 'L\'Equipe a bien été créée, <br> Vous allez être redirigé vers l\'accueil';
          $time=3;
        } else {
          $error = true;
          $url="insEquipe";
          $message = 'Un des champs est vide <br> Vous allez être redirigé automatiquement';
          $time=5;
        }
      } else {
        $error = true;
        $url="insEquipe";
        $message = 'Problème de création d\'équipe <br> Vous allez être redirigé automatiquement';
        $time=5;
      }
      break;
      /* -------------------- Inscription de Membre -------------------- */
      case 'insMembre' :
      $pageName = 'Inscription d\'Equipe';
      switch ($_POST['Type']) {
        case 'Organisateur' :
        case 'Benevole' :
          if (isset($_POST['nom']) && isset($_POST['prnm']) && isset($_POST['mail']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['ville']) && isset($_POST['numTel'])  && isset($_POST['password'])) {
            if ($_POST['nom'] != '' && $_POST['prnm'] != '' && $_POST['mail'] != '' && $_POST['adresse'] != '' && $_POST['cp'] != '' && $_POST['ville'] != '' && $_POST['numTel'] != '' && $_POST['password'] != '') {
              $stmt = myPDO::getInstance()->prepare(<<<SQL
                          INSERT INTO `membre` (`nom`, `prnm`, `mail`, `adresse`, `cp`, `ville`, `numTel`, `Type`, `password`) VALUES ('{$_POST['nom']}', '{$_POST['prnm']}', '{$_POST['mail']}', '{$_POST['adresse']}', '{$_POST['cp']}', '{$_POST['ville']}', '{$_POST['numTel']}', '{$_POST['Type']}', SHA1('{$_POST['password']}'));
SQL
);
              $stmt->execute();
            $error = false;
            $url="index";
            $message = 'Le Membre ' . $_POST['Type'] . ' a bien été créée, <br> Vous allez être redirigé vers l\'accueil';
            $time=3;
            } else {
              $error = true;
              $url="insMembre";
              $message = 'Un des champs est vide <br> Vous allez être redirigé automatiquement';
              $time=5;
            }
          } else {
            $error = true;
            $url="insMembre";
            $message = 'Problème de création de Membre <br> Vous allez être redirigé automatiquement';
            $time=5;
          }
          break;
        case 'Arbitre' :
          if (isset($_POST['nom']) && isset($_POST['prnm']) && isset($_POST['mail']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['ville']) && isset($_POST['numTel'])  && isset($_POST['password'])  && isset($_POST['numLicence'])   && isset($_POST['niveauArbitre'])) {
            if ($_POST['nom'] != '' && $_POST['prnm'] != '' && $_POST['mail'] != '' && $_POST['adresse'] != '' && $_POST['cp'] != '' && $_POST['ville'] != '' && $_POST['numTel'] != '' && $_POST['password'] != '' && $_POST['numLicence'] != '' && $_POST['niveauArbitre'] != '') {
              $stmt = myPDO::getInstance()->prepare(<<<SQL
                        INSERT INTO `membre` (`nom`, `prnm`, `mail`, `adresse`, `cp`, `ville`, `numTel`, `Type`, `password`, `numLicence`, `niveauArbitre`) VALUES ('{$_POST['nom']}', '{$_POST['prnm']}', '{$_POST['mail']}', '{$_POST['adresse']}', '{$_POST['cp']}', '{$_POST['ville']}', '{$_POST['numTel']}', '{$_POST['Type']}', SHA1('{$_POST['password']}'), '{$_POST['numLicence']}', '{$_POST['niveauArbitre']}');
SQL
);
            $stmt->execute();
            $error = false;
            $url="index";
            $message = 'Le Membre ' . $_POST['Type'] . ' a bien été créée, <br> Vous allez être redirigé vers l\'accueil';
            $time=3;
          } else {
            $error = true;
            $url="insMembre";
            $message = 'Un des champs est vide <br> Vous allez être redirigé automatiquement';
            $time=5;
          }
        } else {
          $error = true;
          $url="insMembre";
          $message = 'Problème de création de Membre <br> Vous allez être redirigé automatiquement';
          $time=5;
        }
          break;
        case 'Coach' :
          if (isset($_POST['nom']) && isset($_POST['prnm']) && isset($_POST['mail']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['ville']) && isset($_POST['numTel'])  && isset($_POST['password'])  && isset($_POST['numLicence'])) {
            if ($_POST['nom'] != '' && $_POST['prnm'] != '' && $_POST['mail'] != '' && $_POST['adresse'] != '' && $_POST['cp'] != '' && $_POST['ville'] != '' && $_POST['numTel'] != '' && $_POST['password'] != '' && $_POST['numLicence'] != '') {
              $stmt = myPDO::getInstance()->prepare(<<<SQL
                      INSERT INTO `membre` (`nom`, `prnm`, `mail`, `adresse`, `cp`, `ville`, `numTel`, `Type`, `password`, `numLicence`) VALUES ('{$_POST['nom']}', '{$_POST['prnm']}', '{$_POST['mail']}', '{$_POST['adresse']}', '{$_POST['cp']}', '{$_POST['ville']}', '{$_POST['numTel']}', '{$_POST['Type']}', SHA1('{$_POST['password']}'), '{$_POST['numLicence']}');
SQL
);
            $stmt->execute();
            $error = false;
            $url="index";
            $message = 'Le Membre ' . $_POST['Type'] . ' a bien été créée, <br> Vous allez être redirigé vers l\'accueil';
            $time=3;
          } else {
            $error = true;
            $url="insMembre";
            $message = 'Un des champs est vide <br> Vous allez être redirigé automatiquement';
            $time=5;
        }
      } else {
        $error = true;
        $url="insMembre";
        $message = 'Problème de création de Membre <br> Vous allez être redirigé automatiquement';
        $time=5;
      }
          break;
        case 'Joueur' :
          if (isset($_POST['nom']) && isset($_POST['prnm']) && isset($_POST['mail']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['ville']) && isset($_POST['numTel']) && isset($_POST['password']) && isset($_POST['numLicence']) && isset($_POST['idEquipe'])) {
            if ($_POST['nom'] != '' && $_POST['prnm'] != '' && $_POST['mail'] != '' && $_POST['adresse'] != '' && $_POST['cp'] != '' && $_POST['ville'] != '' && $_POST['numTel'] != '' && $_POST['password'] != '' && $_POST['numLicence'] != '' && $_POST['idEquipe'] != '') {
              $stmt = myPDO::getInstance()->prepare(<<<SQL
                    INSERT INTO `membre` (`nom`, `prnm`, `mail`, `adresse`, `cp`, `ville`, `numTel`, `Type`, `password`, `numLicence`, `idEquipe`) VALUES ('{$_POST['nom']}', '{$_POST['prnm']}', '{$_POST['mail']}', '{$_POST['adresse']}', '{$_POST['cp']}', '{$_POST['ville']}', '{$_POST['numTel']}', '{$_POST['Type']}', SHA1('{$_POST['password']}'), '{$_POST['numLicence']}', '{$_POST['idEquipe']}');
SQL
);
            $stmt->execute();
            $error = false;
            $url="index";
            $message = 'Le Membre ' . $_POST['Type'] . ' a bien été créée, <br> Vous allez être redirigé vers l\'accueil';
            $time=3;
        } else {
          $error = true;
          $url="insMembre";
          $message = 'Un des champs est vide <br> Vous allez être redirigé automatiquement';
          $time=5;
      }
    } else {
      $error = true;
      $url="insMembre";
      $message = 'Problème de création de Membre <br> Vous allez être redirigé automatiquement';
      $time=5;
    }
          break;
        default :
        $error = true;
        $url="insMembre";
        $message = 'Problème de création de Membre <br> Vous allez être redirigé automatiquement';
        $time=5;
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
