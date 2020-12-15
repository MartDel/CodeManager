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

// Left menu

const menu = {
    btn: '#menu_checkbox',
    div: '#menu_gauche',
    texts: '.textgauche',
    images: '.img_menu_gauche_js',
    not_selected: '.notselectedmenu',
    selected: '.selectedmenu',
    ///////////////////:
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
    // selected: document.getElementsByClassName("selectedmenu")[0],
    // not_selected: document.getElementsByClassName("notselectedmenu"), // Array
    burger: document.getElementById("menu_checkbox")
}

$(menu.burger).click(function () {
    if (menu.open) closeMenu()
    else  openMenu()
    menu.open = !menu.open
})
function closeMenu(){
    $(menu.div).css('transition-delay', "0s, 0s").css('width', '100px')
    $(menu.texts).css('opacity', 0)
    $(menu.images).css('margin-left', "-23px")
    $(menu.not_selected).css('padding-right', "0px")
    $(menu.selected).css('padding-right', "0px")

    setTimeout(() => {
        const width = parseInt(window.innerWidth);
        if (width <= 500) $(menu.div).css('margin-left', '-100px')
        else $(menu.div).css('margin-left', '0')
    }, 400)

    setCookie('menu', 'closed')
}
function openMenu(){
    $(menu.div).css('margin-left', "0").css('transition-delay', '0s, 0s')
    const width = parseInt(window.innerWidth);
    if (width <= 500) {
        setTimeout(() => {
            $(menu.div).css('width', "260px")
            $(menu.selected).css('padding-right', "90px")
            $(menu.images).css('margin-left', "0px")
            $(menu.not_selected).css('padding-right', "90px")
        },400)
        setTimeout(() => {
            $(menu.texts).css('opacity', 1)
        }, 600);
    } else{
        $(menu.div).css('width', "260px")
        $(menu.selected).css('padding-right', "90px")
        $(menu.images).css('margin-left', "0px")
        $(menu.not_selected).css('padding-right', "90px")
        setTimeout(() => {
            $(menu.texts).css('opacity', 1)
        }, 200);
    }
    setCookie('menu', 'open')
}

// Search into the page

const input_search = document.getElementById("findField")
const body = document.getElementsByTagName("body")[0];

// Project

const project = {
    modal: '#project',
    btns: ['#switch_logo_img','#project_actual'],
    add: {
        modal: '#create',
        btn: '#create_project_opener',
        form: "form[name='create_project_form']"
    },
    edit: {
        modal: '#edit_project',
        btn: '#edit_project_opener',
        form: "form[name='edit_project_form']"
    }
}

// Open project modal
project.btns.forEach((item) => {
    $(item).click(function (){
        modals.show(project.modal.substring(1))
    })
})

// Open modal to create project
$(project.add.btn).click(function (){
    setTimeout(() => modals.show(project.add.modal.substring(1), ()=>{
        $(project.add.form).find('input[placeholder], textarea[placeholder]').val('')
    }), 500)
})

// Open modal to edit the current project
$(project.edit.btn).click(function (){
    if(permissions !== 2){
        const err = new Message('error', 'Action refusée...', "Vous n'avez pas l'autorisation nécessaire pour modifier le projet.")
        err.show()
        return
    }
    // Save old inputs values
    let values = []
    $(project.edit.form).find('input[placeholder], textarea[placeholder]').each(function (i) {
        values[i] = $(this).val()
    })
    setTimeout(() => modals.show(project.edit.modal.substring(1), () => {
        $(project.edit.form).find('input[placeholder], textarea[placeholder]').each(function (i) {
            $(this).val(values[i])
        })
    }), 500)
})

// Settings

