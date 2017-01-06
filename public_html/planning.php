<?php

session_start();

include_once'class/webpage.class.php';

$page = new Webpage('planning des matchs');
$page->appendJsUrl("http://code.jquery.com/jquery-1.7.1.min.js");
$page->appendCss(<<<CSS
body { font-family: helvetica, verdana, arial, sans-serif; font-size: 12px; background-color: #efefef; color: #333;}
.wrapper { margin: 0; width: 100%; overflow: hidden; border-radius: 0 5px 5px 5px; }


/* theme */
.g_gracket { width: 9999px; background-color: #fff; padding: 55px 15px 5px; line-height: 100%; position: relative; overflow: hidden;}
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

$page->appendContent(<<<HTML
<h3>Large brackets...</h3>
<div class="wrapper">
  <div data-gracket='[
      [
        [ {"name" : "Erik Zettersten", "id" : "erik-zettersten", "seed" : 1}, {"name" : "Andrew Miller", "id" : "andrew-miller", "seed" : 2} ],
        [ {"name" : "James Coutry", "id" : "james-coutry", "seed" : 3}, {"name" : "Sam Merrill", "id" : "sam-merrill", "seed" : 4}],
        [ {"name" : "Anothy Hopkins", "id" : "anthony-hopkins", "seed" : 5}, {"name" : "Everett Zettersten", "id" : "everett-zettersten", "seed" : 6} ],
        [ {"name" : "John Scott", "id" : "john-scott", "seed" : 7}, {"name" : "Teddy Koufus", "id" : "teddy-koufus", "seed" : 8}],
        [ {"name" : "Arnold Palmer", "id" : "arnold-palmer", "seed" : 9}, {"name" : "Ryan Anderson", "id" : "ryan-anderson", "seed" : 10} ],
        [ {"name" : "Jesse James", "id" : "jesse-james", "seed" : 11}, {"name" : "Scott Anderson", "id" : "scott-anderson", "seed" : 12}],
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
    ]'>
  </div>
</div>
<script type="text/javascript">pla(function(g){g.fn.gracket=function(k){g.fn.gracket.defaults={gracketClass:"g_gracket",gameClass:"g_game",roundClass:"g_round",roundLabelClass:"g_round_label",teamClass:"g_team",winnerClass:"g_winner",spacerClass:"g_spacer",currentClass:"g_current",cornerRadius:15,canvasId:"g_canvas",canvasClass:"g_canvas",canvasLineColor:"#eee",canvasLineCap:"round",canvasLineWidth:2,canvasLineGap:15,roundLabels:[],src:{}};if("object"!==typeof JSON)return g.error("json2 does not exsist. Please add the script to your head!"); var j=this,q=JSON.parse(j.data("gracket"))||JSON.parse(this.gracket.defaults.src),r,s,y;g.fn.gracket.settings={};var t={init:function(a){this.gracket.settings=g.extend({},this.gracket.defaults,a);this.gracket.settings.canvasId=this.gracket.settings.canvasId+"_"+(new Date).getTime();a=document.createElement("canvas");a.id=this.gracket.settings.canvasId;a.className=this.gracket.settings.canvasClass;a.style.position="absolute";a.style.left=0;a.style.top=0;a.style.right="auto";j.addClass(this.gracket.settings.gracketClass).prepend(a); s=q.length;for(a=0;a<s;a++){var d=l.build.round(this.gracket.settings);j.append(d);y=q[a].length;for(var b=0;b<y;b++){var c=l.build.game(this.gracket.settings),f=j.find("."+this.gracket.settings.gameClass).outerHeight(!0),f=l.build.spacer(this.gracket.settings,f,a,0!==a&&0===b?!0:!1);0==b%1&&0!==a&&d.append(f);d.append(c);r=q[a][b].length;for(f=0;f<r;f++){var o=l.build.team(q[a][b][f],this.gracket.settings);c.append(o);1===r&&(c.prev().remove(),l.align.winner(c,this.gracket.settings,c.parent().prev().children().eq(0).height()), l.listeners(this.gracket.settings,q,c.parent().prev().children().eq(1)))}}}}},l={build:{team:function(a,d){return team=g("<div />",{html:"<h3><span>"+(a.seed||0)+"</span> "+a.name+"</h3>","class":d.teamClass+" "+(a.id||"id_null")})},game:function(a){return game=g("<div />",{"class":a.gameClass})},round:function(a){return round=g("<div />",{"class":a.roundClass})},spacer:function(a,d,b,c){return spacer=g("<div />",{"class":a.spacerClass}).css({height:c?(Math.pow(2,b)-1)*(d/2):(Math.pow(2,b)-1)*d})}, labels:function(a,d){var b,c=a.length,f;for(b=0;b<c;b++)f=0===b?d.padding+d.width*b:d.padding+d.width*b+d.right*b,g("<h5 />",{text:d.labels.length?d.labels[b]:"Round "+(b+1),"class":d["class"]}).css({position:"absolute",left:f,width:d.width}).prependTo(j)},canvas:{resize:function(a){a=document.getElementById(a.canvasId);a.height=j.innerHeight();a.width=j.innerWidth();g(a).css({height:j.innerHeight(),width:j.innerWidth(),zIndex:1,pointerEvents:"none"})},draw:function(a,d,b){var c=document.getElementById(a.canvasId); "undefined"!=typeof G_vmlCanvasManager&&G_vmlCanvasManager.initElement(c);var c=c.getContext("2d"),f=b.outerWidth(!0),o=b.outerHeight(!0),k=parseInt(j.css("paddingLeft"))||0,q=parseInt(j.css("paddingTop"))||0;parseInt(b.css("marginBottom"));var r=f+k,p=parseInt(j.find("> div").css("marginRight"))||0,e=a.cornerRadius,u=a.canvasLineGap,t=b.height()-2*b.find("> div").eq(1).height();_playerHt=b.find("> div").eq(1).height();e>o/3&&(e=o/3);e>p/2&&(e=p/2-2);0>=e&&(e=1);u>p/3&&(u=p/3);c.strokeStyle=a.canvasLineColor; c.lineCap=a.canvasLineCap;c.lineWidth=a.canvasLineWidth;c.beginPath();var b=Math.pow(2,d.length-2),m=0,v,s=0.5,w=0===m&&1===b?!0:!1;if(w)var x=g("."+a.gameClass),f=x.eq(x.length-1),o=f.outerHeight(!0),f=f.outerWidth(!0);for(;1<=b;){for(v=0;v<b;v++){1==b&&(s=1);var h=w?f+k:r+m*f+m*p,i=s*p,n=((Math.pow(2,m-1)-0.5)*(m&&1)+v*Math.pow(2,m))*o+q+(w?x.find("> div").eq(1).height():_playerHt)+t/2;c.moveTo(h+u,n);1<b?c.lineTo(h+i-e,n):c.lineTo(h+i-u,n);b<Math.pow(2,d.length-2)&&(c.moveTo(h-f-u,n),c.lineTo(h- f-0.5*p,n));1<b&&0==v%2&&(c.moveTo(h+i,n+e),c.lineTo(h+i,n+Math.pow(2,m)*o-e),h=h+i-e,i=n+e,c.moveTo(h,i-e),c.arcTo(h+e,i-e,h+e,i,e),i=n+Math.pow(2,m)*o-e,c.moveTo(h+e,i-e),c.arcTo(h+e,i+e,h,i+e,e))}m++;b/=2}c.stroke();l.build.labels(d,{width:f,padding:k,left:r,right:p,labels:a.roundLabels,"class":a.roundLabelClass})}}},align:{winner:function(a,d,b){b=1===a.parent().siblings().not("canvas").length?b-(a.height()+a.height()/2):b+a.height()/2;return a.addClass(d.winnerClass).css({"margin-top":b})}}, listeners:function(a,d,b){g.each(g("."+a.teamClass+" > h3"),function(){var b="."+g(this).parent().attr("class").split(" ")[1];void 0!==b&&g(b).hover(function(){g(b).addClass(a.currentClass)},function(){g(b).removeClass(a.currentClass)})});l.build.canvas.resize(a);l.build.canvas.draw(a,d,b)}};if(t[k])return t[k].apply(this,Array.prototype.slice.call(arguments,1));if("object"===typeof k||!k)return t.init.apply(this,arguments);g.error('Method "'+k+'" does not exist in gracket!')}})(jQuery);</script>
HTML
);

$page->appendJs(<<<JS

var isIE = ($.browser.msie && parseInt($.browser.version) < 9);

// init on data-gracket
$("[data-gracket]").eq(0).gracket({
  cornerRadius : (isIE ? 0 : 15),
  canvasLineGap : 15
});

// init on data-gracket
$("[data-gracket]").eq(1).gracket({
  cornerRadius : (isIE ? 0 : 15),
  canvasLineGap : 15
});

// init on data-gracket
$("[data-gracket]").eq(2).gracket({
  cornerRadius : (isIE ? 0 : 50),
  canvasLineGap : 0,
  teamClass : "g_team_custom",
  gameClass : "g_game_custom",
  currentClass : "g_current_custom",
  canvasLineColor : "#444",
  winnerClass : "g_winner_custom"
});

// init on data-gracket
$("[data-gracket]").eq(3).gracket({
  cornerRadius : (isIE ? 0 : 15),
  canvasLineGap : 15
});

// init on data-gracket
$("[data-gracket]").eq(4).gracket({
  cornerRadius : (isIE ? 0 : 15),
  canvasLineGap : 15
});

// init on data-gracket
$("[data-gracket]").eq(5).gracket({
  cornerRadius : (isIE ? 0 : 15),
  roundLabels : ["SPORTS : 1st Round", "SPORTS : 2nd Round", "SPORTS : WINNER!!!!"]
});

// add some labels
$(".container-secondary .secondary-bracket .g_winner")
  .parent()
  .css("position", "relative")
  .prepend("<h4>3rd Place</h4>")

$(".container-secondary > div").eq(0).find(".g_winner")
  .parent()
  .css("position", "relative")
  .prepend("<h4>Winner</h4>")

JS
);

$page->appendJs(<<<JS

function(g) {
    g.fn.gracket = function(k) {
        g.fn.gracket.defaults = {
            gracketClass: "g_gracket",
            gameClass: "g_game",
            roundClass: "g_round",
            roundLabelClass: "g_round_label",
            teamClass: "g_team",
            winnerClass: "g_winner",
            spacerClass: "g_spacer",
            currentClass: "g_current",
            cornerRadius: 15,
            canvasId: "g_canvas",
            canvasClass: "g_canvas",
            canvasLineColor: "#eee",
            canvasLineCap: "round",
            canvasLineWidth: 2,
            canvasLineGap: 15,
            roundLabels: [],
            src: {}
        };
        if ("object" !== typeof JSON) return g.error("json2 does not exsist. Please add the script to your head!");
        var j = this,
            q = JSON.parse(j.data("gracket")) || JSON.parse(this.gracket.defaults.src),
            r, s, y;
        g.fn.gracket.settings = {};
        var t = {
                init: function(a) {
                    this.gracket.settings = g.extend({}, this.gracket.defaults, a);
                    this.gracket.settings.canvasId = this.gracket.settings.canvasId + "_" + (new Date).getTime();
                    a = document.createElement("canvas");
                    a.id = this.gracket.settings.canvasId;
                    a.className = this.gracket.settings.canvasClass;
                    a.style.position = "absolute";
                    a.style.left = 0;
                    a.style.top = 0;
                    a.style.right = "auto";
                    j.addClass(this.gracket.settings.gracketClass).prepend(a);
                    s = q.length;
                    for (a = 0; a < s; a++) {
                        var d = l.build.round(this.gracket.settings);
                        j.append(d);
                        y = q[a].length;
                        for (var b = 0; b < y; b++) {
                            var c = l.build.game(this.gracket.settings),
                                f = j.find("." + this.gracket.settings.gameClass).outerHeight(!0),
                                f = l.build.spacer(this.gracket.settings, f, a, 0 !== a && 0 === b ? !0 : !1);
                            0 == b % 1 && 0 !== a && d.append(f);
                            d.append(c);
                            r = q[a][b].length;
                            for (f = 0; f < r; f++) {
                                var o = l.build.team(q[a][b][f], this.gracket.settings);
                                c.append(o);
                                1 === r && (c.prev().remove(), l.align.winner(c, this.gracket.settings, c.parent().prev().children().eq(0).height()), l.listeners(this.gracket.settings, q, c.parent().prev().children().eq(1)))
                            }
                        }
                    }
                }
            },
            l = {
                build: {
                    team: function(a, d) {
                        return team = g("<div />", {
                            html: "<h3><span>" + (a.seed || 0) + "</span> " + a.name + "</h3>",
                            "class": d.teamClass + " " + (a.id || "id_null")
                        })
                    },
                    game: function(a) {
                        return game = g("<div />", {
                            "class": a.gameClass
                        })
                    },
                    round: function(a) {
                        return round = g("<div />", {
                            "class": a.roundClass
                        })
                    },
                    spacer: function(a, d, b, c) {
                        return spacer = g("<div />", {
                            "class": a.spacerClass
                        }).css({
                            height: c ? (Math.pow(2, b) - 1) * (d / 2) : (Math.pow(2, b) - 1) * d
                        })
                    },
                    labels: function(a, d) {
                        var b, c = a.length,
                            f;
                        for (b = 0; b < c; b++) f = 0 === b ? d.padding + d.width * b : d.padding + d.width * b + d.right * b, g("<h5 />", {
                            text: d.labels.length ? d.labels[b] : "Round " + (b + 1),
                            "class": d["class"]
                        }).css({
                            position: "absolute",
                            left: f,
                            width: d.width
                        }).prependTo(j)
                    },
                    canvas: {
                        resize: function(a) {
                            a = document.getElementById(a.canvasId);
                            a.height = j.innerHeight();
                            a.width = j.innerWidth();
                            g(a).css({
                                height: j.innerHeight(),
                                width: j.innerWidth(),
                                zIndex: 1,
                                pointerEvents: "none"
                            })
                        },
                        draw: function(a, d, b) {
                            var c = document.getElementById(a.canvasId);
                            "undefined" != typeof G_vmlCanvasManager && G_vmlCanvasManager.initElement(c);
                            var c = c.getContext("2d"),
                                f = b.outerWidth(!0),
                                o = b.outerHeight(!0),
                                k = parseInt(j.css("paddingLeft")) || 0,
                                q = parseInt(j.css("paddingTop")) || 0;
                            parseInt(b.css("marginBottom"));
                            var r = f + k,
                                p = parseInt(j.find("> div").css("marginRight")) || 0,
                                e = a.cornerRadius,
                                u = a.canvasLineGap,
                                t = b.height() - 2 * b.find("> div").eq(1).height();
                            _playerHt = b.find("> div").eq(1).height();
                            e > o / 3 && (e = o / 3);
                            e > p / 2 && (e = p / 2 - 2);
                            0 >= e && (e = 1);
                            u > p / 3 && (u = p / 3);
                            c.strokeStyle = a.canvasLineColor;
                            c.lineCap = a.canvasLineCap;
                            c.lineWidth = a.canvasLineWidth;
                            c.beginPath();
                            var b = Math.pow(2, d.length - 2),
                                m = 0,
                                v, s = 0.5,
                                w = 0 === m && 1 === b ? !0 : !1;
                            if (w) var x = g("." + a.gameClass),
                                f = x.eq(x.length - 1),
                                o = f.outerHeight(!0),
                                f = f.outerWidth(!0);
                            for (; 1 <= b;) {
                                for (v = 0; v < b; v++) {
                                    1 == b && (s = 1);
                                    var h = w ? f + k : r + m * f + m * p,
                                        i = s * p,
                                        n = ((Math.pow(2, m - 1) - 0.5) * (m && 1) + v * Math.pow(2, m)) * o + q + (w ? x.find("> div").eq(1).height() : _playerHt) + t / 2;
                                    c.moveTo(h + u, n);
                                    1 < b ? c.lineTo(h + i - e, n) : c.lineTo(h + i - u, n);
                                    b < Math.pow(2, d.length - 2) && (c.moveTo(h - f - u, n), c.lineTo(h - f - 0.5 * p, n));
                                    1 < b && 0 == v % 2 && (c.moveTo(h + i, n + e), c.lineTo(h + i, n + Math.pow(2, m) * o - e), h = h + i - e, i = n + e, c.moveTo(h, i - e), c.arcTo(h + e, i - e, h + e, i, e), i = n + Math.pow(2, m) * o - e, c.moveTo(h + e, i - e), c.arcTo(h + e, i + e, h, i + e, e))
                                }
                                m++;
                                b /= 2
                            }
                            c.stroke();
                            l.build.labels(d, {
                                width: f,
                                padding: k,
                                left: r,
                                right: p,
                                labels: a.roundLabels,
                                "class": a.roundLabelClass
                            })
                        }
                    }
                },
                align: {
                    winner: function(a, d, b) {
                        b = 1 === a.parent().siblings().not("canvas").length ? b - (a.height() + a.height() / 2) : b + a.height() / 2;
                        return a.addClass(d.winnerClass).css({
                            "margin-top": b
                        })
                    }
                },
                listeners: function(a, d, b) {
                    g.each(g("." + a.teamClass + " > h3"), function() {
                        var b = "." + g(this).parent().attr("class").split(" ")[1];
                        void 0 !== b && g(b).hover(function() {
                            g(b).addClass(a.currentClass)
                        }, function() {
                            g(b).removeClass(a.currentClass)
                        })
                    });
                    l.build.canvas.resize(a);
                    l.build.canvas.draw(a, d, b)
                }
            };
        if (t[k]) return t[k].apply(this, Array.prototype.slice.call(arguments, 1));
        if ("object" === typeof k || !k) return t.init.apply(this, arguments);
        g.error('Method "' + k + '" does not exist in gracket!')
    }
}

JS
);

echo $page->toHTML();
