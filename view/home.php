<?php

$title = "Code Manager - Accueil";
$cssfile = "index";
$jsfile = "home";
$_SESSION['last_page'] = 'home';
ob_start();

?>
<div id="top_div_title">
    <a href="index.php" class="top_resp1"><img src="public/img/essai_logo.png" alt=""></a>
    <a href="index.php" class="top_resp2"><img src="public/img/shortcuticon.png" alt=""></a>
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
    <p>CodeManager :<br> une façon intelligente de développer en groupe</p>
    <div></div>
    <p id="seconde_ligne">Une méthode pour faciliter la communication <br>et la gestion des projet communs</p>
    <a href="index.php?action=signup" id="inscription_div">
        INSCRIVEZ-VOUS GRATUITEMENT
    </a>
    <div class="savoir_plus_link">
      <a href="#img_scroll_down_container">
          <p id="savoir_plus">EN SAVOIR PLUS ></p>
      </a>
    </div>

    <div id="disponible_div">
        <p id="disponible">Désormais disponible sur tous les navigateurs, <br>et à utiliser sans modération pour tous vos projets</p>
    </div>

</div>
<div id="img_scroll_down_container" class="img_scroll_down_container">
  <img class="img_scroll_down" src="public/img/scrolldown.png" alt="">
</div>
<!--<video id="videointro" src="../public/../public/img/Codes.mp4" loop autoplay></video>-->
<div id="div_img_accueil">
    <!--<img id="img_accueil" src="../public/../public/img/codebcc.jpg">-->
</div>

<div id="infos_generales_site">
    <div class="flex_horizon">
        <img class="img_index_desc show-on-scroll" src="public/img/shareindex.png">
        <h1 class="show-on-scroll">Concentrez-vous sur l'organisation</h1>
        <div id="flex_p">
            <p class="p1 show-on-scroll" >Un travail basé sur la cohésion au sein de l'équipe. <br>Un travail plus que collaboratif.</p>
            <p class="p2 show-on-scroll" >Gérez facilement les particpants, et attribuez leur un rôle et des permissions spécifiques.</p>
            <p class="p3 show-on-scroll" >Un outil pour répartir le travail, suivre l'avancement et discuter du projet au sein même de la plateforme.</p>
        </div>
        <br><br><br>
        <div class="séparation"></div>
        <br><br><br>
        <img class="img_index_desc show-on-scroll" src="public/img/objectiveindex.png">
        <h1 class="show-on-scroll">Soyez efficace dans votre travail</h1>
        <div id="flex_p">
            <p class="p1 show-on-scroll">Une répartition du travail intelligente, grâce à un système de tâches et d'objectifs avancé</p>
            <p class="p2 show-on-scroll">Une gestion simple mais efficace de l'avancement.<br>L'attribution de différents rôles et permissions au sein du projet
            </p>
            <p class="p3 show-on-scroll">Des objectifs à atteindre pour avancer et pour terminer votre projet sans retard.</p>
        </div>
        <br><br><br>
        <!--<div class="séparation"></div>-->
        <br><br><br>
        <div id="bcc_icons">
          <h1 class="title_white show-on-scroll">Des fonctionnalités pour faciliter et sécuriser le travail</h1>
            <div class="flex_icons_white" id="flex_p">
                <div class="p2 show-on-scroll flexcol">
                    <img src="public/img/listindex.png">
                    <h2 class="fonctionnalites"><strong>Des tâches et objectifs pour avancer rapidement</strong>
                    </h2>
                </div>
                <div class="p3 show-on-scroll flexcol">
                    <img src="public/img/permission.png">
                    <h2 class="fonctionnalites"><strong>Des permissions et rôles pour gérer l'équipe</strong></h2>
                </div>
                <div class="p3 show-on-scroll flexcol">
                    <img src="public/img/githublogo.png">
                    <h2 class="fonctionnalites"><strong>Une vision globale du GitHub</strong></h2>
                </div>
            </div>
        </div>
    </div>

    <div id="espace_div_bcc">
        <div class="content_div_espace">
            <h1><strong>Lancez-vous dès à présent ou <br>continuez un projet existant</strong></h1>
            <div class="separator_height"></div>
            <p>Lancez vous dès à présent en vous incrivant, cela ne prend qu'une seule minute.</p>
            <p>Et c'est totalement <strong>GRATUIT</strong> !</p><br><br>
            <p id="p_different">Ou alors continuez un projet déjà existant en vous connectant ></p>
            <div class="bottom_bottom">
              <a href="index.php?action=signin" id="button_espace">
                <div class="button_espace_container">
                      <p>ACCÉDER À MON ESPACE</p>
                </div>
              </a>
            </div>

        </div>
        <div class="div_img">
          <img src="public/img/spring-swing-rocket.png">
        </div>
    </div>
</div>

<?php require('template/message.php'); ?>

<script type="text/javascript">
    window.onload = () => {
        checkMessage()
    }
</script>

<?php

$content = ob_get_clean();
require('template/home.php');

?>