const settings = {
    modal: '#bcc_settings',
    btn: '#gear_logo_img',
    edit: {
        dark_mode: '#dark_mode',
        night_shift: '#night_shift',
        NS_changes: '#account_logo_img'
    },
    input: '#textarea_bug',
    ////////////////////////////////////
    id: 'settings',
    show_btn: document.getElementById("gear_logo_img"),
    close_btn: document.getElementById("close_settings"),
    dark_mode_btn: document.getElementById("dark_mode"),
    night_shift_btn: document.getElementById("night_shift"),
    bug_input: document.getElementById("textarea_bug")
}

// Show settings modal
$(settings.btn).click(function () {
    modals.show(settings.modal, () => {
        $(settings.input).val('')
    })
})

// Turn ON/OFF dark-mode
$(settings.edit.dark_mode).change(function (){
    if (this.checked) turnOnDarkMode()
    else turnOffDarkMode()
})
function turnOnDarkMode() {
    // Dark-mode for all elements
    $('*').each(function (){
        const $node = $(this)
        if ($node.css('color') === "black") $node.css('color', "white")
    })
    // Dark-mode for the body
    const $body = $('body').css('background-color', '#1C1C1C')
    if ($body.css('color') === 'black') $body.css('color', 'white')
    // Dark-mode for div
    $('div').each(function (){
        const $node = $(this)
        if($node.css('color') === 'black') $node.css('color', 'white')
        if ($node.css('background-color') === 'white') $node.css('background-color', '#1C1C1C')
    })
    // Dark-mode for images
    $('img').css('filter', "invert(50%)")
    // Dark-mode for the logo
    $('#logo').css('filter', "invert(0%)")
    // Dark-mode for done tasks
    $('.tasks_done').css('filter', "invert(0%) grayscale(100%)")
    // Dark-mode for categories
    $('#category_1').css('filter', "invert(100%)")
    $('#category_2').css('filter', "invert(100%)")
    // Dark-mode for ???
    $('.flex_title_task').css('background-color', "transparent")
    $('#firstdisplay li').css('color', "white")
    $('#findField').css('color', "black")
    $('.category_flex select option').css('color', "black").css('backgroundColor', "white")

    // Turn off night-shift
    $(settings.edit.night_shift).attr('checked', 'off')
    turnOffNightShift()

    // Set dark-mode cookie
    setCookie('dark-mode', 'on')
}
function turnOffDarkMode() {
    // Reset all elements
    $('*').each(function (){
        const $node = $(this)
        if ($node.css('color') === "white") $node.css('color', "black")
    })
    // Reset the body
    $('body').css('background-color', 'white').css('color', 'black')
    // Reset div
    $('div').each(function (){
        const $node = $(this)
        if($node.css('color') === 'white') $node.css('color', 'black')
        if ($node.css('background-color') === '#1C1C1C') $node.css('background-color', 'white')
    })
    // Reset images
    $('img').css('filter', "invert(0%) brightness(100%)")
    // Reset the logo
    $('#logo').css('filter', "invert(0%)")
    // Reset categories
    $('#category_1').css('filter', "invert(100%)")
    $('#category_2').css('filter', "invert(100%)")
    // Reset left menu
    $('.menu_gauche a').each(function (){
        const $node = $(this)
        if ($node.css('color') === "white") $node.css('color', "black")
    })
    // Dark-mode for ???
    $('.flex_title_task').css('background-color', "transparent")
    $('#firstdisplay li').css('color', "black")
    $('#findField').css('color', "black")
    $('.category_flex select option').css('color', "black").css('background-color', "white")
    $('#help_modal img').css('filter', "invert(25%) grayscale(100%) brightness(100%)")
    $('.img_menu_gauche_js').css('filter', "invert(0%) brightness(0%)")

    // Set dark-mode cookie
    setCookie('dark-mode', 'off')
}

