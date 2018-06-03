<?php

// On récupère l'adresseRue de la page
$URL = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];

// Cette fonction est appelée pour la construction de chaque onglet ($i est la 
// position de l'onglet dans la barre)
function construireMenu($nom, $adr, $i) {
    global $URL;
    // Si l'onglet est déjà ouvert, le lien est inactif
    if (($adr != "") && (strpos($URL, $adr))) {
        echo '<li class="c-active c-menu-type-classic"><a class="c-link dropdown-toggle">'.$nom .'<span class="c-arrow c-toggler"></span></a></li>';
    }
    else {
        echo '<li><a href="'.$adr.'" class="c-link dropdown-toggle">'.$nom .'<span class="c-arrow c-toggler"></span></a></li>';
    }
}
