<script type="text/javascript">
(function(win, doc, $){
win.data = [
HTML
);
$matches = array(Match::getAllFromAvancement(5), Match::getAllFromAvancement(4), Match::getAllFromAvancement(3), Match::getAllFromAvancement(2), Match::getAllFromAvancement(1));
/*{Resultat::getResultByMatch()->getScoreJ1()}*/
foreach($matches as $ma){
$p->appendContent("[\n");
foreach($ma as $m){
$nom1 = Joueur::createFromId($m->getIdJoueur1())->getNom();
$nom2 = Joueur::createFromId($m->getIdJoueur2())->getNom();
$p->appendContent(<<<HTML
[ {"name" : "{$nom1}", "id" : "{$m->getIdJoueur1()}", "seed" : {$m->getIdJoueur1()}, "score" : 5 },{"name" : "{$nom2}", "id" : "{$m->getIdJoueur2()}", "seed" : {$m->getIdJoueur2()}} ]
HTML
);
if($m != end($ma)) $p->appendContent(",");
$p->appendContent("\n");
}
$p->appendContent("],");
}
$p->appendContent(<<<HTML
[
[ {"name" : "Erik Zettersten", "id" : "erik-zettersten", "seed" : 1} ]
]
];
// initializer
$(".my_gracket").gracket({ src : win.data });
})(window, document, jQuery);

</script>
<script src="js/menu.min.js"></script>
HTML
);