// Night shift
settings.night_shift_btn.onchange = () => {
    if (settings.night_shift_btn.checked) turnOnNightShift()
    else turnOffNightShift()
}
function turnOnNightShift() {
    // Turn off dark-mode
    $(settings.edit.dark_mode).attr('checked', 'off')
    turnOffDarkMode();

    $('body').css('filter', "sepia(15%)")
    $(settings.edit.NS_chanches).css('filter', "invert(0%) hue-rotate(0deg)")

    // Set night-shift cookie
    setCookie('night-shift', 'on')
}
function turnOffNightShift(){
    $('body').css('filter', "sepia(0%)")
    $(settings.edit.NS_chanches).css('filter', "invert(0%) hue-rotate(0deg)")

    // Set night-shift cookie
    setCookie('night-shift', 'off')
}

// Account

const account = {
    edit: {
        form_img: '#form_add_img',
        img: '#input_img'
    },
    //////////////////////
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
const accountinfos = {
  id: "my_informations",
  no_delete:document.getElementById("no_delete"),
}

$(account.edit.img).change(function (){
    $(account.edit.form_img).submit()
})

/*

 */

/**
 * Executed when the JS is loaded
 */
function wOnload(){
    // Manage Menu
    setTimeout(() => {
        $('body').css('opacity', "1")
    },450)
    if (getCookie('menu') === 'open') {
        $(menu.texts).css('transition', 'all 0s')
        $(menu.images).css('transition', "all 0s")
        $(menu.not_selected).css('transition', "all 0s")
        $(menu.div).css('transition', "all 0s")
        $(menu.selected).css('transition', "all 0s")
        openMenu();

        setTimeout(() => {
            $(menu.texts).css('transition', 'all 0.2s')
            $(menu.images).css('transition', "all 0.2s")
            $(menu.not_selected).css('transition', "all 0.2s")
            $(menu.div).css('transition', "all 0.2s")
            $(menu.selected).css('transition', "all 0.2s")
            closeMenu();
        }, 1000)
    } else{
        // Avoid animation to disaprear
        $(menu.div).css('transition-duration', "0s, 0s")
        const width = parseInt(window.innerWidth);
        if (width <= 500) $(menu.div).css('margin-left', '-100px')
        else $(menu.div).css('margin-left', '0')
        closeMenu();
        $(menu.div).css('transition-duration', "0.3s, 0.3s")
    }

    // Turn ON/OFF dark mode
      if (getCookie('dark-mode') === 'on') {
          turnOnDarkMode()
          $(settings.edit.dark_mode).attr('checked', 'on')
      } else {
          turnOffDarkMode()
          $(settings.edit.dark_mode).attr('checked', 'off')
      }


    // Turn ON/OFF night shift
    if (getCookie('night-shift') === 'on') {
        turnOnNightShift()
        $(settings.edit.night_shift).attr('checked', 'on')
    } else {
        turnOffNightShift()
        $(settings.edit.night_shift).attr('checked', 'off')
    }

    // Print modal div
    $('#modals').css('display', 'block')
}

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
    change.button.classList.remove("close-modal");
    change.button.classList.add("none");
    change.button.type = "submit";
  }
  textarea.pseudo_validate.style.marginRight = "50px";
  textarea.pseudo_validate.style.opacity = "0";
  //textarea.pseudo.disabled=true;
}

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
        //modals.show(search.no_text);
        return;
    }

    let supported = false;
    let found = false;
    if (window.find) {
        supported = true;
        // if some content is selected, the start position of the search
        // will be the end position of the selection
        found = window.find(str);
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
 * HELP MODAL
 */

 window.onclick = (event) => {
     // Close help modal
     if (help.modal.style.display === "block" && event.target !== help.show_btn ) {
         help.show_btn.classList.remove("help_logo_onclick");
         help.show_btn.style.filter = "invert(25%)";
         hide(help.modal);
     }
 };
help.show_btn.onclick = () => {
  if (help.modal.style.display=="block") {
    help.show_btn.classList.remove("help_logo_onclick");
    help.show_btn.style.filter = "invert(25%)";
    hide(help.modal);
  } else {
    help.show_btn.classList.add("help_logo_onclick");
    help.show_btn.style.filter =
        "invert(100%) hue-rotate(160deg) grayscale(100%)";
    show(help.modal);
  }

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
