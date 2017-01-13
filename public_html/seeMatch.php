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

$page = new WebPage('Gestion des matchs');
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

  tr:nth-child(2n){
    background-color:rgba(17, 91, 166, 0.5);
  }

  tr:nth-child(2n+1){
    background-color:rgba(17, 91, 166, 0.7);
  }

  .tableHead {
    background-color: white !important;
  }
CSS
);

if(isset($_SESSION['login'])){
    if($_SESSION['type'] == 'Organisateur' || $_SESSION['type'] == 'Administrateur'){

        $page->appendContent(<<<HTML

                <div class="container">
              <table>
                <thead>
                  <tr class="tableHead">
                      <th data-field="local">Equipe 1</th>
                      <th data-field="visiteur">Equipe 2</th>
                      <th data-field="Terrain">Terrain</th>
                      <th data-field="arbitre 1">Arbitre 1 </th>
                      <th data-field="arbitre 2 ">Arbitre 2 </th>
                      <th data-field="plage"> Heure du match</th>
                      <th data-field="modify"> Modifier </th>
                  </tr>
                </thead>
                <tbody>
HTML
);
        $matchs = Match::getAllMatchs();

        foreach($matchs as $match){

          $equipe1 = Equipe::createFromId($match->getIdLocal());
          $club1 = Club::createFromId($equipe1->getRefClub());
          $equipe2 = Equipe::createFromId($match->getIdVisiteur());
          $club2 = Club::createFromId($equipe2->getRefClub());
          $arbitre1 = Arbitre::createFromId($match->getIdArbitre1());
          $arbitre2 = Arbitre::createFromId($match->getIdArbitre1());
          $plage = Plage::createFromId($match->getIdPlage());


          $page->appendContent(<<<HTML
          <tr>
            <td>{$club1->getNom()} {$equipe1->getIdCat()}</td>
            <td>{$club2->getNom()} {$equipe1->getIdCat()}</td>
            <td>{$match->getIdTerrain()}</td>
            <td>{$arbitre1->getNom()}  {$arbitre1->getPrenom()}</td>
            <td>{$arbitre2->getNom()}  {$arbitre2->getPrenom()}</td>
            <td>{$plage->getHDeb()} à {$plage->getHFin()}</td>
            <td><a class="black waves-effect waves-light btn" href="modifyMatch.php?id={$match->getIdMatch()}"><i class="material-icons">mode_edit</i></a>
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
      } else {
    $page->appendContent(<<<HTML
    <div class="container">
    <h5 class="center"> <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> Vous n'avez pas les droits requis, vous allez être redirigé vers l'accueil</h5>
    </div>
HTML
);
        header( "refresh:5; url=index.php" );
 }
} else {
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
