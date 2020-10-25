<?php

$title = "Page d'accueil";
$cssfile = "index";
ob_start();

?>
<div id="top_div_title">
    <a href="index.php"><img src="public/img/essai_logo.png" alt=""></a>
    <div id="button_div">
        <a href="index.php?action=signup" id="enregistrer">
            <div>
                <p>Inscription</p>
            </div>
        </a>
        <a id="ou">
            <div>
                <p>ou</p>
            </div>
        </a>
        <a href="index.php?action=signin" id="se_connecter">
            <div>
                <p>Connexion</p>
            </div>
        </a>
    </div>
</div>
<div id="petite_presentation">
    <p>CodeManager et GitHub :<br> une façon intelligente de développer en groupe</p>
    <div></div>
    <p id="seconde_ligne">Une méthode pour faciliter la communication et <br>la gestion des projet communs</p>
    <a href="index.php?action=signup" id="inscription_div">
        INSCRIVEZ-VOUS GRATUITEMENT
    </a>
    <div class="savoir_plus_link">
      <a href="#infos_generales_site">
          <p id="savoir_plus">EN SAVOIR PLUS ></p>
      </a>
    </div>

    <div id="disponible_div">
        <p id="disponible">Désormais disponible sur tous les navigateurs, <br>et à utiliser sans modération pour tous vos projets</p>
    </div>

</div>
<div class="img_scroll_down_container">
  <img class="img_scroll_down" src="public/img/scrolldown.png" alt="">
</div>
<!--<video id="videointro" src="../public/../public/img/Codes.mp4" loop autoplay></video>-->
<div id="div_img_accueil">
    <!--<img id="img_accueil" src="../public/../public/img/codebcc.jpg">-->
</div>

<div id="infos_generales_site">
    <div class="flex_horizon">
        <img class="img_index_desc" src="public/img/shareindex.png">
        <h1>Concentrez-vous sur l'organisation</h1>
        <div id="flex_p">
            <p>Un travail basé sur la cohésion au sein de l'équipe. <br>Un travail plus que collaboratif.</p>
            <p>Un projet commun.<br>Le partage entre les participants.</p>
            <p>Un outil pour répartir le travail, partager ses documents et suivre l'avancement du projet.</p>
        </div>
        <br><br><br>
        <div class="séparation"></div>
        <br><br><br>
        <img class="img_index_desc" src="public/img/objectiveindex.png">
        <h1>Atteignez vos objectifs</h1>
        <div id="flex_p">
            <p>Une répartition du travail intelligente.<br>Travailler efficaceent et intelligemment</p>
            <p>Une gestion simple mais efficace de l'avancement<br>L'attribution de différents rôles au sein du projet
            </p>
            <p>Des objectifs à atteidre pour avancer et pour terminer votre projet sans retard.</p>
        </div>
        <br><br><br>
        <!--<div class="séparation"></div>-->
        <br><br><br>
        <div id="bcc_icons">
            <h1>Des fonctionnalités pour faciliter et sécuriser le travail</h1>
            <br><br><br>
            <div id="flex_p">
                <div class="flexcol">
                    <img src="public/img/documentindex.png">
                    <h2 class="fonctionnalites"><strong>Fichiers à la demande</strong></h2>
                </div>
                <div class="flexcol">
                    <img src="public/img/listindex.png">
                    <h2 class="fonctionnalites"><strong>Des tâches et objectifs pour avancer rapidement</strong>
                    </h2>
                </div>
                <div class="flexcol">
                    <img src="public/img/uploadindex.png">
                    <h2 class="fonctionnalites"><strong>Plusieurs fichiers de sauvegarde</strong></h2>
                </div>
            </div>
        </div>
    </div>

    <div id="espace_div_bcc">
        <div class="content_div_espace">
            <h1><strong>Lancez-vous dès à présent ou <br>continuez un projet existant</strong></h1><br><br><br>
            <p>Lancez vous dès à présent en vous incrivant, cela ne prend qu'une seule minute.</p>
            <p>Et c'est totalement <strong>GRATUIT</strong> !</p><br><br>
            <p id="p_different">Ou alors continuez un projet déjà existant en vous connectant ></p>
            <a href="index.php?action=signin" id="button_espace">
              <div class="button_espace_container">
                    <p>ACCÉDER À MON ESPACE</p>
              </div>
            </a>
        </div>
        <img src="public/img/spring-swing-rocket.png">
    </div>
</div>

<?php

$content = ob_get_clean();
require('template/home.php');

?>
