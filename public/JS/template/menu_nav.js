// Menu element
let menu = {
    open: false,
    main_div: document.getElementById("menu_gauche"),
    text: [
        document.getElementById("text_menu_left_1"),
        document.getElementById("text_menu_left_2"),
        document.getElementById("text_menu_left_3"),
        document.getElementById("text_menu_left_4"),
        document.getElementById("text_menu_left_5")
    ],
    img: document.getElementsByClassName("img_menu_gauche_js"), // Array
    selected: document.getElementsByClassName("selectedmenu")[0],
    not_selected: document.getElementsByClassName("notselectedmenu"), // Array
    burger: document.getElementById("menu_checkbox")
};

// Settings element
const settings = {
    id: 'settings',
    modal: document.getElementById("bcc_settings"),
    show_btn: document.getElementById("gear_logo_img"),
    close_btn: document.getElementById("close_settings"),
    dark_mode_btn: document.getElementById("dark_mode"),
    night_shift_btn: document.getElementById("night_shift"),
    bug_input: document.getElementById("textarea_bug")
};

// Nav buttons
const nav = {
    account_logo: document.getElementById("account_logo_img")
}

// Help elements
const help = {
    modal: document.getElementById("help_modal"),
    show_btn: document.getElementById("help_logo_img"),
};
//SEARCH

let search = {
  not_find:"not_find",
  no_text:"no_text"
}

// Account elements
let account = {
    id: 'account',
    modal: document.getElementById("account_white_bc"),
    show_btn: document.getElementById("account_logo_img"),
    close: document.getElementById("close_account_modal"),
    option: document.getElementById("button_option"),
    back: document.getElementById("account_background"),
    redirectinfos: document.getElementById("button_my_account"),
    open_confirm:document.getElementById("confirm_open"),
    delete:"delete",
};
let accountinfos = {
  id: "my_informations",
  no_delete:document.getElementById("no_delete"),

}
let textarea = {
  pseudo:document.getElementById("textarea_pseudo"),
  pseudo_validate:document.getElementById("validate_textarea_pseudo"),
  mail:document.getElementById("textarea_mail"),
  mail_validate:document.getElementById("validate_textarea_mail"),
  pass:document.getElementById("textarea_pass"),
  pass_validate:document.getElementById("validate_textarea_pass"),

}
let change = {
  pseudo:document.getElementById("modify_textarea_pseudo"),
  mail:document.getElementById("modify_textarea_mail"),
  pass:document.getElementById("modify_textarea_pass"),
  button : document.getElementById("cancel_submit_changes"),
  img:document.getElementById("img_account_changeimg"),
  imgtext:document.getElementById("img_text"),
  form : document.getElementById("form_add_img"),
}

// Project elements
const project = {
    id: 'project',
    swap: {
        master: document.getElementById("projet_princ"),
        list: document.getElementById("ul_swap"),
        li: document.getElementsByClassName("li_swap"),
        arrow: document.getElementById("arrow"),
    },
    icon: document.getElementById("switch_logo_img"),
    actual: document.getElementById("project_actual"),
    name_input: document.getElementById('new_project_name'),
    desc_input: document.getElementById('new_project_desc'),
    git_username_input: document.getElementById('new_project_git_name'),
    git_project_input: document.getElementById('new_project_git_repo'),
    name_edit: document.getElementById('edit_project_name'),
    desc_edit: document.getElementById('edit_project_desc'),
    git_username_edit: document.getElementById('edit_project_git_name'),
    git_project_edit: document.getElementById('edit_project_git_repo'),
    idcreate:"create",
    create_button:document.getElementById("create_project_opener"),
    idedit:"edit_project",
    edit_button:document.getElementById("edit_project_opener"),


}


project.create_button.onclick=()=>{
  setTimeout(() => modals.show(project.idcreate, ()=>{
    project.name_input.value = '';
    project.desc_input.value = '';
    project.git_username_input.value = '';
    project.git_project_input.value = '';

  }), 500)
}
project.edit_button.onclick=()=>{
  var tempname = document.getElementById('edit_project_name').value
  var tempdesc= document.getElementById('edit_project_desc').value
  var tempgit_username= document.getElementById('edit_project_git_name').value
  var tempgit_project= document.getElementById('edit_project_git_repo').value
  setTimeout(() => modals.show(project.idedit,()=>{
    project.name_edit.value=tempname
    project.desc_edit.value=tempdesc
    project.git_username_edit.value=tempgit_username
    project.git_project_edit.value=tempgit_project

  }), 500)
}

