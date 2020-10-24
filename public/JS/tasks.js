let menu = {
    burger: document.getElementById("menu_checkbox"),
    is_open: false,
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
    selected_ligne: document.getElementsByClassName("ligne_et_taches")[0],
    selected_ligne_header: document.getElementById("ligne_haut_tache_id"),
    add_task_logo: document.getElementById("new_task_img"),
    // Close menu
    close(){
        for (var i = 0; i < menu.text.length; i++) {
            menu.text[i].style.opacity = "0";
            hide(menu.text[i]);
        }
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
    },
    // Open menu
    open(){
        setTimeout(() => {
            for (var i = 0; i < menu.text.length; i++) {
                show(menu.text[i]);
            }
        }, 300);
        setTimeout(() => {
            for (var i = 0; i < menu.text.length; i++) {
                menu.text[i].style.opacity = "1";
            }
        }, 310);
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
    }
}

/*
 * ONLOAD
 */
window.onload = () => {
    // Menu
    closeMenu()
    burger.onclick = () => {
        if (menu.is_open) menu.close();
        else menu.open();
        menu.is_open = !menu.is_open
    }

    //set selected menu
    //document.getElementById("menu1").className = "selectedmenu";

    // Hide or show done tasks
    /*const search = window.location.search
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
    }*/
}

/**
 * Hide a specific element
 * @param  {DOM element} element Element to hide
 */
function hide(element){
    element.style.display = "none";
}

function show(element){
    element.style.display = "block";
}
