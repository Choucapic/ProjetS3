<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/club.class.php';
include_once 'class/mypdo.include.php';
include_once 'class/categorie.class.php';
include_once 'class/match.class.php';
include_once 'class/plage.class.php';
include_once 'class/equipe.class.php';

if (isset($_GET['type'])) {
  switch ($_GET['type']) {
     /* -------------------- Déconnexion -------------------- */
     case 'disconnection' :
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
      break;
    /* -------------------- Supprimer un Membre -------------------- */
    case 'delMembre' :
      $pageName = "Supprimer un membre";
      if (isset($_SESSION['login'])) {
        if ($_SESSION['type'] == 'Administrateur') {
          if (isset($_GET['id'])) {
            $stmt = myPDO::getInstance()->prepare(<<<SQL
                   DELETE FROM `membre`
                   WHERE idMembre = {$_GET['id']}
SQL
               ) ;
            $stmt->execute();
            $error = false;
            $message = 'Le membre a bien été supprimé, vous allez être redirigé automatiquement';
            $time = 5;
            $url = 'seeMembre';
          } else {
            $error = true;
            $message = 'Problème de paramètre, vous allez être redirigé automatiquement';
            $time = 5;
            $url = 'seeMembre';
          }
        } else {
          $error = true;
          $message = 'Vous n\'avez pas les droits requis, vous allez être redirigé vers l\'accueil';
          $time = 5;
          $url = 'index';
        }
      } else {
        $error = true;
        $message = 'Vous n\'êtes pas connecté, vous allez être redirigé vers l\'accueil';
        $time = 5;
        $url = 'index';
      }
      break;
    /* -------------------- Supprimer une Equipe -------------------- */
    case 'delEquipe' :
      $pageName = "Supprimer une équipe";
      if (isset($_SESSION['login'])) {
        if ($_SESSION['type'] == 'Administrateur') {
          if (isset($_GET['id'])) {
            $stmt = myPDO::getInstance()->prepare(<<<SQL
                   DELETE FROM `equipe`
                   WHERE idEquipe = {$_GET['id']}
SQL
               ) ;
            $stmt->execute();
            $error = false;
            $message = 'L\'Equipe a bien été supprimé, vous allez être redirigé automatiquement';
            $time = 5;
            $url = 'seeEquipe';
          } else {
            $error = true;
            $message = 'Problème de paramètre, vous allez être redirigé automatiquement';
            $time = 5;
            $url = 'seeEquipe';
          }
        } else {
          $error = true;
          $message = 'Vous n\'avez pas les droits requis, vous allez être redirigé vers l\'accueil';
          $time = 5;
          $url = 'index';
        }
      } else {
        $error = true;
        $message = 'Vous n\'êtes pas connecté, vous allez être redirigé vers l\'accueil';
        $time = 5;
        $url = 'index';
      }
      break;
    /* -------------------- Supprimer un Club -------------------- */
    case 'delClub' :
      $pageName = "Supprimer un club";
      if (isset($_SESSION['login'])) {
        if ($_SESSION['type'] == 'Administrateur') {
          if (isset($_GET['id'])) {
            $stmt = myPDO::getInstance()->prepare(<<<SQL
                   DELETE FROM `club`
                   WHERE refClub = {$_GET['id']}
SQL
               ) ;
            $stmt->execute();
            $error = false;
            $message = 'Le Club a bien été supprimé, vous allez être redirigé automatiquement';
            $time = 5;
            $url = 'seeEquipe';
            } else {
            $error = true;
            $message = 'Problème de paramètre, vous allez être redirigé automatiquement';
            $time = 5;
            $url = 'seeEquipe';
          }
        } else {
          $error = true;
          $message = 'Vous n\'avez pas les droits requis, vous allez être redirigé vers l\'accueil';
          $time = 5;
          $url = 'index';
        }
      } else {
        $error = true;
        $message = 'Vous n\'êtes pas connecté, vous allez être redirigé vers l\'accueil';
        $time = 5;
        $url = 'index';
      }
      break;
    default :
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
    /* -------------------- Modification de Membre -------------------- */
    case 'modifyMembre' :
      $pageName = 'Modification de Membre';
      if (isset($_POST['nom']) && isset($_POST['prnm']) && isset($_POST['mail']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['ville']) && isset($_POST['numTel'])) {
        if ($_POST['nom'] != '' && $_POST['prnm'] != '' && $_POST['mail'] != '' && $_POST['adresse'] != '' && $_POST['cp'] != '' && $_POST['ville'] != '' && $_POST['numTel'] != '') {

          $SQLset = 'nom = \''.$_POST['nom'].'\', prnm = \''.$_POST['prnm'].'\', mail = \''.$_POST['mail'].'\', adresse = \''.$_POST['adresse'].'\', cp = \''.$_POST['cp'].'\', ville = \''.$_POST['ville'].'\' , numTel = \''.$_POST['numTel'].'\'';

          if (isset($_POST['numLicence'])) {
            if ($_POST['numLicence'] != '') {
              $SQLset .= ', numLicence = \''.$_POST['numLicence'].'\'';
            }
          }

          if (isset($_POST['niveauArbitre'])) {
            if ($_POST['niveauArbitre'] != '') {
              $SQLset .= ', niveauArbitre = \''.$_POST['niveauArbitre'].'\'';
            }
          }

          if (isset($_POST['idEquipe'])) {
            if ($_POST['idEquipe'] != '') {
              $SQLset .= ', idEquipe = \''.$_POST['idEquipe'].'\'';
            }
          }

          if (isset($_POST['password'])) {
            if ($_POST['password'] != '') {
              $SQLset .= ', password = \''.$_POST['password'].'\'';
            }
          }

          $stmt = myPDO::getInstance()->prepare(<<<SQL
                UPDATE membre
                SET {$SQLset}
                WHERE idMembre = {$_POST['idMembre']}
SQL
);
          $stmt->execute();
          $error = false;
          $url="index";
          $message = 'Le Membre a bien été modifié, <br> Vous allez être redirigé vers l\'accueil';
          $time=3;
        } else {
          $error = true;
          $url="seeMembre";
          $message = 'Un des champs est vide <br> Vous allez être redirigé automatiquement';
          $time=5;
      }
      } else {
        $error = true;
        $url="seeMembre";
        $message = 'Problème de modification de Membre <br> Vous allez être redirigé automatiquement';
        $time=5;
      }
      break;
    /* -------------------- Modification de Club -------------------- */
    case 'modifyClub' :
      $pageName = 'Modification de Club';
      if (isset($_POST['refClub']) && isset($_POST['nom']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['ville']) && isset($_POST['numTel'])) {
        if ($_POST['refClub'] != '' && $_POST['nom'] != '' && $_POST['adresse'] != '' && $_POST['cp'] != '' && $_POST['ville'] != '' && $_POST['numTel'] != '') {
          $stmt = myPDO::getInstance()->prepare(<<<SQL
                UPDATE club
                SET nom = '{$_POST['nom']}', adresse = '{$_POST['adresse']}', cp = '{$_POST['cp']}', ville = '{$_POST['ville']}', numTel = '{$_POST['numTel']}'
                WHERE refClub = {$_POST['refClub']}
SQL
);
          $stmt->execute();
          $error = false;
          $url="index";
          $message = 'Le Club a bien été modifié, <br> Vous allez être redirigé vers l\'accueil';
          $time=3;
        } else {
          $error = true;
          $url="seeClub";
          $message = 'Un des champs est vide <br> Vous allez être redirigé automatiquement';
          $time=5;
      }
      } else {
        $error = true;
        $url="seeClub";
        $message = 'Problème de modification de Club <br> Vous allez être redirigé automatiquement';
        $time=5;
      }
      break;
    /* -------------------- Modification de Club -------------------- */
    case 'modifyMatch' :
      $pageName = 'Modification de Match';
     if (isset($_POST['idMatch']) && isset($_POST['scoreLocal']) && isset($_POST['scoreVisiteur']) && isset($_POST['idArbitre1']) && isset($_POST['idArbitre2']) && isset($_POST['idNextMatch'])) {
        if ($_POST['idMatch'] != '' && $_POST['scoreLocal'] != '' && $_POST['scoreVisiteur'] != '' && $_POST['idArbitre1'] != '' && $_POST['idArbitre2'] != '' && $_POST['idNextMatch'] != '') {
          $stmt = myPDO::getInstance()->prepare(<<<SQL
                UPDATE `match`
                SET scoreLocal = '{$_POST['scoreLocal']}', scoreVisiteur = '{$_POST['scoreVisiteur']}', idArbitre1 = '{$_POST['idArbitre1']}', idArbitre2 = '{$_POST['idArbitre2']}'
                WHERE idMatch = {$_POST['idMatch']}
SQL
  );
          $stmt->execute();
          if ($_POST['idNextMatch'] != -1) {
          $match = Match::createFromId($_POST['idMatch']);
          $nextMatch = Match::createFromId($_POST['idNextMatch']);
          if ($nextMatch->getIdLocal() == 0) {
            $nextMatch->setIdLocal($match->isWinner());
          } else {
            $nextMatch->setIdVisiteur($match->isWinner());
          }
          $nextMatch->save();
          }
          $error = false;
          $url="planning";
          $message = 'Le Match a bien été modifié, <br> Vous allez être redirigé automatiquement';
          $time=25;
        } else {
          $error = true;
          $url="seeMatch";
          $message = 'Un des champs est vide <br> Vous allez être redirigé automatiquement';
          $time=5;
      }
      } else {
        $error = true;
        $url="seeMatch";
        $message = 'Problème de modification de Match <br> Vous allez être redirigé automatiquement';
        $time=5;
      }
        break;
    /* -------------------- Nouveau Tournoi -------------------- */
    case 'newTournament' :
    if (isset($_POST['categories']) && isset($_POST['hDeb']) && isset($_POST['hFin'])) {
      if (count($_POST['categories']) != 0 && $_POST['hDeb'] != '' && $_POST['hFin'] != '') {
      $pageName = 'Nouveau Tournoi';

    // On récupère les variables
    $postCategories = $_POST['categories'];
    $postHDeb = $_POST['hDeb'].':00';
    $postHFin = $_POST['hFin'].':00';

    // On nettoie la table Match
    $stmt = myPDO::getInstance()->prepare(<<<SQL
           DELETE FROM `match`
SQL
       ) ;
    $stmt->execute();

    // On nettoie la table Plage
    $stmt = myPDO::getInstance()->prepare(<<<SQL
           DELETE FROM `plage`
SQL
       ) ;
    $stmt->execute();

    // On crée une plage "vide" qui correspond à l'heure de début de tournoi dans la journée
    $stmt = myPDO::getInstance()->prepare(<<<SQL
           INSERT INTO `plage` (`idPlage`, `jour`, `hDeb`, `hFin`)
           VALUES ('1', '1', '{$postHDeb}', '{$postHDeb}')
SQL
       ) ;
    $stmt->execute();
    $plage = Plage::createFromId(1)->getNextPlage($postHDeb, $postHFin, 30);
   $categories = array();
    foreach ($postCategories as $categorie) {
      array_push($categories, Categorie::createFromId($categorie));
    }
    $equipes = Equipe::getAll();
    $idMatchs = 0;
    $HTML = "";
    foreach ($categories as $categorie) {
      $equipesCat = array();
      $matchs = array();
     foreach ($equipes as $equipe) {
       if ($equipe->getIdCat() == $categorie->getIdCat()) {
         array_push($equipesCat, $equipe);
       }
     }
     if (count($equipesCat) != 0) {
     if ($idMatchs != 0) $plage = Plage::createFromId(1)->getNextPlage($postHDeb, $postHFin, 30, $plage);
     $nombreEquipes = count($equipesCat);
     if ($nombreEquipes%2 == 0 && $nombreEquipes%3 != 0) {
       for ($i = 0; $i < $nombreEquipes; $i = $i+2) {
         array_push($matchs, new Match($idMatchs, $categorie->getTerrain(), $equipesCat[$i]->getIdEquipe(), $equipesCat[$i+1]->getIdEquipe(), 0, 0, 6, 6, $plage, -1));
         $plage = Plage::createFromId($plage)->getNextPlage($postHDeb, $postHFin, 30);
         $idMatchs++;
       }
       $nombreEquipes /= 2;
       $newMatchs = Match::recursiveMatch($matchs, $idMatchs, $plage, $categorie->getTerrain(), $postHDeb, $postHFin);
       $idMatchs += count($newMatchs) + 1;
       foreach ($newMatchs as $newMatch) {
         array_push($matchs, $newMatch);
       }
       foreach ($matchs as $match) {
         $match->save();
       }
     }

    }
  }
    $error = false;
    $url = "planning";
    $message = 'Le tournoi a bien été créé';
    $time = 3;
  } else {
    $error = true;
    $url="tournament";
    $message = 'Un des champs est vide <br> Vous allez être redirigé automatiquement';
    $time=5;
}
} else {
  $error = true;
  $url="tournament";
  $message = 'Problème de création de tournoi <br> Vous allez être redirigé automatiquement';
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