document.getElementById("input_img").onchange = function() {
    document.getElementById("form_add_img").submit();
};

// Search input
const input_search = document.getElementById("findField")
const body = document.getElementsByTagName("body")[0];

/*
=========================
======= MAIN CODE =======
=========================
*/

/**
 * Executed when the JS is loaded
 */
function wOnload(){
    // Manage Menu
    setTimeout(() => {
        document.getElementsByTagName("BODY")[0].style.opacity="1";
    },50)
    if (getCookie('menu') === 'open') {
        for (let i = 0; i < menu.text.length; i++) {
                menu.text[i].style.transition = "all 0s";
                //hide(menu.text[i]);
        }
        for (let i = 0; i < menu.img.length; i++) menu.img[i].style.transition = "all 0s";
        for (let i = 0; i < menu.not_selected.length; i++) menu.not_selected[i].style.transition = "all 0s";
        menu.main_div.style.transition = "all 0s";
        menu.selected.style.transition = "all 0s";
        openMenu();

        setTimeout(() => {
            for (let i = 0; i < menu.text.length; i++) {
                menu.text[i].style.transition = "all 0.2s";
                //hide(menu.text[i]);
            }
            for (let i = 0; i < menu.img.length; i++) menu.img[i].style.transition = "all 0.2s";
            for (let i = 0; i < menu.not_selected.length; i++) menu.not_selected[i].style.transition = "all 0.2s";
            menu.main_div.style.transition = "all 0.2s";
            menu.selected.style.transition = "all 0.2s";
            closeMenu()
        },500)
    }

    if (getCookie('display')==="2") {
      display.first.style.display="none"
      display.second.style.display="block"
      display.open.style.display="none";
      display.open.style.opacity="0"
      display.global.style.borderRadius="50%";
      display.category_2.src="public/img/category_1.png"
      display.global.style.height="39px";
      display.category_1.src="public/img/category_2.png"
    } else {
      display.first.style.display="block"
      display.second.style.display="none"
      display.open.style.display="none";
      display.open.style.opacity="0";
      display.global.style.borderRadius="50%";
      display.global.style.height="39px";
      display.category_2.src="public/img/category_2.png"
      display.category_1.src="public/img/category_1.png"
    }

    // Turn ON/OFF dark mode
    if (getCookie('dark-mode') === 'on') {
        turnOnDarkMode()
        settings.dark_mode_btn.checked = true
    } else {
        turnOffDarkMode()
        settings.dark_mode_btn.checked = false
    }

    // Turn ON/OFF night shift
    if (getCookie('night-shift') === 'on') {
        turnOnNightShift()
        settings.night_shift_btn.checked = true
    } else {
        turnOffNightShift()
        settings.night_shift_btn.checked = false
    }

    // Print modal div
    document.querySelector('#modals').style.display = 'block'
}

window.onclick = (event) => {
    // Close help modal
    if (help.modal.style.display === "block" && event.target !== help.show_btn) {
        help.show_btn.classList.remove("help_logo_onclick");
        help.show_btn.style.filter = "invert(25%)";
        hide(help.modal);
    }

    // Close project list
    if (
        event.target !== project.swap.master &&
        event.target !== project.swap.list &&
        project.swap.list.style.display == "block"
    ) {
        project.swap.list.style.display = "none";
        project.swap.master.style.border = "rgb(190, 190, 190) 2px solid";
        project.swap.arrow.innerHTML = "&#x25BC;";
    }
};

/*
 * SETTINGS
 */
// Dark mode
/*
document.getElementById("close_settings").onclick =()=>{
  document.getElementById("textarea_bug").innerHTML = "";
}*/

