<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';

$page = new WebPage('Gestion des matchs');

$page->appendCss(<<<CSS
CSS
);
if(isset($_SESSION['login'])){
    if($_SESSION['type'] == 'Organisateur'){

       if(isset($_GET['option'])) {$option = $_GET['option']; }
        else { $option = "afficher"; }
      $page->appendContent(<<<HTML
        <div class="container">
          <nav>
            <div class="nav-wrapper blue darken-3">
              <ul id="nav-mobile" class="right col">
HTML
);
      switch($option){
        case "afficher" :
        $page->appendContent(<<<HTML
          <li class ="active" ><a href="matchs.php?option=afficher">Afficher les matchs</a></li>
          <li ><a href="matchs.php?option=ajouter"> Ajouter match </a></li>
                  <li> <a href="matchs.php?option=modifier"> Modifier les données des matchs </a></li>
          <div class="container">
            <h5 class="center"> Affichage des matchs </h5>
            <div class="content">
            </div>
          </div>

HTML
);
    break;
      case "ajouter" :
      $page->appendContent(<<<HTML
      ///A finir !
            <li ><a href="matchs.php?option=afficher">Afficher les matchs</a></li>
            <li class="active" ><a href="matchs.php?option=ajouter"> Ajouter match </a></li>
            <li ><a href="matchs.php?option=modifier"> Modifier les données des matchs </a></li>
            <div>
                <h5 class="center active"> Ajouter des matchs </h5>
                <div>
                  <ul id="labels">
                    <li>
                    <label for="idEquipe">Identifiant Equipe </label>
                    <input type="text" name="idEquipe" class="validate" required/>
                    </li>
                    <li>
                    <label for="idCoach">Identifiant Coach</label>
                    <input type="text" name="idCoach" class="validate" required/>
                    </li>
                    <li>
                    <label for="refClub">Référence du Club</label>
                    <input type="text" name="refClub" class="validate" required/>
                    </li>
                    <li>
                    <label for="idCat">Catégorie</label>
                    <input type="text" name="idCat" class="validate" required/>
                    </li>
                    <li>
                    <label for="name">Nom</label>
                    <input type="text" name="name" class="validate" required/>
                    <li>
                  </ul>
                </div>
            </div>
HTML
);
    break;
        case "modifier" :
          $page->appendContent(<<<HTML
          <li ><a href="matchs.php?option=afficher">Afficher les matchs</a></li>
          <li ><a href="matchs.php?option=ajouter"> Ajouter match </a></li>
          <li class="active"><a href="matchs.php?option=modifier"> Modifier les données des matchs </a></li>
          </div>
          <div class="container">
            <h5 class="center"> modifier des matchs </h5>
          </div>
HTML
);
              break;
        }
        $page->appendContent(<<<HTML
        </ul>
        </div>
        </nav>
        </div>
HTML
);

        }
    else
    {
    $page->appendContent(<<<HTML
    <div class="container">
    <h5 class="center"> <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> Vous n'avez pas les droits requis, vous allez être redirigé vers l'accueil</h5>
    </div>
HTML
);
        header( "refresh:5; url=index.php" );
    }
}
else{
  $page->appendContent(<<<HTML
  <div class="container">
    <h5 class="center">
    <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i>
    <br> Vous n'êtes pas connecté, vous allez être redirigé vers l'accueil</h5>
  </div>
HTML
);
    header( "refresh:5; url=index.php" );
}
echo $page->toHTML();
