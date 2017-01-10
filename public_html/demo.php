<?php
//require_once 'class/match.class.php';
require_once 'class/webpage.class.php';
require_once 'class/terrain.class.php';
$page = new webpage("Planning");
$page->appendJsUrl("js/timetable.js");
$page->appendCssUrl("css/timetablejs.css");
$page->appendCssUrl("css/demo.css");
$places = "[".rtrim(Terrain::getAllTerrains(), ",'Terrain ")."']";
var_dump($places);
$page->appendContent(<<<HTML
    <div class="edt">
    <div class="hero-unit">
      <h1>Emploi du temps de la compétition</h1>
    </div>
    <div class="timetable"></div>
    <script type="text/javascript">
      var timetable = new Timetable();
      var places = <?php echo($places)?>;
      timetable.setScope(7,22)

      timetable.addLocations();

      timetable.addEvent('Sightseeing', 'Rotterdam', new Date(2015,7,17,9,00), new Date(2015,7,17,11,30), { url: '#' });
      timetable.addEvent('Zumba', 'Madrid', new Date(2015,7,17,12), new Date(2015,7,17,13), { url: '#' });
      timetable.addEvent('Zumbu', 'Madrid', new Date(2015,7,17,13,30), new Date(2015,7,17,15), { url: '#' });
      timetable.addEvent('Lasergaming', 'London', new Date(2015,7,17,17,45), new Date(2015,7,17,19,30), { class: 'vip-only', data: { maxPlayers: 14, gameType: 'Capture the flag' } });
      timetable.addEvent('All-you-can-eat grill', 'New York', new Date(2015,7,17,21), new Date(2015,7,18,1,30), { url: '#' });
      timetable.addEvent('Hackathon', 'Tokyo', new Date(2015,7,17,11,30), new Date(2015,7,17,20)); // options attribute is not used for this event
      timetable.addEvent('Tokyo Hackathon Livestream', 'Los Angeles', new Date(2015,7,17,12,30), new Date(2015,7,17,16,15));
      timetable.addEvent('Lunch', 'Jakarta', new Date(2015,7,17,9,30), new Date(2015,7,17,11,45), { url: '#' });
      timetable.addEvent('Cocktails', 'Rotterdam', new Date(2015,7,18,00,00), new Date(2015,7,18,02,00), { class: 'vip-only' });

      var renderer = new Timetable.Renderer(timetable);
      renderer.draw('.timetable');
      </script>
      </div>
HTML
);
echo $page->toHTML();