settings.dark_mode_btn.onchange = () => {
    if (settings.dark_mode_btn.checked) turnOnDarkMode()
    else turnOffDarkMode()
};
divelem=document.getElementsByTagName("DIV")
function turnOnDarkMode() {
    body.style.backgroundColor="#0d0d0d";
    document.getElementById("menu_label").style.backgroundColor="#0d0d0d";
    document.getElementById("menu_button").style.backgroundColor="#0d0d0d";
    document.querySelectorAll('*').forEach(function(node) {
      node.style.color="white"
    });
    document.querySelectorAll('.menu_haut_table_cels_p').forEach(function(node) {
      node.style.color="#b41e10"
    });
    document.querySelectorAll('.title_task_modal').forEach(function(node) {
      node.style.color="#b41e10"
    });
    document.querySelectorAll('.line_popup').forEach(function(node) {
      node.style.backgroundColor="#b41e10"
    });
    document.querySelectorAll('.onhover_top_animation').forEach(function(node) {
      node.style.filter="invert(50%) brightness(2000%)"
    });
    document.querySelectorAll('.selectedmenu').forEach(function(node) {
      node.style.backgroundColor="#fce8e6"
    });
    document.querySelectorAll('.colorblack').forEach(function(node) {
      node.style.color="black"
    });
    document.querySelectorAll('.colorred').forEach(function(node) {
      node.style.color="#b41e10"
    });
    document.querySelectorAll('.grayback').forEach(function(node) {
      node.style.backgroundColor="#262626"
    });
    document.querySelectorAll('.img_menu_gauche_js').forEach(function(node) {
      node.style.filter="invert(50%) brightness(75%)"
    });
    document.querySelectorAll('.brightnessmax').forEach(function(node) {
      node.style.filter="invert(50%) brightness(2000%)"
    });
    document.querySelectorAll('.invertcent').forEach(function(node) {
      node.style.filter="invert(100%) brightness(2000%)"
    });
    document.querySelectorAll('.modal-wrapper').forEach(function(node) {
      node.style.backgroundColor="#262626"
    });
    document.querySelectorAll('.buttons_delete_support').forEach(function(node) {
      node.style.backgroundColor="transparent"
    });
    document.getElementById("findField").style.backgroundColor="#262626";
    document.getElementById("textarea_pseudo").style.backgroundColor="#262626";
    document.getElementById("textarea_mail").style.backgroundColor="transparent";
    document.getElementById("cancel_submit_changes").style.backgroundColor="transparent";
    document.getElementById("findField").style.color="white";
    settings.night_shift_btn.checked = false;

    // Set dark-mode cookie
    setCookie('dark-mode', 'on')
}
function turnOffDarkMode() {
    body.style.backgroundColor="white";
    document.getElementById("menu_label").style.backgroundColor="white";
    document.getElementById("menu_button").style.backgroundColor="white";
    document.querySelectorAll('*').forEach(function(node) {
      node.style.color="black"
    });
    document.querySelectorAll('.colorwhite').forEach(function(node) {
      node.style.color="white"
    });
    document.querySelectorAll('.invertcent').forEach(function(node) {
      node.style.filter="invert(0%) brightness(2000%)"
    });
    document.querySelectorAll('.menu_haut_table_cels_p').forEach(function(node) {
      node.style.color="#b41e10"
    });
    document.querySelectorAll('.title_task_modal').forEach(function(node) {
      node.style.color="#b41e10"
    });
    document.querySelectorAll('.line_popup').forEach(function(node) {
      node.style.backgroundColor="#b41e10"
    });
    document.querySelectorAll('.onhover_top_animation').forEach(function(node) {
      node.style.filter="invert(50%) brightness(0%)"
    });
    document.querySelectorAll('.selectedmenu').forEach(function(node) {
      node.style.backgroundColor="#fce8e6"
    });

    document.querySelectorAll('.notselectedmenu').forEach(function(node) {
      node.style.color="black"
    });
    document.querySelectorAll('.colorblack').forEach(function(node) {
      node.style.color="black"
    });
    document.querySelectorAll('.colorred').forEach(function(node) {
      node.style.color="#b41e10"
    });
    document.querySelectorAll('.grayback').forEach(function(node) {
      node.style.backgroundColor="white"
    });
    document.querySelectorAll('.img_menu_gauche_js').forEach(function(node) {
      node.style.filter="invert(50%) brightness(0%)"
    });
    document.querySelectorAll('.brightnessmax').forEach(function(node) {
      node.style.filter="invert(50%) brightness(0%)"
    });
    document.querySelectorAll('.modal-wrapper').forEach(function(node) {
      node.style.backgroundColor="white"
    });
    document.querySelectorAll('.buttons_delete_support').forEach(function(node) {
      node.style.backgroundColor="transparent"
    });

    document.getElementById("findField").style.backgroundColor="#f1f3f4";
    document.getElementById("textarea_pseudo").style.backgroundColor="white";
    document.getElementById("textarea_mail").style.backgroundColor="white";
    document.getElementById("cancel_submit_changes").style.backgroundColor="transparent";
    // Set dark-mode cookie
    setCookie('dark-mode', 'off')
}

