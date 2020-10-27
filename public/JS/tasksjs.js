// Tasks elements
const tasks = {
    list: document.getElementsByName("task"),
    btn: {
        check_js: document.getElementsByClassName("check_js"),
        tick: document.getElementsByClassName("tick"),
        tick2: document.getElementsByClassName("tick2")
    }
}
let tasks_done = {
    show: false,
    btn: document.getElementById('tasks_done'),
    list: document.getElementsByName('done_task')
}

// 'Add task' elements
let addtask = {
    id: 'add_task',
    modal: document.getElementById("add_task_modal"),
    show_btn: document.getElementById("new_task_img"),
    close_btn: document.getElementById("close_add"),
    cancel_btn: document.getElementById("addtask_cancel"),
    title_input: document.querySelector(".textarea_title"),
    desc_input: document.getElementById("textarea_desc"),
};

// Selectall
const select_all = {
    select_all: document.getElementById("select_all"),
    checkbox: document.getElementsByClassName("to_check"),
    trash: document.getElementsByClassName("trash")[0],
};

/*
=========================
======= MAIN CODE =======
=========================
*/

window.onload = () => {
    // Menu/nav onload function and check if there is a message to print
    wOnload()
    checkMessage()
    
    // Hide or show done tasks
    const search = window.location.search
    const params = new URLSearchParams(search)
    tasks_done.show = params.has('endTask')
    showTasks(!tasks_done.show)
    showDoneTasks(tasks_done.show)
};

/*
 * SHOW DONE TASKS
 */
function showTasks(print) {
    for (let i = 0; i < tasks.list.length; i++) {
        if (print) show(tasks.list[i])
        else hide(tasks.list[i])
    }
}

function showDoneTasks(print) {
    for (let i = 0; i < tasks_done.list.length; i++) {
        if (print) show(tasks_done.list[i])
        else hide(tasks_done.list[i])
    }
}
var counter_done = 0;
tasks_done.btn.onclick = () => {
    showTasks(tasks_done.show)
    showDoneTasks(!tasks_done.show)
    tasks_done.show = !tasks_done.show
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

    if (!contain(tasks.btn.check_js, event.target) &&
        !contain(tasks.btn.tick, event.target) &&
        !contain(tasks.btn.tick2, event.target)
    ) {
        modals.show(id + '_modal');
    }
}
for (let i = 0; i < tasks.list.length; i++) {
    tasks.list[i].onclick = (event) => showModal(event);
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
 * SELECT ALL TASKS
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
            for (let i = 0; i < select_all.checkbox.length; i++) {
                if (!select_all.checkbox[i].checked) all_selected = false;
            }
            if (all_selected) select_all.select_all.checked = true;
        } else {
            let all_selected = true
            for (let i = 0; i < select_all.checkbox.length; i++) {
                if (!select_all.checkbox[i].checked) all_selected = false;
            }
            if (all_selected) select_all.select_all.checked = true;
            else select_all.select_all.checked = false;

            let hide = true;
            for (let i = 0; i < select_all.checkbox.length; i++) {
                if (select_all.checkbox[i].checked) hide = false;
            }
            if (hide) select_all.trash.style.display = "none";
        }
    };
}
