// Tasks elements
var tasks = document.getElementsByName("task");
var tasks_btn = {
  check_js: document.getElementsByClassName("check_js"),
  tick: document.getElementsByClassName("tick"),
  tick2: document.getElementsByClassName("tick2"),
};

// 'Add task' elements
var addtask = {
  modal: document.getElementById("add_task_modal_general"),
  show_btn: document.getElementById("new_task_div"),
  close_btn: document.getElementById("close_add"),
  cancel_btn: document.getElementById("addtask_cancel"),
  title_input: document.getElementById("textarea_title"),
  desc_input: document.getElementById("textarea_desc"),
};

// Settings elements
var settings = {
  modal: document.getElementById("bcc_settings"),
  show_btn: document.getElementById("gear_logo_img"),
  close_btn: document.getElementById("close_settings"),
  dark_mode_btn: document.getElementById("dark_mode"),
  night_shift_btn: document.getElementById("night_shift"),
  bug_input: document.getElementById("textarea_bug"),
};

// Help elements
var help = {
  modal: document.getElementById("help_modal"),
  show_btn: document.getElementById("help_logo_img"),
};

// Account elements
var account = {
  modal: document.getElementById("account_modal"),
  show_btn: document.getElementById("account_logo_img"),
};

// Menu element
var open = false;
var menu = {
  main_div: document.getElementById("menu_gauche"),
  text: [
    // Là je pense que tu peux dégager tous les id
    // et juste donner la class 'text_menu_left'
    // pour tous les textes du menu
    // (je pense que c'est plus simple et rapide)
    // Comme ça tu fais la même chose que pour
    // la variable 'menu.img'
    document.getElementById("text_menu_left_1"),
    document.getElementById("text_menu_left_2"),
    document.getElementById("text_menu_left_3"),
    document.getElementById("text_menu_left_4"),
    document.getElementById("text_menu_left_5"),
    document.getElementById("new_task_text"),
  ],
  img: document.getElementsByClassName("img_menu_gauche_js"), // Array
  selected: document.getElementsByClassName("selectedmenu")[0],
  not_selected: document.getElementsByClassName("notselectedmenu"), // Array
  selected_ligne: document.getElementsByClassName("ligne_et_taches")[0],
  selected_ligne_header: document.getElementById("ligne_haut_tache_id"),
  add_task_logo: document.getElementById("new_task_img"),
  add_task_div: document.getElementById("new_task_div"),
};

// Selectall
var select_all = {
  select_all: document.getElementById("select_all"),
  checkbox: document.getElementsByClassName("to_check"),
  trash: document.getElementsByClassName("trash")[0],
};

//SWAP PROJECT MODAL
var swap = {
  master: document.getElementById("projet_princ"),
  list: document.getElementById("ul_swap"),
  li: document.getElementsByClassName("li_swap"),
  arrow: document.getElementById("arrow"),
};
var modal_swap = document.getElementById("project_modal_container");
var modal_swap_icon = document.getElementById("switch_logo_img");

var close_btn = document.getElementsByClassName("close");
var body = document.getElementsByTagName("body")[0];
var account_logo = document.getElementById("account_logo_img");

var burger = document.getElementById("menu_checkbox");
var modaladd = document.getElementById("add_task_modal");

/*
=========================
======= MAIN CODE =======
=========================
*/

/*
 * MODAL TASK
 */
for (var i = 0; i < tasks.length; i++) {
  tasks[i].onclick = (event) => {
    // Get task id
    var id = null;
    var path = event.path;
    for (var i = 0; i < path.length; i++) {
      var current_id = path[i].id;
      if (current_id !== undefined) {
        if (current_id.indexOf("task") !== -1) id = current_id;
      }
    }

    // Get modal
    var modal = document.getElementById(id + "_modal");

    if (
      !contain(tasks_btn.check_js, event.target) &&
      !contain(tasks_btn.tick, event.target) &&
      !contain(tasks_btn.tick2, event.target)
    ) {
      // Everythings is ok, let's go show the popup
      show(modal);
    }
  };
}

/*
 * ADD TASK MODAL
 */
addtask.show_btn.onclick = () => {
  show(addtask.modal);
};
addtask.close_btn.onclick = () => {
  erase(addtask.modal);
};
addtask.cancel_btn.onclick = (event) => {
  addtask.title_input.value = "";
  addtask.desc_input.value = "";
  erase(addtask.modal);
};

/*
 * SETTINGS MODAL
 */
settings.show_btn.onclick = () => {
  show(settings.modal);
};
settings.close_btn.onclick = () => {
  settings.bug_input.value = "";
  erase(settings.modal);
};