// Night shift
settings.night_shift_btn.onchange = () => {
    if (settings.night_shift_btn.checked) turnOnNightShift()
    else turnOffNightShift()
};
//var divelem=document.getElementsByTagName("DIV");

function turnOnNightShift() {
    /*for (var i = 0; i < divelem.length; i++) {

      if (divelem[i].style.backgroundColor == "white") {
        divelem[i].style.filter = "sepia(70%)";
      } else {
        divelem[i].style.filter = "sepia(0%)";
      }
    }*/
    settings.dark_mode_btn.checked = false;
    body.style.filter = "sepia(15%)";
    nav.account_logo.style.filter = "invert(0%) hue-rotate(0deg)";
    //settings.dark_mode_btn.checked = false;

    // Set dark-mode cookie
    setCookie('night-shift', 'on')
}
function turnOffNightShift(){
    body.style.filter = "sepia(0%)";
    nav.account_logo.style.filter = "invert(0%) hue-rotate(0deg)";

    // Set dark-mode cookie
    setCookie('night-shift', 'off')
}

/*
 * LEFT MENU
 */
menu.burger.onclick = () => {
    if (menu.open) {
      closeMenu()

    }
    else {
      openMenu()
    }
    menu.open = !menu.open
};
function closeMenu(){
    for (let i = 0; i < menu.text.length; i++) {
        menu.text[i].style.opacity = "0";
        //hide(menu.text[i]);
    }
    for (let i = 0; i < menu.img.length; i++) menu.img[i].style.marginLeft = "-23px";
    for (let i = 0; i < menu.not_selected.length; i++) menu.not_selected[i].style.paddingRight = "0px";
    menu.main_div.style.width = "100px";
    menu.selected.style.paddingRight = "0px";
    setCookie('menu', 'closed')
}
function openMenu(){
    //setTimeout(() => {
        //for (let i = 0; i < menu.text.length; i++) show(menu.text[i]);
    //}, 0);
    setTimeout(() => {
        for (let i = 0; i < menu.text.length; i++) menu.text[i].style.opacity = "1";
    }, 200);
    menu.main_div.style.width = "260px";
    menu.selected.style.paddingRight = "90px";
    for (let i = 0; i < menu.img.length; i++) menu.img[i].style.marginLeft = "0px";

    for (let i = 0; i < menu.not_selected.length; i++) menu.not_selected[i].style.paddingRight = "90px";
    setCookie('menu', 'open')

}
//for (let i = 0; i < menu.img.length; i++){
  //menu.img[i].onclick=()=>{

  //}
//}
redirect_index = () =>{
  //document.getElementsByTagName("*").onmouseover.style.cursor = "wait";
  //openMenu();
  setTimeout(() => {
      window.location.href = 'index.php'
  }, 300);

}
redirect_team = () =>{
  //document.getElementsByTagName("*").onmouseover.style.cursor = "wait";
  //openMenu();
  setTimeout(() => {
      window.location.href = 'index.php?action=team'
  }, 300);
}

/*
 * SWAP PROJECT MODAL
 */
