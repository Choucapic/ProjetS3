<?php

session_start();

include_once'class/webpage.class.php';
include_once'class/match.class.php';
include_once'class/terrain.class.php';
include_once'class/mypdo.include.php';
include_once'class/equipe.class.php';

$page = new Webpage('planning des matchs');

$page->appendCss(<<<CSS

/* theme */
.responsive {width : 1000px; height:1000px; }
.my_gracket { width : 100em; }
.g_gracket { width: 100em; background-color: #fff; padding: 55px 15px 5px; line-height: 100%; position: relative; overflow: hidden;}
.g_round { float: left; margin-right: 70px; }
.g_game { position: relative; margin-bottom: 15px; box-shadow: 3px 4px 0px #ddd; border: 1px solid #fff; border-top: 0; border-left: 0; }
.g_gracket h3 { min-width: 180px; margin: 0; padding: 10px 8px 8px; font-size: 18px; font-weight: normal; color: #fff} /* @note: this width determinds node size */
.g_team { background: #3597AE; }
.g_round_label { top: -5px; font-weight: normal; color: #ccc; text-align: center; font-size: 18px}
.g_team:last-child {  background: #FCB821; }
.g_round:last-child { margin-right: 20px; }
.g_winner { background: #444; }
.g_winner .g_team { background: none; }
.g_current { cursor: pointer; background: #A0B43C!important; }

/* custom colors*/
.g_team_custom { background: #444; border-radius: 50px 50px 0 0; }
.g_team_custom:last-child {  background: #777; border-radius: 0 0 50px 50px; }
.g_winner_custom .g_team_custom { background: none; border-radius: 50px; }
.g_winner_custom { background: #444; border-radius: 50px; }
.g_current_custom { cursor: pointer; background: #900!important; }
.g_gracket .g_team_custom h3 { font-weight: bold; padding: 30px; text-shadow: 0 2px 1px #222222; text-transform: uppercase; }
.g_game_custom { position: relative; margin-bottom: 15px; }

/* secondary-bracket */
.container-secondary { position: relative; overflow: hidden; }
.secondary-bracket { bottom: 40px; left: 802px; position: absolute; width: 500px; }
.container-secondary h4 { color: #CCCCCC; font-weight: normal; left: 0; margin: 0; padding: 0; position: absolute; bottom: 55px; z-index: 9999; }
.secondary-bracket .g_round_label { top: -25px; }
.secondary-bracket > div { padding-top: 35px;}

CSS
);
$page->appendJsUrl('js/jquery.gracket.min.js');

// Récupérer les terrains
$terrains = array();
$stmt = myPDO::getInstance()->prepare(<<<SQL
          SELECT idTerrain
          FROM `terrain`
SQL
      ) ;
$stmt->execute();
while (($object = $stmt->fetch()) !== false) {
     array_push($terrains, $object['idTerrain']);
}

// Récupérer les équipes
$equipes = Equipe::getAll();


$HTML = "";
$HTMLpage = "";
$numTournoi = 0;
// Algorithme
foreach ($terrains as $idTerrain) {
  $matchs = array();
  $equipesCat = array();
  $stmt = myPDO::getInstance()->prepare(<<<SQL
            SELECT *
            FROM `match`
            WHERE idTerrain = {$idTerrain}
SQL
        ) ;
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,'Match');
  while (($object = $stmt->fetch()) !== false) {
       array_push($matchs, $object);
       if ($object->getIdLocal() != '0' && !in_array($object->getIdLocal(), $equipesCat)) {
         array_push($equipesCat, $object->getIdLocal());
       }
       if ($object->getIdVisiteur() != '0' && !in_array($object->getIdVisiteur(), $equipesCat)) {
         array_push($equipesCat, $object->getIdVisiteur());
       }
  }
  if (count($matchs) != 0) {
    $HTML .= 'win.Tournoi'.$numTournoi.' = [';
    $counter = 0;
    $divider = 2;
    foreach ($matchs as $match) {
     if ($counter == 0) {
       $HTML .= ' [';
     }
     if ($counter < count($equipesCat)/$divider) {
       $HTML .= ' [ {"name" : "' . Equipe::createFromId($match->getIdLocal())->getName() . '", "id" : "'. $match->getIdLocal() . '", "seed" : '. intval($match->getIdLocal()) . ', "score" : '. intval($match->getScoreLocal()) . ' }, { "name" : "' . Equipe::createFromId($match->getIdVisiteur())->getName() . '", "id" : "'. $match->getIdVisiteur() . '", "seed" : '. intval($match->getIdVisiteur()) . ', "score" : '. intval($match->getScoreVisiteur()) . ' } ]';
     }
     $counter++;
     if ($counter == count($equipesCat)/$divider) {
       if (count($equipesCat)/$divider == 1) {
        $HTML .= '],[ [ {"name" : "' . Equipe::createFromId($match->isWinner())->getName() .'", "id" : "'. $match->isWinner(). '", "seed" : '.intval($match->isWinner()).'} ]';
        $HTML .= "]";
      } else {
        $HTML .= "],";
      }
       $counter = 0;
       $divider *= 2;
     } else {
       $HTML .= ',';
     }
 }
 $HTML .= ']; $(".tournoi'.$numTournoi.'").gracket({ src : win.Tournoi'.$numTournoi.' });';
 $HTMLpage .= '<div class="tournoi'.$numTournoi.'"></div>';
 $numTournoi++;
}
}

$page->appendContent(<<<HTML

{$HTMLpage}

<script type="text/javascript">
  (function(win, doc, $){

{$HTML}
/*
    // Fake Data
    win.TestData = [
      [
        [ {"name" : "Erik Zettersten", "id" : "erik-zettersten", "seed" : 1, "score" : 47 }, {"name" : "Andrew Miller", "id" : "andrew-miller", "seed" : 2} ],
        [ {"name" : "James Coutry", "id" : "james-coutry", "seed" : 3}, {"name" : "Sam Merrill", "id" : "sam-merrill", "seed" : 4}],
        [ {"name" : "Anothy Hopkins", "id" : "anthony-hopkins", "seed" : 5}, {"name" : "Everett Zettersten", "id" : "everett-zettersten", "seed" : 6} ],
        [ {"name" : "John Scott", "id" : "john-scott", "seed" : 7}, {"name" : "Teddy Koufus", "id" : "teddy-koufus", "seed" : 8}],
        [ {"name" : "Arnold Palmer", "id" : "arnold-palmer", "seed" : 9}, {"name" : "Ryan Anderson", "id" : "ryan-anderson", "seed" : 10} ],
        [ {"name" : "Jesse James", "id" : "jesse-james", "seed" : 1}, {"name" : "Scott Anderson", "id" : "scott-anderson", "seed" : 12}],
        [ {"name" : "Josh Groben", "id" : "josh-groben", "seed" : 13}, {"name" : "Sammy Zettersten", "id" : "sammy-zettersten", "seed" : 14} ],
        [ {"name" : "Jake Coutry", "id" : "jake-coutry", "seed" : 15}, {"name" : "Spencer Zettersten", "id" : "spencer-zettersten", "seed" : 16}]
      ],
      [
        [ {"name" : "Erik Zettersten", "id" : "erik-zettersten", "seed" : 1}, {"name" : "James Coutry", "id" : "james-coutry", "seed" : 3} ],
        [ {"name" : "Anothy Hopkins", "id" : "anthony-hopkins", "seed" : 5}, {"name" : "Teddy Koufus", "id" : "teddy-koufus", "seed" : 8} ],
        [ {"name" : "Ryan Anderson", "id" : "ryan-anderson", "seed" : 10}, {"name" : "Scott Anderson", "id" : "scott-anderson", "seed" : 12} ],
        [ {"name" : "Sammy Zettersten", "id" : "sammy-zettersten", "seed" : 14}, {"name" : "Jake Coutry", "id" : "jake-coutry", "seed" : 15} ]
      ],
      [
        [ {"name" : "Erik Zettersten", "id" : "erik-zettersten", "seed" : 1}, {"name" : "Anothy Hopkins", "id" : "anthony-hopkins", "seed" : 5} ],
        [ {"name" : "Ryan Anderson", "id" : "ryan-anderson", "seed" : 10}, {"name" : "Sammy Zettersten", "id" : "sammy-zettersten", "seed" : 14} ]
      ],
      [
        [ {"name" : "Erik Zettersten", "id" : "erik-zettersten", "seed" : 1}, {"name" : "Ryan Anderson", "id" : "ryan-anderson", "seed" : 10} ]
      ],
      [
        [ {"name" : "Erik Zettersten", "id" : "erik-zettersten", "seed" : 1} ]
      ]
    ];

    // initializer
    $(".my_gracket").gracket({ src : win.TestData });

    */

  })(window, document, jQuery);
</script>
HTML
);

echo $page->toHTML();
