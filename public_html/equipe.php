<?php

session_start();

include_once 'class/webpage.class.php';
include_once 'class/mypdo.include.php';
require_once 'class/match.class.php';
require_once 'class/equipe.class.php';
require_once 'class/club.class.php';
require_once 'class/categorie.class.php';
require_once 'class/arbitre.class.php';
require_once 'class/plage.class.php';
require_once 'class/coach.class.php';

$page = new WebPage('Gestion des equipes');
$page->appendCss(<<<CSS
  nav{
    margin-right : 25%;
    Background-color : #1565C0;
  }
  table{
    margin-top : 50px;
  }
  #nav {
  text-align : center;
}
  #score {
  margin-left : 10%;
  margin-right : 10%;
}
CSS
);

if(isset($_SESSION['login'])){
    if($_SESSION['type'] == 'Organisateur'){

       if(isset($_GET['option'])) {$option = $_GET['option']; }
        else { $option = "afficher"; }
      $page->appendContent(<<<HTML

HTML
);
      switch($option){

            ################     AFFICHAGE     ###############
        case "afficher" :

        $page->appendContent(<<<HTML
        <nav>
            <ul class="brand-logo center">
              <li class="active"><a href="equipe.php?option=afficher"><i class="material-icons">tab</i>Afficher les equipes</a></li>
              <li><a href="equipe.php?option=modifier"><i class="material-icons">settings</i> Modifier une equipe</a></li>
            </ul>
        </nav>
                <div class="container">
              <table>
                <thead>
                  <tr>
                      <th data-field="numéro">Numéro</th>
                      <th data-field="nom">Nom</th>
                      <th data-field="coach">Coach</th>
                      <th data-field="reference">Reference du club</th>
                      <th data-field="categorie">Catégorie</th>
                  </tr>
                </thead>
                <tbody>
HTML
);
        $equipes = Equipe::getAllEquipes();

        foreach($equipes as $equipe){
        $club = Club::createFromId($equipe->getRefClub());
        $coach = Coach::createFromId($equipe->getIdCoach());
        $categorie = Categorie::createFromId($equipe->getIdCat());
          $page->appendContent(<<<HTML
          <tr>
            <td>{$equipe->getIdEquipe()}</td>
            <td>{$club->getNom()} {$equipe->getIdCat()}</td>
            <td>{$coach->getNom()} {$coach->getPrenom()}</td>
            <td>{$equipe->getRefClub()}</td>
            <td>{$equipe->getIdCat()}</td>
          </tr>
HTML
);
          }

        $page->appendContent(<<<HTML
                </tbody>
              </table>
            </div>

HTML
);
    break;
    ################      AJOUT     ###############
/*      case "ajouter" :
      $page->appendContent(<<<HTML
        <nav>
          <ul class="brand-logo center">
            <li><a href="matchs.php?option=afficher"><i class="material-icons">tab</i> Afficher les matchs</a></li>
            <li class="active"><a href="matchs.php?option=ajouter"><i class="material-icons">library_add</i> Ajouter match </a></li>
            <li><a href="matchs.php?option=modifier"><i class="material-icons">settings</i>Modifier les données des matchs </a></li>
          </ul>
        </nav>
        </div>
            <div class="container">

                <form class="form" method="POST" action="script.php" class="col s12">
            			<div class="row">
              				<div class="input-field col s12 m6">
              					<input type="text" name="local" class="validate" required/>
              					<label for="local">Equipe n°1</label>
              				</div>
              				<div class="input-field col s12 m6">
              					<input type="text" name="visiteur" class="validate" required/>
              					<label for="visiteur">Equipe n°2</label>
              				</div>
              				<div class="input-field col s12 m6">
              					<input type="text" name="idTerrain" class="validate" required/>
              					<label for="idTerrain">Identifiant du terrain choisi</label>
              				</div>
              				<div class="input-field col s12 m6">
              					<input type="text" name="arbitre 1" class="validate" required/>
              					<label for="arbitre 1">Arbitre n°1</label>
              				</div>
              				<div class="input-field col s12 m6">
              					<input type="text" name="arbitre 2" class="validate" required/>
              					<label for="arbitre 2">Arbitre n°2</label>
              				</div>
              				<div class="input-field col s12 m6">
              					<input type="time" name="plage" class="validate" required/>
              					<!--label for="plage">Heure du match</label>--!>
              				</div>
                      <div class="input-field col s12 m6">
              					<input type="date" name="plage" class="validate" required/>
              					<!--<label for="plage">Jour du match</label>--!>
              				</div
              				<input type="hidden" name="type" value="insMatch"/>
                  </div>
              	  <div class="btn-auth">
            		    <button class="btn blue darken-3 waves-effect waves-light" type="submit" name="action"> Ajouter le match</button>
            		</div>
            	</form>
            </div>
HTML
);
*/
    break;
    ################      MODIFICATION     ###############
        case "modifier" :
          $page->appendContent(<<<HTML
          <nav>
            <ul class="brand-logo center">
              <li><a href="equipe.php?option=afficher"><i class="material-icons">tab</i>Afficher les matchs</a></li>
              <li class="active"><a href="equipe.php?option=modifier"><i class="material-icons">settings</i> Modifier les données des matchs </a></li>
            </ul>
          </nav>
          <div id="score">
            <form class="form" method="POST" action="script.php" class="col s12" >
              <div class="row">
                  <div class="input-field col s12 m6">
                    <input type="text" name="idEquipe" class="validate" required/>
                    <label for="local">Identifiant Equipe</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <input type="text" name="nom" class="validate" required/>
                    <label for="local">Nom Equipe</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <input type="text" name="coach" class="validate" required/>
                    <label for="local">coach</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <input type="text" name="refClub" class="validate" required/>
                    <label for="local">Reference du Club</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <input type="text" name="categorie" class="validate" required/>
                    <label for="local">Categorie</label>
                  </div>
                  <input type="hidden" name="type" value="insMatch"/>
              </div>
              <div class="btn-auth">
                <button class="btn blue darken-3 waves-effect waves-light" type="submit" name="action"> Modifier</button>
            </div>
          </form>
        </div>
HTML
);
              break;

        }
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
