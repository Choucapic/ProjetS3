<?php

class WebPage {
    /**
     * @var string Texte compris entre <head> et </head>
     */
    private $head  = null ;
    /**
     * @var string Texte compris entre <title> et </title>
     */
    private $title = null ;
    /**
     * @var string Texte compris entre <body> et </body>
     */
    private $body  = null ;

    /**
     * Constructeur
     * @param string $title Titre de la page
     */
    public function __construct($title=null) {
        $this->setTitle($title) ;
    }

    /**
     * Retourner le contenu de $this->body
     *
     * @return string
     */
    public function body() {
        return $this->body ;
    }

    /**
     * Retourner le contenu de $this->head
     *
     * @return string
     */
    public function head() {
        return $this->head ;
    }

    /**
     * Donner la derni�re modification du script principal
     * @link http://php.net/manual/en/function.getlastmod.php
     * @link http://php.net/manual/en/function.strftime.php
     *
     * @return string
     */
    public function getLastModification() {
        return strftime("Derni�re modification de cette page le %d/%m/%Y � %Hh%M", getlastmod()) ;
    }

    /**
     * Prot�ger les caract�res sp�ciaux pouvant d�grader la page Web
     * @see http://php.net/manual/en/function.htmlentities.php
     * @param string $string La cha�ne � prot�ger
     *
     * @return string La cha�ne prot�g�e
     */
    public static function escapeString($string) {
        return htmlentities($string, ENT_QUOTES|ENT_HTML5, "utf-8") ;
    }

    /**
     * Affecter le titre de la page
     * @param string $title Le titre
     */
    public function setTitle($title) {
        $this->title = $title ;
    }

    /**
     * Ajouter un contenu dans head
     * @param string $content Le contenu � ajouter
     *
     * @return void
     */
    public function appendToHead($content) {
        $this->head .= $content ;
    }

    /**
     * Ajouter un contenu CSS dans head
     * @param string $css Le contenu CSS � ajouter
     *
     * @return void
     */
    public function appendCss($css) {
        $this->appendToHead(<<<HTML
    <style type='text/css'>
    $css
    </style>

HTML
) ;
    }

    /**
     * Ajouter l'URL d'un script CSS dans head
     * @param string $url L'URL du script CSS
     *
     * @return void
     */
    public function appendCssUrl($url) {
        $this->appendToHead(<<<HTML
    <link rel="stylesheet" type="text/css" href="{$url}">

HTML
) ;
    }

    /**
     * Ajouter un contenu JavaScript dans head
     * @param string $js Le contenu JavaScript � ajouter
     *
     * @return void
     */
    public function appendJs($js) {
        $this->appendToHead(<<<HTML
    <script type='text/javascript'>
    $js
    </script>

HTML
) ;
    }

    /**
     * Ajouter l'URL d'un script JavaScript dans head
     * @param string $url L'URL du script JavaScript
     *
     * @return void
     */
    public function appendJsUrl($url) {
        $this->appendToHead(<<<HTML
    <script type='text/javascript' src='$url'></script>

HTML
) ;
    }

    /**
     * Ajouter un contenu dans body
     * @param string $content Le contenu � ajouter
     *
     * @return void
     */
    public function appendContent($content) {
        $this->body .= $content ;
    }

