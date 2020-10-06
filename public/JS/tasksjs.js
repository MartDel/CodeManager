// Tasks elements
var tasks = document.getElementsByName("task");
var tasks_btn = {
    check_js: document.getElementsByClassName("check_js"),
    tick: document.getElementsByClassName("tick"),
    tick2: document.getElementsByClassName("tick2"),
};
const tasks_done = {
    btn: document.getElementById('tasks_done'),
    list: document.getElementsByName('done_task')
}
let show_done_tasks = false

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
    modal: document.getElementById("account_white_bc"),
    show_btn: document.getElementById("account_logo_img"),
    close: document.getElementById("close_account_modal"),
    option: document.getElementById("button_option"),
    back: document.getElementById("account_background")
};

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
var modal_swap_modal = document.getElementById("project_modal");
var modal_swap_icon = document.getElementById("switch_logo_img");

var close_btn = document.getElementsByClassName("close");
var body = document.getElementsByTagName("body")[0];
var account_logo = document.getElementById("account_logo_img");

var burger = document.getElementById("menu_checkbox");
var modaladd = document.getElementById("add_task_modal");

var projectactual = document.getElementById("project_actual");

/*
=========================
======= MAIN CODE =======
=========================
*/

/*
 * ONLOAD
 */
window.onload = () => {
    // Close menu when JS is loaded
    closeMenu()

    // Hide or show done tasks
    const search = window.location.search
    const params = new URLSearchParams(search)
    show_done_tasks = params.has('endTask')
    showTasks(!show_done_tasks)
    showDoneTasks(show_done_tasks)

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
};

/*
 * SHOW DONE TASKS
 */
function showTasks(print) {
    for (let i = 0; i < tasks.length; i++) {
        if (print) show(tasks[i])
        else erase(tasks[i])
    }
}

function showDoneTasks(print) {
    for (let i = 0; i < tasks_done.list.length; i++) {
        if (print) show(tasks_done.list[i])
        else erase(tasks_done.list[i])
    }
}
var counter_done = 0;
tasks_done.btn.onclick = () => {
    showTasks(show_done_tasks)
    showDoneTasks(!show_done_tasks)
    show_done_tasks = !show_done_tasks
    if (counter_done == 0) {
        tasks_done.btn.style.filter = "grayscale(0%)";
        tasks_done.btn.style.animation = "0.5s Rotate"
        counter_done = 1;
    } else {
        tasks_done.btn.style.filter = "grayscale(100%)";
        tasks_done.btn.style.animation = "0.5s RotateInv"
        counter_done = 0;
    }
}


/*
 * MODAL TASK
 */
function showModal(event) {
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
    var modal = document.getElementById(id + '_modal');

    if (!contain(tasks_btn.check_js, event.target) &&
        !contain(tasks_btn.tick, event.target) &&
        !contain(tasks_btn.tick2, event.target)
    ) {
        // Everythings is ok, let's go show the popup
        show(modal);
    }
}
for (var i = 0; i < tasks.length; i++) {
    tasks[i].onclick = (event) => showModal(event);
}
for (let i = 0; i < tasks_done.list.length; i++) {
    tasks_done.list[i].onclick = (event) => showModal(event);
}

/*
 * ADD TASK MODAL
 */
addtask.show_btn.onclick = () => {
    show_modal(addtask.modal);
};
addtask.close_btn.onclick = () => {
    erase_modal(addtask.modal);
};
addtask.cancel_btn.onclick = (event) => {
    addtask.title_input.value = "";
    addtask.desc_input.value = "";
    erase_modal(addtask.modal);
};

/*
 * SETTINGS MODAL
 */
settings.show_btn.onclick = () => {
    show_modal(settings.modal);
};
settings.close_btn.onclick = () => {
    settings.bug_input.value = "";
    erase_modal(settings.modal);
};

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
 * HELP MODAL
 */
help.show_btn.onclick = () => {
    help.show_btn.classList.add("help_logo_onclick");
    help.show_btn.style.filter =
        "invert(100%) hue-rotate(160deg) grayscale(100%)";
    show(help.modal);
};



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
        help.show_btn.style.filter = "invert(25%)";

        erase(help.modal);
    } else if (
        account.back.style.display === "block" &&
        !contain(event.path, account.back) &&
        event.target !== account.show_btn
    ) {
        // Close account modal
        erase(account.back);
    }
});

/*
 * Selectall task
 */
select_all.select_all.onclick = () => {
    for (let i = 0; i < select_all.checkbox.length; i++) {
        select_all.checkbox[i].checked = select_all.select_all.checked;
    }
    if (select_all.select_all.checked) {
        select_all.trash.style.display = "inline-block";
    } else {
        select_all.trash.style.display = "none";
    }
};
for (let i = 0; i < select_all.checkbox.length; i++) {
    select_all.checkbox[i].onclick = (event) => {
        let c_checkbox = event.target;
        // console.log(c_checkbox);
        if (c_checkbox.checked) {
            // Show trash or do nothing
            select_all.trash.style.display = "inline-block";

            let all_selected = true
            for (var i = 0; i < select_all.checkbox.length; i++) {
                if (!select_all.checkbox[i].checked) all_selected = false;
            }
            if (all_selected) select_all.select_all.checked = true;
        } else {
            let all_selected = true
            for (var i = 0; i < select_all.checkbox.length; i++) {
                if (!select_all.checkbox[i].checked) all_selected = false;
            }
            if (all_selected) select_all.select_all.checked = true;
            else select_all.select_all.checked = false;

            let hide = true;
            for (var i = 0; i < select_all.checkbox.length; i++) {
                if (select_all.checkbox[i].checked) hide = false;
            }
            if (hide) select_all.trash.style.display = "none";
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
var name_new_pro = document.getElementById("new_project_name");
var desc_new_pro = document.getElementById("new_project_desc");
var git_new_pro = document.getElementById("new_project_git");


document.getElementById("close_swap").onclick = () => {
    erase_modal(modal_swap);
    name_new_pro.value = "";
    desc_new_pro.value = "";
    git_new_pro.value = "";

};

modal_swap_icon.onclick = () => {
    show_modal(modal_swap)
}

projectactual.onclick = () => {
    show_modal(modal_swap);
}


/*
 * ACCOUNT MODAL
 */
account.show_btn.onclick = () => {
    show_modal(account.back);

};
account.close.onclick = () => {
    erase_modal(account.back);
};
account.option.onclick = () => {
    erase(account.back);
    show(settings.modal);
};

//SEARCH BAR

var input_search = document.getElementById("findField");

input_search.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        FindNext();
    }
});

function FindNext() {
    //If void
    var str = document.getElementById("findField").value;
    if (str == "") {
        alert("Veuillez entrer du texte");
        return;
    }

    var supported = false;
    var found = false;
    if (window.find) {
        supported = true;
        // if some content is selected, the start position of the search
        // will be the end position of the selection
        found = window.find(str);
    } else {
        if (document.selection && document.selection.createRange) {
            var textRange = document.selection.createRange();
            if (textRange.findText) {
                supported = true;
                // if some content is selected, the start position of the search
                // will be the position after the start position of the selection
                if (textRange.text.length > 0) {
                    textRange.collapse(true);
                    textRange.move("character", 1);
                }

                found = textRange.findText(str);
                if (found) {
                    textRange.select();
                }
            }
        }
    }

    if (supported) {
        if (!found) {
            alert("The following text was not found:\n" + str);
        }
    } else {
        alert("Your browser does not support this example!");
    }
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
