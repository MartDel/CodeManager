var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];
var checkbox = document.getElementById("check_js");
var burger = document.getElementById("menu_checkbox");


btn.onclick = (event) => {
  if (event.target == document.getElementById("check_js")) { /*If checkbox clicked, no event*/
    modal.style.display = "none";
  } else if (event.target == document.getElementById("tick")) {  /*If done clicked, no event*/
    modal.style.display = "none";
  } else if (event.target == document.getElementById("tick2")) {  /*If edit clicked, no event*/
    modal.style.display = "none";
  } else {
    modal.style.display = "block";
  }
};

span.onclick = () => {
  modal.style.display = "none";
};

window.onclick = (event) => {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

/*var menu_opener_count = 1;*/
localStorage.setItem('bgcolor', 1);
/*localStorage.getItem('bgcolor')*/

burger.onclick = () => {
  if (localStorage.getItem('bgcolor') == 1){
    localStorage.setItem('bgcolor', 0);
    /*Suppression des textes*/
    document.getElementById("text_menu_left_1").style.display = "none";
    document.getElementById("text_menu_left_2").style.display = "none";
    document.getElementById("text_menu_left_3").style.display = "none";
    document.getElementById("text_menu_left_4").style.display = "none";
    document.getElementById("text_menu_left_5").style.display = "none";
    document.getElementById("text_menu_left_1").style.opacity = "0";
    document.getElementById("text_menu_left_2").style.opacity = "0";
    document.getElementById("text_menu_left_3").style.opacity = "0";
    document.getElementById("text_menu_left_4").style.opacity = "0";
    document.getElementById("text_menu_left_5").style.opacity = "0";
    document.getElementById("new_task_text").style.display = "none";
    document.getElementById("new_task_text").style.opacity = "0";
    /*document.getElementById("new_task_text").style.visibility = "hidden";*/
    /*gestion des placements*/
    document.getElementById("new_task_div").style.paddingBottom = "7px";
    document.getElementById("new_task_div").style.marginLeft = "23px";
    document.getElementById("new_task_div").style.width = "50px";
    document.getElementById("new_task_img").style.marginLeft = "8px";
    document.getElementsByClassName("img_menu_gauche_js")[0].style.marginLeft = "-23px";
    document.getElementsByClassName("img_menu_gauche_js")[1].style.marginLeft = "-23px";
    document.getElementsByClassName("img_menu_gauche_js")[2].style.marginLeft = "-23px";
    document.getElementsByClassName("img_menu_gauche_js")[3].style.marginLeft = "-23px";
    document.getElementsByClassName("img_menu_gauche_js")[4].style.marginLeft = "-23px";
    document.getElementsByClassName("ligne_et_taches ")[0].style.marginLeft = "100px";
    document.getElementsByClassName("ligne_et_taches ")[0].style.width = "calc(100% - 100px)";
    document.getElementById("menu_gauche").style.width="100px";
    
    document.getElementsByClassName("selectedmenu")[0].style.paddingRight = "0px";
    document.getElementsByClassName("notselectedmenu")[0].style.paddingRight = "0px";
    document.getElementsByClassName("notselectedmenu")[1].style.paddingRight = "0px";
    document.getElementsByClassName("notselectedmenu")[2].style.paddingRight = "0px";
    document.getElementsByClassName("notselectedmenu")[3].style.paddingRight = "0px";
    /*document.getElementById("ligne_haut_tache_id").style.width = "100%";
    document.getElementById("liste_taches").style.width = "1320px";*/
  } else {
    localStorage.setItem('bgcolor', 1);
    /*Ajout des textes*/
    setTimeout(function(){document.getElementById("text_menu_left_1").style.display = "block";},300);
    setTimeout(function(){document.getElementById("text_menu_left_2").style.display = "block";},300);
    setTimeout(function(){document.getElementById("text_menu_left_3").style.display = "block";},300);
    setTimeout(function(){document.getElementById("text_menu_left_4").style.display = "block";},300);
    setTimeout(function(){document.getElementById("text_menu_left_5").style.display = "block";},300);
    setTimeout(function(){document.getElementById("text_menu_left_1").style.opacity = "1";},310);
    setTimeout(function(){document.getElementById("text_menu_left_2").style.opacity = "1";},310);
    setTimeout(function(){document.getElementById("text_menu_left_3").style.opacity = "1";},310);
    setTimeout(function(){document.getElementById("text_menu_left_4").style.opacity = "1";},310);
    setTimeout(function(){document.getElementById("text_menu_left_5").style.opacity = "1";},310);
    setTimeout(function(){document.getElementById("new_task_text").style.display = "block";},300);
    setTimeout(function(){document.getElementById("new_task_text").style.opacity = "1";},310);
    /*setTimeout(function(){document.getElementById("new_task_text").style.visibility = "visible";},500);*/
    /*gestion des placements*/
    setTimeout(function(){document.getElementById("new_task_div").style.paddingBottom = "2px";},300);
    document.getElementById("new_task_div").style.marginLeft = "23px";
    document.getElementById("new_task_div").style.width = "210px";
    document.getElementById("new_task_img").style.marginLeft = "8px";
    document.getElementsByClassName("img_menu_gauche_js")[0].style.marginLeft = "0px";
    document.getElementsByClassName("img_menu_gauche_js")[1].style.marginLeft = "0px";
    document.getElementsByClassName("img_menu_gauche_js")[2].style.marginLeft = "0px";
    document.getElementsByClassName("img_menu_gauche_js")[3].style.marginLeft = "0px";
    document.getElementsByClassName("img_menu_gauche_js")[4].style.marginLeft = "0px";
    document.getElementsByClassName("ligne_et_taches ")[0].style.marginLeft = "260px";
    document.getElementsByClassName("ligne_et_taches ")[0].style.width = "calc(100% - 260px)";
    document.getElementById("menu_gauche").style.width="260px";
    /*document.getElementById("myBtn").style.width="calc(100vw - 259px)";*/
    document.getElementsByClassName("selectedmenu")[0].style.paddingRight = "90px";
    document.getElementsByClassName("notselectedmenu")[0].style.paddingRight = "90px";
    document.getElementsByClassName("notselectedmenu")[1].style.paddingRight = "90px";
    document.getElementsByClassName("notselectedmenu")[2].style.paddingRight = "90px";
    document.getElementsByClassName("notselectedmenu")[3].style.paddingRight = "90px";
    document.getElementsByClassName("ligne_haut_tache")[0].style.width="auto";
  }
}

if (localStorage.getItem('bgcolor') == 1){
  localStorage.setItem('bgcolor', 0);
  /*Suppression des textes*/
  document.getElementById("text_menu_left_1").style.display = "none";
  document.getElementById("text_menu_left_2").style.display = "none";
  document.getElementById("text_menu_left_3").style.display = "none";
  document.getElementById("text_menu_left_4").style.display = "none";
  document.getElementById("text_menu_left_5").style.display = "none";
  document.getElementById("text_menu_left_1").style.opacity = "0";
  document.getElementById("text_menu_left_2").style.opacity = "0";
  document.getElementById("text_menu_left_3").style.opacity = "0";
  document.getElementById("text_menu_left_4").style.opacity = "0";
  document.getElementById("text_menu_left_5").style.opacity = "0";
  document.getElementById("new_task_text").style.display = "none";
  document.getElementById("new_task_text").style.opacity = "0";
  /*document.getElementById("new_task_text").style.visibility = "hidden";*/
  /*gestion des placements*/
  document.getElementById("new_task_div").style.paddingBottom = "7px";
  document.getElementById("new_task_div").style.marginLeft = "23px";
  document.getElementById("new_task_div").style.width = "50px";
  document.getElementById("new_task_img").style.marginLeft = "8px";
  document.getElementsByClassName("img_menu_gauche_js")[0].style.marginLeft = "-23px";
  document.getElementsByClassName("img_menu_gauche_js")[1].style.marginLeft = "-23px";
  document.getElementsByClassName("img_menu_gauche_js")[2].style.marginLeft = "-23px";
  document.getElementsByClassName("img_menu_gauche_js")[3].style.marginLeft = "-23px";
  document.getElementsByClassName("img_menu_gauche_js")[4].style.marginLeft = "-23px";
  document.getElementsByClassName("ligne_et_taches ")[0].style.marginLeft = "100px";
  document.getElementsByClassName("ligne_et_taches ")[0].style.width = "calc(100% - 100px)";
  document.getElementById("menu_gauche").style.width="100px";
  
  document.getElementsByClassName("selectedmenu")[0].style.paddingRight = "0px";
  document.getElementsByClassName("notselectedmenu")[0].style.paddingRight = "0px";
  document.getElementsByClassName("notselectedmenu")[1].style.paddingRight = "0px";
  document.getElementsByClassName("notselectedmenu")[2].style.paddingRight = "0px";
  document.getElementsByClassName("notselectedmenu")[3].style.paddingRight = "0px";
} else {
  localStorage.setItem('bgcolor', 1);
  /*Ajout des textes*/
  setTimeout(function(){document.getElementById("text_menu_left_1").style.display = "block";},300);
  setTimeout(function(){document.getElementById("text_menu_left_2").style.display = "block";},300);
  setTimeout(function(){document.getElementById("text_menu_left_3").style.display = "block";},300);
  setTimeout(function(){document.getElementById("text_menu_left_4").style.display = "block";},300);
  setTimeout(function(){document.getElementById("text_menu_left_5").style.display = "block";},300);
  setTimeout(function(){document.getElementById("text_menu_left_1").style.opacity = "1";},310);
  setTimeout(function(){document.getElementById("text_menu_left_2").style.opacity = "1";},310);
  setTimeout(function(){document.getElementById("text_menu_left_3").style.opacity = "1";},310);
  setTimeout(function(){document.getElementById("text_menu_left_4").style.opacity = "1";},310);
  setTimeout(function(){document.getElementById("text_menu_left_5").style.opacity = "1";},310);
  setTimeout(function(){document.getElementById("new_task_text").style.display = "block";},300);
  setTimeout(function(){document.getElementById("new_task_text").style.opacity = "1";},310);
  /*setTimeout(function(){document.getElementById("new_task_text").style.visibility = "visible";},500);*/
  /*gestion des placements*/
  setTimeout(function(){document.getElementById("new_task_div").style.paddingBottom = "2px";},300);
  document.getElementById("new_task_div").style.marginLeft = "23px";
  document.getElementById("new_task_div").style.width = "210px";
  document.getElementById("new_task_img").style.marginLeft = "8px";
  document.getElementsByClassName("img_menu_gauche_js")[0].style.marginLeft = "0px";
  document.getElementsByClassName("img_menu_gauche_js")[1].style.marginLeft = "0px";
  document.getElementsByClassName("img_menu_gauche_js")[2].style.marginLeft = "0px";
  document.getElementsByClassName("img_menu_gauche_js")[3].style.marginLeft = "0px";
  document.getElementsByClassName("img_menu_gauche_js")[4].style.marginLeft = "0px";
  document.getElementsByClassName("ligne_et_taches ")[0].style.marginLeft = "260px";
  document.getElementsByClassName("ligne_et_taches ")[0].style.width = "calc(100% - 260px)";
  document.getElementById("menu_gauche").style.width="260px";
  /*document.getElementById("myBtn").style.width="calc(100vw - 259px)";*/
  document.getElementsByClassName("selectedmenu")[0].style.paddingRight = "90px";
  document.getElementsByClassName("notselectedmenu")[0].style.paddingRight = "90px";
  document.getElementsByClassName("notselectedmenu")[1].style.paddingRight = "90px";
  document.getElementsByClassName("notselectedmenu")[2].style.paddingRight = "90px";
  document.getElementsByClassName("notselectedmenu")[3].style.paddingRight = "90px";
  document.getElementsByClassName("ligne_haut_tache")[0].style.width="auto";
}