    /**
     * Produire la page Web compl�te
     *
     * @return string
     * @throws Exception si title n'est pas d�fini
     */
    public function toHTML($isConnected = false) {
        if (is_null($this->title)) {
            throw new Exception(__CLASS__ . ": title not set") ;
        }

        $isConnected = isset($_SESSION['login']);

        if ($isConnected) {
          // Menu déconnexion
          $urlConnect = '<li><a href="script.php?type=disconnection" class="waves-effect"><i class="fa fa-toggle-on fa-2x green-text" aria-hidden="true"></i>Se déconnecter</a></li>';

          // Menu de profil
          $urlProfile = '<li><a href="profile.php" class="waves-effect"><i class="fa fa-user fa-2x" aria-hidden="true"></i>Mon profil</a></li>';

          // Récupération du nom et du type d'utilisateur pour les incorporer à la vignette
          $userName = $_SESSION['nom'] . " " . $_SESSION['prenom'];
          $fixUserName = strlen($userName) > 20 ? 'style="width:200px;"' : '';
          $userType = $_SESSION['type'] == 'Benevole' ? 'Bénévole' : $_SESSION['type'];

          // Switch permettant de modifier le menu en fonction du type d'utilisateur
          switch ($userType) {

            case 'Organisateur':
            $menuType = '
            <ul class="collapsible" data-collapsible="accordion">
              <li>
                <div class="collapsible-header waves-effect">
                  <i class="fa fa-users fa-2x" aria-hidden="true"></i>Gestion des équipes
                </div>
                <div class="collapsible-body blue darken-2 center">
                  <a href="insEquipe.php" class="waves-effect">Inscrire une équipe</a>
                  <a href="seeEquipe.php" class="waves-effect">Voir les équipes</a>
                </div>
              </li>

              <li>
                <div class="collapsible-header waves-effect">
                  <i class="fa fa-id-card-o fa-2x" aria-hidden="true"></i>Gestion des Matchs
                </div>
                <div class="collapsible-body blue darken-2 center">
                  <a href="seeMatch.php" class="waves-effect">Voir les matchs</a>
                  <a href="tournament.php" class="waves-effect">Créer un tournoi</a>
                </div>
              </li>

              <li>
                <div class="collapsible-header waves-effect">
                  <i class="fa fa-home fa-2x" aria-hidden="true"></i>Gestion des clubs
                </div>
                <div class="collapsible-body blue darken-2 center">
                  <a href="insClub.php" class="waves-effect">Inscrire un club</a>
                  <a href="seeClub.php" class="waves-effect">Voir les clubs</a>
                </div>
              </li>
            </ul>
            ';
            break;
            case 'Arbitre':
            $menuType = '
              <li><a class="waves-effect" href="#!"><i class="fa fa-empire fa-2x" aria-hidden="true"></i>Menu 1 Arbitre</a></li>
              <li><a class="waves-effect" href="#!"><i class="fa fa-empire fa-2x" aria-hidden="true"></i>Menu 2 Arbitre</a></li>
            ';
            break;
            case 'Joueur':
            $menuType = '
              <li><a class="waves-effect" href="#!"><i class="fa fa-empire fa-2x" aria-hidden="true"></i>Menu 1 Joueur</a></li>
              <li><a class="waves-effect" href="#!"><i class="fa fa-empire fa-2x" aria-hidden="true"></i>Menu 2 Joueur</a></li>
            ';
            break;
            case 'Coach':
            $menuType = '
              <li><a class="waves-effect" href="#!"><i class="fa fa-empire fa-2x" aria-hidden="true"></i>Menu 1 Coach</a></li>
              <li><a class="waves-effect" href="#!"><i class="fa fa-empire fa-2x" aria-hidden="true"></i>Menu 2 Coach</a></li>
            ';
            break;
            case 'Bénévole':
            $menuType = '
              <li><a class="waves-effect" href="#!"><i class="fa fa-empire fa-2x" aria-hidden="true"></i>Menu 1 Bénévole</a></li>
              <li><a class="waves-effect" href="#!"><i class="fa fa-empire fa-2x" aria-hidden="true"></i>Menu 2 Bénevole</a></li>
            ';
            break;
            case 'Administrateur':
            $menuType = '
            <ul class="collapsible" data-collapsible="accordion">
              <li>
                <div class="collapsible-header waves-effect">
                  <i class="fa fa-users fa-2x" aria-hidden="true"></i>Gestion des équipes
                </div>
                <div class="collapsible-body blue darken-2 center">
                  <a href="insEquipe.php" class="waves-effect">Inscrire une équipe</a>
                  <a href="seeEquipe.php" class="waves-effect">Voir les équipes</a>
                </div>
              </li>

              <li>
                <div class="collapsible-header waves-effect">
                  <i class="fa fa-id-card-o fa-2x" aria-hidden="true"></i>Gestion des comptes
                </div>
                <div class="collapsible-body blue darken-2 center">
                  <a href="insMembre.php" class="waves-effect"> Inscrire un membre</a>
                  <a href="seeMembre.php" class="waves-effect">Voir les membres</a>
                </div>
              </li>

              <li>
                <div class="collapsible-header waves-effect">
                  <i class="fa fa-home fa-2x" aria-hidden="true"></i>Gestion des clubs
                </div>
                <div class="collapsible-body blue darken-2 center">
                  <a href="insClub.php" class="waves-effect">Inscrire un club</a>
                  <a href="seeClub.php" class="waves-effect">Voir les clubs</a>
                </div>
              </li>

              <li>
                <div class="collapsible-header waves-effect">
                  <i class="fa fa-id-card-o fa-2x" aria-hidden="true"></i>Gestion des Matchs
                </div>
                <div class="collapsible-body blue darken-2 center">
                  <a href="seeMatch.php" class="waves-effect">Voir les matchs</a>
                  <a href="tournament.php" class="waves-effect">Créer un tournoi</a>
                </div>
              </li>
            </ul>
            ';
            break;
          }
        } else {
          // Menu connexion
          $urlConnect = '<li><a href="auth.php" class="waves-effect"><i class="fa fa-toggle-off fa-2x red-text" aria-hidden="true"></i>Se connecter</a></li>';

          $urlProfile = '';

          $userName = "";
          $fixUserName = "";
          $userType = "";

          $menuType = "";
        }


        return <<<HTML
<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>{$this->title}</title>

        <script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">
        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="css/index.css">
        <script src="js/index.js"></script>


{$this->head()}
    </head>
    <body>
    <header>
        <ul class="side-nav fixed blue darken-3" id="slide-out">
            <li><div class="userView">
                <p class="typeUser"><strong>{$userType}</strong></p>
                <a href="http://www.ajbetheny.fr/" target="_blank"><img src="img/betheny.jpg" alt="Amicale des Jeunes de Betheny"       width="300px"></img></a>
                <p class="nameUser" {$fixUserName}><strong>{$userName}</strong></p>
                </div></li>
            <li><a href="index.php" class="waves-effect"><i class="fa fa-home fa-2x" aria-hidden="true"></i>Accueil</a></li>
            {$urlProfile}
            {$urlConnect}
            <!-- lien vers planning -->
            <ul class="collapsible" data-collapsible="accordion">
              <li>
                <div class="collapsible-header waves-effect">
                  <i class="fa fa-table fa-2x" aria-hidden="true"></i>Tournoi
                </div>
                <div class="collapsible-body blue darken-2 center">
                  <a href="planning.php" class="waves-effect">Voir le Tournoi</a>
                  <a href="demo.php" class="waves-effect">Voir les horaires</a>
                </div>
              </li>
            </ul>
            <li><div class="divider"></div></li>
            {$menuType}
        </ul>
        <div class="row fixed blue darken-3 menu hide-on-large-only">
          <div class="col s1">
            <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons menu-button">menu</i></a>
          </div>
          <div class="col s11">
            <h5 class="white-text center">{$this->title}</h5>
          </div>
          </div>
        </div>
    </header>
    <main>
      <div class="card-panel fixed blue darken-3 menu hide-on-med-and-down">
        <h4 class="white-text center">{$this->title}</h4>
      </div>
{$this->body()}
        </main>
    </body>
</html>
HTML;
    }
}