// Dark mode
// Il faut gérer le fait que la config 'dark-mode'
// soit concervé sur les autres pages
// Du coup faut utiliser soit les cookies
// soit le localStorage
settings.dark_mode_btn.onchange = () => {
  if (settings.dark_mode_btn.checked == true) {
    body.style.filter = "invert(100%) hue-rotate(200deg)";
    account_logo.style.filter = "invert(100%) hue-rotate(-200deg)";
    settings.night_shift_btn.checked = false;
  } else {
    body.style.filter = "invert(0%) hue-rotate(0deg)";
    account_logo.style.filter = "invert(0%) hue-rotate(0deg)";
  }
};

// Night shift
settings.night_shift_btn.onchange = () => {
  if (settings.night_shift_btn.checked == true) {
    body.style.filter = "sepia(70%)";
    account_logo.style.filter = "invert(0%) hue-rotate(0deg)";
    settings.dark_mode_btn.checked = false;
  } else {
    body.style.filter = "sepia(0%)";
    account_logo.style.filter = "invert(0%) hue-rotate(0deg)";
  }
};

/*
 * HELP MODAL
 */
help.show_btn.onclick = () => {
  // Là je modifie le CSS dynamiquement avec classList
  // en gros tu crée une class CSS qui contient
  // les nouvelles valeurs de l'élement
  // (je vais les écrire dans un fichier à part -> transition.css)
  // (et on oublie pas de le lier au code HTML évidemment)
  // on va appeler la class 'help_logo_onclick'
  // histoire de faire simple ;)
  // Tu peux dégager ces commentaires une fois lus stv
  help.show_btn.classList.add("help_logo_onclick");

  // Comme t'as designé le logo avec un id dans ton CSS
  // la fonction ne marche pas entierement.
  // Du coup je dois faire ça :
  help.show_btn.style.filter =
    "invert(100%) hue-rotate(160deg) grayscale(100%)";
  // Mais le plus simple aurait été de designé le logo
  // avec une class comme ça t'es pas emmerdé

  show(help.modal);
};

/*
 * ACCOUNT MODAL
 */
account.show_btn.onclick = () => {
  show(account.modal);
};

/*
 * LEFT MENU
 */
// J'ai créé des foncions pour ouvrir/fermer le menu
// du coup c'est plus simple pour gérer l'état du menu
// et donc aussi pour gérer son état avec le localStorage
// Je te laisse réfléchir pour cette partie !
// (Bon en fait j'ai surtout la flemme de le faire)

// Close menu when JS is loaded
window.onload = () => {
  closeMenu();
};

burger.onclick = () => {
  if (open) {
    window.open = false;
    closeMenu();
  } else {
    window.open = true;
    openMenu();
  }
};

// Close menu
var closeMenu = () => {
  for (var i = 0; i < menu.text.length; i++) {
    menu.text[i].style.opacity = "0";
    erase(menu.text[i]);
  }

  menu.add_task_div.style.paddingBottom = "7px";
  menu.add_task_div.style.marginLeft = "23px";
  menu.add_task_div.style.width = "50px";

  menu.add_task_logo.style.marginLeft = "8px";

  for (var i = 0; i < menu.img.length; i++) {
    menu.img[i].style.marginLeft = "-23px";
  }

  menu.selected_ligne.style.marginLeft = "100px";
  menu.selected_ligne.style.width = "calc(100% - 100px)";

  menu.main_div.style.width = "100px";

  menu.selected.style.paddingRight = "0px";

  for (var i = 0; i < menu.not_selected.length; i++) {
    menu.not_selected[i].style.paddingRight = "0px";
  }
};

// Open menu
var openMenu = () => {
  setTimeout(() => {
    for (var i = 0; i < menu.text.length; i++) {
      show(menu.text[i]);
    }
    menu.add_task_div.style.paddingBottom = "2px";
  }, 300);

  setTimeout(() => {
    for (var i = 0; i < menu.text.length; i++) {
      menu.text[i].style.opacity = "1";
    }
  }, 310);

  menu.add_task_div.style.marginLeft = "23px";
  menu.add_task_div.style.width = "210px";

  menu.add_task_logo.style.marginLeft = "8px";

  for (var i = 0; i < menu.img.length; i++) {
    menu.img[i].style.marginLeft = "0px";
  }

  menu.selected_ligne.style.marginLeft = "260px";
  menu.selected_ligne.style.width = "calc(100% - 260px)";

  menu.main_div.style.width = "260px";

  menu.selected.style.paddingRight = "90px";

  for (var i = 0; i < menu.not_selected.length; i++) {
    menu.not_selected[i].style.paddingRight = "90px";
  }

  menu.selected_ligne_header.style.width = "auto";
};

