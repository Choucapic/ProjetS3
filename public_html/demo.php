<?php
require_once 'class/match.class.php';
require_once 'class/equipe.class.php';
require_once 'class/webpage.class.php';
require_once 'class/terrain.class.php';
require_once 'class/plage.class.php';
$page = new webpage("Planning");
$page->appendJsUrl("js/timetable.js");
$page->appendCssUrl("css/timetablejs.css");
$page->appendCssUrl("css/demo.css");
$places = "[".rtrim(Terrain::getAllTerrains(), ",'Terrain ")."']";
$page->appendContent(<<<HTML
    <div class="edt">
    <div class="hero-unit">
      <h1>Emploi du temps de la compétition</h1>
    </div>
    <div class="timetable"></div>
    <script>
      var timetable = new Timetable();
      timetable.setScope(7,22);
      var arr = {$places};
      timetable.addLocations(arr);
HTML
);

foreach(Match::getAllMatchs() as $match){
    $eq1 = Equipe::createFromId($match->getIdLocal());
    $eq2 = Equipe::createFromId($match->getIdVisiteur());
    $plage = Plage::createFromId($match->getIdPlage());
    $page->appendContent(<<<HTML
      timetable.addEvent('{$eq1->getName()} VS {$eq2->getName()}', 'Terrain {$match->getIdTerrain()}',new Date({$plage->getDeb()}),new Date({$plage->getFin()}));
HTML
);  
}
$page->appendContent(<<<HTML
      var renderer = new Timetable.Renderer(timetable);
      renderer.draw('.timetable');
      </script>
      </div>
HTML
);
echo $page->toHTML();