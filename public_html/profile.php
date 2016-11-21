<?php

session_start();

include_once 'class/webpage.class.php';

$page = new WebPage('Mon Profil');

if (isset($_SESSION['login'])) {

  include_once 'class/mypdo.include.class.php';

  $items = '';

  $pdo = myPDO::getInstance();
  $stmt = $pdo->prepare(<<<SQL
                        SELECT *
                        FROM membre
                        WHERE mail = "{$_SESSION['login']}" AND prnm = "{$_SESSION['prenom']}"
SQL
);

  $stmt->execute();
  if (($result = $stmt->fetch()) !== false) {
    foreach ($result as $key => $value){

      // Affiche le numéro de licence seulement si le compte est Joueur, arbitre ou coach
      if ($key == "numLicence" && ($_SESSION['type'] == 'Arbitre' || $_SESSION['type'] == 'Joueur' || $_SESSION['type'] == 'Coach')) {
        $key = "Numéro de Licence";
        $items .= '<div class="colprofile col l4 m6 s12"> <p> <span class="profilekey">' . $key . ' :</span> <br>' . $value . '</p></div>';
      // Affiche le niveau arbitre seulement si le compte est Arbitre
      } else if ($key == "niveauArbitre" && $_SESSION['type'] == 'Arbitre') {
        $key = "Niveau Arbitre";
        $items .= '<div class="colprofile col l4 m6 s12"> <p> <span class="profilekey">' . $key . ' :</span> <br>' . $value . '</p></div>';
      // Affiche ce qui est commun à tous les comptes
      } else if ($key != "password" && $key != "idMembre" && $key != "idEquipe" && $key != 'Type' && $key != 'numLicence' && $key != 'niveauArbitre'){
        // Fonction pour mettre la majuscule au premier caractère du String
        $key = ucfirst($key);

        switch ($key) {
          case 'Prnm' :
            $key = 'Prénom';
            break;
          case 'NumLicence' :
            $key = 'Numéro de Licence';
            break;
          case 'NumTel' :
            $key = 'Numéro de Téléphone';
            break;
          case 'Cp' :
            $key = 'Code Postal';
            break;
          }

          $items .= '<div class="colprofile col l4 m6 s12"> <p> <span class="profilekey">' . $key . ' :</span> <br>' . $value . '</p></div>';
        }
    }
  }

  $page->appendContent(<<<HTML

<div class="container">

  <div class="row center">
    <h4> {$result['Type']} </h4>
    {$items}

  </div>
</div>
HTML
);

} else {
  $page->appendContent(<<<HTML
  <div class="container">
  <h5 class="center"> <i class="fa fa-times fa-5x red-text" aria-hidden="true"></i> <br> Vous n'êtes pas connecté, vous allez être redirigé vers l'accueil</h5>
  </div>
HTML
  );

header( "refresh:5; url=index.php" );
}

echo $page->toHTML();
