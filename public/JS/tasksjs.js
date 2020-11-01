// Tasks elements
const tasks = {
    list: document.getElementsByName("task"),
    btn: {
        check_js: document.getElementsByClassName("check_js"),
        tick: document.getElementsByClassName("tick"),
        tick2: document.getElementsByClassName("tick2"),
    },
    container: document.getElementById('liste_taches'),
}
let tasks_done = {
    show: false,
    btn: document.getElementById('tasks_done'),
    list: document.getElementsByName('done_task')
}

// 'Add task' elements
const addtask = {
    id: 'add_task',
    modal: document.getElementById("add_task_modal"),
    show_btn: document.getElementById("new_task_img"),
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

let display = {
  button:document.getElementsByClassName("selected_display")[0],
  global:document.getElementById("select_display_global"),
  open:document.getElementsByClassName("notselected_display")[0],
  first:document.getElementById("firstdisplay"),
  second:document.getElementById("seconddisplay"),
  category_1:document.getElementById("category_1"),
  category_2:document.getElementById("category_2")
}


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
        if (tasks_done.show) {
                tasks_done.btn.style.filter = "grayscale(0%)";
                tasks_done.btn.style.animation = "0.5s Rotate";
        } else {
                tasks_done.btn.style.filter = "grayscale(100%)";
                tasks_done.btn.style.animation = "0.5s RotateInv";
        }
        tasks.container.style.opacity = 1
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
tasks_done.btn.onclick = () => {
    setURLParams(tasks_done.show ? '' : 'endTask')
    showTasks(tasks_done.show)
    showDoneTasks(!tasks_done.show)
    if (!tasks_done.show) {
        tasks_done.btn.style.filter = "grayscale(0%)";
        tasks_done.btn.style.animation = "0.5s Rotate";
    } else {
        tasks_done.btn.style.filter = "grayscale(100%)";
        tasks_done.btn.style.animation = "0.5s RotateInv";
    }
    tasks_done.show = !tasks_done.show
}


/*CHANGE DISPLAY*/

display.button.onclick =()=>{
  if (display.open.style.display=="block") {
    display.open.style.display="none";
    display.open.style.opacity="0";
    display.global.style.borderRadius="50%";
    display.global.style.height="49px";

  } else {
    display.open.style.display="block";
    setTimeout(()=>display.open.style.opacity="1",200);
    display.global.style.borderRadius="500px";
    display.global.style.height="108px";
  }
}
change_display=()=>{
  if (display.first.style.display=="block") {
    display.first.style.display="none"
    display.second.style.display="block"
    display.open.style.display="none";
    display.open.style.opacity="0"
    display.global.style.borderRadius="50%";
    display.category_2.src="public/img/category_1.png"
    display.global.style.height="49px";
    display.category_1.src="public/img/category_2.png"
    setCookie("display", "2")
  } else {
    display.first.style.display="block"
    display.second.style.display="none"
    display.open.style.display="none";
    display.open.style.opacity="0";
    display.global.style.borderRadius="50%";
    display.global.style.height="49px";
    display.category_2.src="public/img/category_2.png"
    display.category_1.src="public/img/category_1.png"
    setCookie("display", "1")
  }
}

/*
 * MODAL TASK
 */
function showModal(event, suffix) {
    // Get task id
    let id = null;
    const path = event.path;
    for (let i = 0; i < path.length; i++) {
        const current_id = path[i].id;
        if (current_id !== undefined) {
            if (current_id.indexOf("task") !== -1) id = current_id;
        }
    }

    if (contain(tasks.btn.tick2, event.target)) modals.show(id + '_edit')
    else if (!contain(tasks.btn.check_js, event.target) && !contain(tasks.btn.tick, event.target)) modals.show(id + '_modal');
}
for (let i = 0; i < tasks.list.length; i++) {
    tasks.list[i].onclick = (event) => showModal(event, '_modal');
}
for (let i = 0; i < tasks_done.list.length; i++) {
    tasks_done.list[i].onclick = (event) => showModal(event, '_modal');
    if(tasks_done.list[i].querySelector('.edittask-btn')) {
    }
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

function setURLParams(params){
    // Get file name
    let file_name = null
    const path = window.location.pathname.split('/')
    path.forEach((item, i) => {
        if(i === path.length-1) file_name = item
    })

    const obj = {
        title: document.title,
        url: file_name + '?' + params
    }
    history.pushState(obj, obj.title, obj.url)
}
