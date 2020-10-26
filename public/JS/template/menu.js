// Menu element
var open = false;
var menu = {
    main_div: document.getElementById("menu_gauche"),
    text: [
        document.getElementById("text_menu_left_1"),
        document.getElementById("text_menu_left_2"),
        document.getElementById("text_menu_left_3"),
        document.getElementById("text_menu_left_4"),
        document.getElementById("text_menu_left_5"),

    ],
    img: document.getElementsByClassName("img_menu_gauche_js"), // Array
    selected: document.getElementsByClassName("selectedmenu")[0],
    not_selected: document.getElementsByClassName("notselectedmenu"), // Array
    //selected_ligne: document.getElementsByClassName("ligne_et_taches")[0],
    //selected_ligne_header: document.getElementById("ligne_haut_tache_id"),
    add_task_logo: document.getElementById("new_task_img")
    //add_task_div: document.getElementById("new_task_div"),
};
var settings = {
    id: 'settings',
    modal: document.getElementById("bcc_settings"),
    show_btn: document.getElementById("gear_logo_img"),
    close_btn: document.getElementById("close_settings"),
    dark_mode_btn: document.getElementById("dark_mode"),
    night_shift_btn: document.getElementById("night_shift"),
    bug_input: document.getElementById("textarea_bug")
};
var burger = document.getElementById("menu_checkbox");


/*
 * ONLOAD
 */


// Dark mode

settings.dark_mode_btn.onchange = () => {
    if (settings.dark_mode_btn.checked) turnOnDarkMode()
    else turnOffDarkMode()
};
function turnOnDarkMode() {
    body.style.filter = "invert(100%) hue-rotate(200deg)";
    account_logo.style.filter = "invert(100%) hue-rotate(-200deg)";
    settings.night_shift_btn.checked = false;

    // Set dark-mode cookie
    setCookie('dark-mode', 'on')
}
function turnOffDarkMode() {
    body.style.filter = "invert(0%) hue-rotate(0deg)";
    account_logo.style.filter = "invert(0%) hue-rotate(0deg)";

    // Set dark-mode cookie
    setCookie('dark-mode', 'off')
}

// Night shift
settings.night_shift_btn.onchange = () => {
    if (settings.night_shift_btn.checked) turnOnNightShift()
    else turnOffNightShift()
};
function turnOnNightShift() {
    body.style.filter = "sepia(70%)";
    account_logo.style.filter = "invert(0%) hue-rotate(0deg)";
    settings.dark_mode_btn.checked = false;

    // Set dark-mode cookie
    setCookie('night-shift', 'on')
}
function turnOffNightShift(){
    body.style.filter = "sepia(0%)";
    account_logo.style.filter = "invert(0%) hue-rotate(0deg)";

    // Set dark-mode cookie
    setCookie('night-shift', 'off')
}

/*
 * LEFT MENU
 */
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

    //menu.add_task_div.style.paddingBottom = "7px";
    //menu.add_task_div.style.marginLeft = "23px";
    //menu.add_task_div.style.width = "50px";

    //menu.add_task_logo.style.marginLeft = "8px";

    for (var i = 0; i < menu.img.length; i++) {
        menu.img[i].style.marginLeft = "-23px";
    }
    //menu.selected_ligne.style.marginLeft = "100px";
    //menu.selected_ligne.style.width = "calc(100% - 100px)";

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
        //menu.add_task_div.style.paddingBottom = "2px";
    }, 300);

    setTimeout(() => {
        for (var i = 0; i < menu.text.length; i++) {
            menu.text[i].style.opacity = "1";
        }
    }, 310);

    //menu.add_task_div.style.marginLeft = "23px";
    //menu.add_task_div.style.width = "210px";

    //menu.add_task_logo.style.marginLeft = "8px";

    for (var i = 0; i < menu.img.length; i++) {
        menu.img[i].style.marginLeft = "0px";
    }

    //menu.selected_ligne.style.marginLeft = "260px";
    //menu.selected_ligne.style.width = "calc(100% - 260px)";

    menu.main_div.style.width = "260px";

    menu.selected.style.paddingRight = "90px";

    for (var i = 0; i < menu.not_selected.length; i++) {
        menu.not_selected[i].style.paddingRight = "90px";
    }

    //menu.selected_ligne_header.style.width = "auto";
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
var contain = (array, value) => {
    var r = false;
    for (var i = 0; i < array.length; i++) {
        if (array[i] === value) r = true;
    }
    return r;
};
var openmodal = 0;
/**
 * Show a specific element
 * @param  {DOM element} element Element to show
 */
var show_modal = (element) => {
    element.style.display = "block";
    element.style.visbility = "visible";
    element.style.opacity = "1";
    element.style.animation = "0.6s ease 0s ModalComing";
    var www = element.getElementsByTagName("DIV")[0];
    www.style.animation = "0.9s linear 0s ModalComingBoth";
    //www.style.animation = "cubic-bezier(0.165, 0.840, 0.440, 1.000)";
    openmodal = 1;
};

/**
 * Show a specific element
 * @param  {DOM element} element Element to erase when clicked outside
 */
var show = (element) => {
    element.style.display = "block";
    element.style.visbility = "visible";
    element.style.opacity = "1";
};

/**
 * Don't show a specific element anymore
 * @param  {DOM element} element Element to erase
 */
var erase_modal = (element) => {
    element.style.animation = "0.6s ease 0s ModalLeaving";
    $(this).one(animationEvent,
        function() {
            element.style.display = 'none';
        });
    openmodal = 0;
};

/**
 * Show a specific element
 * @param  {DOM element} element Element to erase when clicked outside
 */

var erase = (element) => {
    element.style.display = "none";
    element.style.visbility = "hidden";
    element.style.opacity = "0";
}


function whichAnimationEvent() {
    var t,
        el = document.createElement("fakeelement");

    var animations = {
        "animation": "animationend",
        "OAnimation": "oAnimationEnd",
        "MozAnimation": "animationend",
        "WebkitAnimation": "webkitAnimationEnd"
    }

    for (t in animations) {
        if (el.style[t] !== undefined) {
            return animations[t];
        }
    }
}

var animationEvent = whichAnimationEvent();

/*
 * COOKIES FUNCTIONS
 */

/**
 * Get a specific cookie by its name
 * @param  {String} cname The cookie name
 * @return {String} The cookies value
 */
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
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
    var d = new Date();
    d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