project.swap.master.onclick = () => {
    if (project.swap.list.style.display == "block") {
        project.swap.list.style.display = "none";
        //swap.master.style.border = "white 2px solid";
        project.swap.arrow.innerHTML = "&#x25BC;";
    } else {
        project.swap.list.style.display = "block";
        project.swap.master.style.borderLeft = "rgb(190, 190, 190) 2px solid";
        project.swap.master.style.borderRight = "rgb(190, 190, 190) 2px solid";
        project.swap.master.style.borderTop = "rgb(190, 190, 190) 2px solid";
        project.swap.arrow.innerHTML = "&#9650;";
    }
};

project.swap.arrow.onclick = () => {
    if (project.swap.list.style.display == "block") {
        project.swap.list.style.display = "none";
        //swap.master.style.border = "white 2px solid";
        project.swap.arrow.innerHTML = "&#x25BC;";
    } else {
        project.swap.list.style.display = "block";
        project.swap.master.style.borderLeft = "rgb(190, 190, 190) 2px solid";
        project.swap.master.style.borderRight = "rgb(190, 190, 190) 2px solid";
        project.swap.master.style.borderTop = "rgb(190, 190, 190) 2px solid";
        project.swap.arrow.innerHTML = "&#9650;";
    }
};
for (let i = 0; i < project.swap.li.length; i++) {
    project.swap.li[i].onclick = (event) => {
        const swap_l_li = event.target;
        project.swap.master.innerHTML = swap_l_li.innerHTML;
        project.swap.list.style.display = "none";
        project.swap.arrow.innerHTML = "&#x25BC;";
        for (let i = 0; i < project.swap.li.length; i++) {
            if (project.swap.master.innerHTML == project.swap.li[i].innerHTML) {
                project.swap.li[i].style.backgroundColor = "rgb(190, 190, 190)";
                project.swap.master.style.border = "rgb(190, 190, 190) 2px solid";
            } else {
                project.swap.li[i].style.backgroundColor = "white";
            }
        }
    };
}

document.getElementById("close_swap").onclick = () => {
    project.name_input.value = "";
    project.desc_input.value = "";
    project.git_username_input.value = "";
    project.git_project_input.value = "";
};
project.icon.onclick = () => modals.show(project.id)
project.actual.onclick = () => modals.show(project.id)

/*
 * ACCOUNT MODAL
 */
account.show_btn.onclick = () => {
    modals.show(account.id)
};
account.option.onclick = () => {
    setTimeout(() => modals.show(settings.id), 500)
};
account.redirectinfos.onclick = () => {
    setTimeout(() => modals.show(accountinfos.id, ()=>{
      textarea.pseudo_validate.style.marginRight = "50px";
      textarea.pseudo_validate.style.opacity = "0";
      change.button.innerHTML = "Annuler";
      textarea.pseudo.disabled=true;

    }), 500)
};


//CHANGE INFORMATIONS Account
function hover_change(){
  change.img.style.filter = "brightness(40%)";
  change.imgtext.style.opacity = "1";
}
function leave_change(){
  change.img.style.filter = "brightness(100%)";
  change.imgtext.style.opacity = "0";
}

change.pseudo.onclick = () => {
  textarea.pseudo.disabled=false;
  textarea.pseudo_validate.style.marginRight = "100px";
  textarea.pseudo_validate.style.opacity = "1";
  textarea.pseudo.focus();

  //textarea.mail_validate.click();
  //textarea.pass_validate.click();

}
var newplaceholder_pseudo = textarea.pseudo.value;
textarea.pseudo_validate.onclick = () => {
  if (newplaceholder_pseudo != textarea.pseudo.value) {
    //textarea.pseudo.value = newplaceholder_pseudo;
    change.button.innerHTML = "Effectuer les changements";
  }
  textarea.pseudo_validate.style.marginRight = "50px";
  textarea.pseudo_validate.style.opacity = "0";
  textarea.pseudo.disabled=true;
}

