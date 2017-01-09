<?php

session_start();

include_once'class/webpage.class.php';

$page = new Webpage('planning des matchs');
//$page->appendJsUrl("http://code.jquery.com/jquery-1.7.1.min.js");

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

$page->appendContent(<<<HTML

<div class="my_gracket"></div>

<script type="text/javascript">
  (function(win, doc, $){



    // Fake Data
    win.TestData = [
      [
        [ {"name" : "Erik Zettersten", "id" : "erik-zettersten", "seed" : 1, "displaySeed": "D1", "score" : 47 }, {"name" : "Andrew Miller", "id" : "andrew-miller", "seed" : 2} ],
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

  })(window, document, jQuery);
</script>
HTML
);

echo $page->toHTML();
