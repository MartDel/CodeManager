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
    id: 'add_task',
    modal: document.getElementById("add_task_modal"),
    show_btn: document.getElementById("new_task_img"),
    close_btn: document.getElementById("close_add"),
    cancel_btn: document.getElementById("addtask_cancel"),
    title_input: document.querySelector(".textarea_title"),
    desc_input: document.getElementById("textarea_desc"),
};

// Settings elements
var settings = {
    id: 'settings',
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
    id: 'account',
    modal: document.getElementById("account_white_bc"),
    show_btn: document.getElementById("account_logo_img"),
    close: document.getElementById("close_account_modal"),
    option: document.getElementById("button_option"),
    back: document.getElementById("account_background")
};


// Selectall
var select_all = {
    select_all: document.getElementById("select_all"),
    checkbox: document.getElementsByClassName("to_check"),
    trash: document.getElementsByClassName("trash")[0],
};

//SWAP PROJECT MODAL
const project = {
    id: 'project'
}
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

var modaladd = document.getElementById("add_task_modal");

var projectactual = document.getElementById("project_actual");

/*
=========================
======= MAIN CODE =======
=========================
*/


window.onload = () => {
    closeMenu()

    //set selected menu
    //document.getElementById("menu1").className = "selectedmenu";
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

    // Print modal div
    document.querySelector('#modals').style.display = 'block'
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
        tasks_done.btn.style.animation = "0.5s Rotate";
        counter_done = 1;
    } else {
        tasks_done.btn.style.filter = "grayscale(100%)";
        tasks_done.btn.style.animation = "0.5s RotateInv";
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
    // var modal = document.getElementById(id + '_modal');

    if (!contain(tasks_btn.check_js, event.target) &&
        !contain(tasks_btn.tick, event.target) &&
        !contain(tasks_btn.tick2, event.target)
    ) {
        modals.show(id + '_modal');
    }
}
for (let i = 0; i < tasks.length; i++) {
    tasks[i].onclick = (event) => showModal(event);
}
for (let i = 0; i < tasks_done.list.length; i++) {
    tasks_done.list[i].onclick = (event) => showModal(event);
}

/*
 * ADD TASK MODAL
 */
addtask.show_btn.onclick = () => {
    modals.show(addtask.id)
};
addtask.cancel_btn.onclick = () => {
    addtask.title_input.value = "";
    addtask.desc_input.value = "";
};

/*
 * SETTINGS MODAL
 */
settings.show_btn.onclick = () => {
    modals.show(settings.id)
};
settings.close_btn.onclick = () => {
    settings.bug_input.value = "";
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
    // } else if (
    //     account.back.style.display === "block" &&
    //     !contain(event.path, account.back) &&
    //     event.target !== account.show_btn
    // ) {
    //     // Close account modal
    //     erase(account.back);
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

modal_swap_icon.onclick = () => modals.show(project.id)
projectactual.onclick = () => modals.show(project.id)

/*
 * ACCOUNT MODAL
 */
account.show_btn.onclick = () => {
    modals.show(account.id)
};
account.option.onclick = () => {
    setTimeout(() => modals.show(settings.id), 500)
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