// change.mail.onclick = () => {
//   textarea.mail.disabled=false;
//   textarea.mail_validate.style.marginRight = "100px";
//   textarea.mail_validate.style.opacity = "1";
//   textarea.mail.focus();
//   textarea.pseudo_validate.click();
//   textarea.pass_validate.click();
// }
//
// textarea.mail_validate.onclick = () => {
//   const newplaceholder_mail = textarea.mail.value;
//   if (newplaceholder_mail != "") {
//     textarea.mail.value ="";
//     textarea.mail.value = newplaceholder_mail;
//     change.button.innerHTML = "Effectuer les changements";
//     change.button.type = "submit"
//   }
//   textarea.mail_validate.style.marginRight = "50px";
//   textarea.mail_validate.style.opacity = "0";
//   textarea.mail.disabled=true;
// }
//
// change.pass.onclick = () => {
//   textarea.pass.disabled=false;
//   textarea.pass_validate.style.marginRight = "100px";
//   textarea.pass_validate.style.opacity = "1";
//   textarea.pass.focus();
//   textarea.mail_validate.click();
//   textarea.pseudo_validate.click();
// }
//
// textarea.pass_validate.onclick = () => {
//   const newplaceholder_pass = textarea.pass.value;
//   if (newplaceholder_pass != "") {
//     textarea.pass.value ="";
//     change.button.innerHTML = "Effectuer les changements";
//     change.button.type = "submit";
//     textarea.pass.value = newplaceholder_pass;
//   }
//   textarea.pass_validate.style.marginRight = "50px";
//   textarea.pass_validate.style.opacity = "0";
//   textarea.pass.disabled=true;
// }

change.button.onclick = () => {
  textarea.pseudo_validate.click();
  setTimeout(() => change.button.innerHTML = "Annuler", 500)
  setTimeout(() => change.button.type = "button", 500)

}

//DELETE Account

account.open_confirm.onclick = () =>{
  setTimeout(() => modals.show(account.delete), 500)
}
accountinfos.no_delete.onclick = () =>{
  setTimeout(() => modals.show(accountinfos.id), 500)
}

/*
 * SEARCH BAR
 */
input_search.addEventListener("keyup", (event) => {
    if (event.keyCode === 13) {
        event.preventDefault();
        FindNext();
    }
})
function FindNext() {
    //If void
    const str = document.getElementById("findField").value;
    if (str == "") {
        modals.show(search.no_text);
        return;
    }

    let supported = false;
    let found = false;
    if (window.find) {
        supported = true;
        // if some content is selected, the start position of the search
        // will be the end position of the selection
        //found = window.find(str);
    } else {
        if (document.selection && document.selection.createRange) {
            let textRange = document.selection.createRange();
            if (textRange.findText) {
                supported = true;
                // if some content is selected, the start position of the search
                // will be the position after the start position of the selection
                if (textRange.text.length > 0) {
                    textRange.collapse(true);
                    textRange.move("character", 1);
                }

                found = textRange.findText(str);
                if (found) textRange.select();
            }
        }
    }

    if (supported && !found) modals.show(search.not_find);
    //else alert("Your browser does not support this example!");
}

/*
 * SETTINGS MODAL
 */
settings.show_btn.onclick = () => {
    modals.show(settings.id, ()=>{
      settings.bug_input.value = "";
    })
};


/*
 * HELP MODAL
 */
help.show_btn.onclick = () => {
    help.show_btn.classList.add("help_logo_onclick");
    help.show_btn.style.filter =
        "invert(100%) hue-rotate(160deg) grayscale(100%)";
    show(help.modal);
};

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
function contain(array, value){
    let r = false;
    for (let i = 0; i < array.length; i++) {
        if (array[i] === value) r = true;
    }
    return r;
}

/**
 * Show a specific element
 * @param  {DOM element} element Element to show
 */
function show(element){
    element.style.display = "block";
}

/**
 * Hide a specific element
 * @param  {DOM element} element Element to hide
 */
function hide(element){
    element.style.display = "none";
}

/*
 * COOKIES FUNCTIONS
 */

/**
 * Get a specific cookie by its name
 * @param  {String} cname The cookie name
 * @return {String} The cookies value
 */
function getCookie(cname) {
    const name = cname + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

/**
 * Add / set a cookie
 * @param {String} cname The cookie name
 * @param {String} cvalue The cookie value
 */
function setCookie(cname, cvalue) {
    let d = new Date();
    d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
    const expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