/*
 * CLOSE MODALS
 */
for (var i = 0; i < close_btn.length; i++) {
  close_btn[i].onclick = (event) => {
    var close = event.target;
    var modal = close.parentElement.parentElement;
    modal.style.display = "none";
  };
}
// To improve...
window.addEventListener("click", (event) => {
  if (help.modal.style.display === "block" && event.target !== help.show_btn) {
    // Close help modal
    help.show_btn.classList.remove("help_logo_onclick");

    // Même problème que la fonction 'help.show_btn.onclick'
    help.show_btn.style.filter = "invert(25%)";

    erase(help.modal);
  } else if (
    account.modal.style.display === "block" &&
    !contain(event.path, account.modal) &&
    event.target !== account.show_btn
  ) {
    // Close account modal
    erase(account.modal);
  }
});

/*
 * Selectall task
 */
select_all.select_all.onclick = () => {
  for (var i = 0; i < select_all.checkbox.length; i++) {
    select_all.checkbox[i].checked = select_all.select_all.checked;
  }
  if (select_all.select_all.checked) {
    select_all.trash.style.display = "inline-block";
  } else {
    erase(select_all.trash);
  }
};
for (var i = 0; i < select_all.checkbox.length; i++) {
  select_all.checkbox[i].onclick = (event) => {
    var c_checkbox = event.target;
    // console.log(c_checkbox);
    if (c_checkbox.checked) {
      // Show trash or do nothing
      select_all.trash.style.display = "inline-block";
    } else {
      hide = true;
      for (var i = 0; i < select_all.checkbox.length; i++) {
        if (select_all.checkbox[i].checked) hide = false;
      }
      if (hide) erase(select_all.trash);
    }
  };
}

//SWAP PROJECT MODAL

window.onclick = (event) => {
  var w_window = event.target;
  if (
    w_window !== swap.master &&
    w_window !== swap.list &&
    swap.list.style.display == "block"
  ) {
    swap.list.style.display = "none";
    swap.master.style.border = "rgb(190, 190, 190) 2px solid";
    swap.arrow.innerHTML = "&#x25BC;";
  }
};

swap.master.onclick = () => {
  if (swap.list.style.display == "block") {
    swap.list.style.display = "none";
    //swap.master.style.border = "white 2px solid";
    swap.arrow.innerHTML = "&#x25BC;";
  } else {
    swap.list.style.display = "block";
    swap.master.style.borderLeft = "rgb(190, 190, 190) 2px solid";
    swap.master.style.borderRight = "rgb(190, 190, 190) 2px solid";
    swap.master.style.borderTop = "rgb(190, 190, 190) 2px solid";
    swap.arrow.innerHTML = "&#9650;";
  }
};

for (var i = 0; i < swap.li.length; i++) {
  swap.li[i].onclick = (event) => {
    var swap_l_li = event.target;
    swap.master.innerHTML = swap_l_li.innerHTML;
    swap.list.style.display = "none";
    swap.arrow.innerHTML = "&#x25BC;";
    for (var i = 0; i < swap.li.length; i++) {
      if (swap.master.innerHTML == swap.li[i].innerHTML) {
        swap.li[i].style.backgroundColor = "rgb(190, 190, 190)";
        swap.master.style.border = "rgb(190, 190, 190) 2px solid";
      } else {
        swap.li[i].style.backgroundColor = "white";
      }
    }
  };
}

document.getElementById("close_swap").onclick = () => {
  erase(modal_swap);
};

modal_swap_icon.onclick = () => {
  show(modal_swap)
}

/*
=========================
======= FUNCTIONS =======
=========================
*/

/**
 * Check if a value is contained in a specific array
 * @param  {Array} array Array to analyse
 * @param  {various} value Value to check
 * @return {Boolean}
 */
var contain = (array, value) => {
  var r = false;
  for (var i = 0; i < array.length; i++) {
    if (array[i] === value) r = true;
  }
  return r;
};

/**
 * Show a specific element
 * @param  {DOM element} element Element to show
 */
var show = (element) => {
  element.style.display = "block";
};

/**
 * Don't show a specific element anymore
 * @param  {DOM element} element Element to erase
 */
var erase = (element) => {
  element.style.display = "none";
};

// J'ai créé le système de CHECK-ALL dans le fichier 'demo.html' ;)
