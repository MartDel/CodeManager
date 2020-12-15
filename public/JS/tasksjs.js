// Tasks elements
const tasks = {
    list: document.getElementsByName("task"),
    btn: {
        check_js: document.getElementsByClassName("check_js"),
        tick: document.getElementsByClassName("tick"),
        tick2: document.getElementsByClassName("tick2"),
        trash: document.getElementsByClassName("trash-btn")
    },
    container: document.getElementById('liste_taches'),
}
let tasks_done = {
    show: false,
    btn: document.getElementsByClassName('tasks_done'),
    list: document.getElementsByName('done_task')
}

// 'Add task' elements
const addtask = {
    id: 'add_task',
    modal: document.getElementById("add_task_modal"),
    show_btns: document.getElementsByClassName("new_task_img"),
    cancel_btn: document.getElementById("addtask_cancel"),
    title_input: document.querySelector(".textarea_title"),
    title:document.getElementById("addtask_title"),
    cate:document.getElementById("addtask_cate"),
    desc_input: document.getElementById("textarea_desc"),
    buttoncate:document.getElementById("new_cat_button"),
    inputcate:document.getElementById("input_new_cat"),
    buttoncate2: ".new_cat_button2",
    inputcate2: ".input_new_cat2"
};


// Selectall
const select_all = {
    select_all: document.getElementById("select_all"),
    checkbox: document.getElementsByClassName("to_check"),
    trash: document.getElementsByClassName("trash")[0],
    trash2: document.getElementsByClassName("trash2")[0],
    delete_task:"delete_task",
    yes_task:document.getElementById("yes_delete_task"),
    nb_tasks: document.getElementById('nb_tasks')
};
const select_all2 = {
    select_all: document.getElementById("select_all2"),
    category_names: document.getElementsByClassName('categories'),
    categories: document.getElementsByClassName('category-check'),
    checkbox: document.getElementsByClassName("to-check2"),
    trash: document.getElementsByClassName("trash")[1],
};

let display = {
    button:document.getElementsByClassName("selected_display")[0],
    global:document.getElementById("select_display_global"),
    open:document.getElementsByClassName("notselected_display")[0],
    first:document.getElementById("firstdisplay"),
    second:document.getElementById("seconddisplay"),
    category_1:document.getElementById("category_1"),
    category_2:document.getElementById("category_2"),
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

    // Set display
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


    // Hide or show done tasks
    const search = window.location.search
    const params = new URLSearchParams(search)
    tasks_done.show = params.has('endTask')
    showTasks(!tasks_done.show)
    showDoneTasks(tasks_done.show)
    for (let i = 0; i < tasks_done.btn.length; i++) {
        if (tasks_done.show) {
                tasks_done.btn[i].style.filter = "grayscale(0%)";
                tasks_done.btn[i].style.animation = "0.5s Rotate";
        } else {
                tasks_done.btn[i].style.filter = "grayscale(100%)";
                tasks_done.btn[i].style.animation = "0.5s RotateInv";
        }
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

        const inputs = tasks.list[i].getElementsByTagName('input')
        manageActivesInputs(inputs, print)
    }
    manageCategoryNames(!print)
}
function showDoneTasks(print) {
    for (let i = 0; i < tasks_done.list.length; i++) {
        if (print) show(tasks_done.list[i])
        else hide(tasks_done.list[i])

        const inputs = tasks_done.list[i].getElementsByTagName('input')
        manageActivesInputs(inputs, print)
    }
}
function manageActivesInputs(inputs, active){
    for (let i = 0; i < inputs.length; i++) {
        if(inputs[i].type === 'checkbox'){
            if(active) inputs[i].classList.add('active')
            else inputs[i].classList.remove('active')
        }
    }
}
/**
 * Show/hide some categories
 * @param  {bool} done_task If the tasks must be done or not
 */
function manageCategoryNames(done_task) {
    $('.table_contain').toArray().forEach((table, i) => {
        const rows = table.rows
        let useful_tasks = 0
        for (let i = 0; i < rows.length; i++) {
            if(rows[i].id.indexOf('task') !== -1){
                if((rows[i].id.indexOf('done_') !== -1 && done_task)
                || (rows[i].id.indexOf('done_') === -1 && !done_task)) useful_tasks++
            }
        }
        if(useful_tasks === 0) $(table).css('display', 'none')
        else $(table).css('display', 'table')
    })
}
for (let i = 0; i < tasks_done.btn.length; i++) {
    tasks_done.btn[i].onclick = (event) => {
        setURLParams(tasks_done.show ? '' : 'endTask')

        const display = getCookie('display') === '1' ? select_all : select_all2
        display.select_all.checked = false
        for (let i = 0; i < display.checkbox.length; i++) {
            display.checkbox[i].checked = false
        }

        showTasks(tasks_done.show)
        showDoneTasks(!tasks_done.show)

        if (!tasks_done.show) {
            event.target.style.filter = "grayscale(0%)";
            event.target.style.animation = "0.5s Rotate";
        } else {
            event.target.style.filter = "grayscale(100%)";
            event.target.style.animation = "0.5s RotateInv";
        }

        tasks_done.show = !tasks_done.show
    }
}


/*
 * CHANGE DISPLAY
 */
display.button.onclick =()=>{
    if (display.open.style.display === "block") {
        display.open.style.display="none";
        display.open.style.opacity="0";
        display.global.style.borderRadius="50%";
        display.global.style.height="39px";
    } else {
        display.open.style.display="block";
        setTimeout(()=>display.open.style.opacity="1",200);
        display.global.style.borderRadius="500px";
        display.global.style.height="88px";
    }
}
function change_display(){
    if (display.first.style.display === "block") {
        display.first.style.display="none"
        display.second.style.display="block"
        display.open.style.display="none";
        display.open.style.opacity="0"
        display.global.style.borderRadius="50%";
        display.category_2.src="public/img/category_1.png"
        display.global.style.height="39px";
        display.category_1.src="public/img/category_2.png"
        setCookie("display", "2")
    } else {
        display.global.style.height="39px";
        display.first.style.display="block"
        display.second.style.display="none"
        display.open.style.display="none";
        display.open.style.opacity="0";
        display.global.style.borderRadius="50%";
        display.category_2.src="public/img/category_2.png"
        display.category_1.src="public/img/category_1.png"
        setCookie("display", "1")
    }
}

/*
 * MODAL TASK
 */
function showModal(event) {
    // Get task id
    let id = null;
    const path = event.path;
    for (let i = 0; i < path.length; i++) {
        const current_id = path[i].id;
        if (current_id !== undefined) {
            if (current_id.indexOf("task") !== -1) id = current_id;
        }
    }
    if(!id) return;

    if (contain(tasks.btn.tick2, event.target)) {
        if(permissions != 0) {
          modals.show(id + '_edit',()=>{
          addtask.buttoncate2.style.opacity=1;
          addtask.buttoncate2.style.display="flex";
          addtask.inputcate2.style.display="none";
          addtask.inputcate2.style.opacity=0;
        })}
        else {
            const err = new Message('error', 'Action refusée...', "Vous n'avez pas l'autorisation de modifier une tâche.")
            err.show()
        }
    } else if(!contain(tasks.btn.check_js, event.target)
    && !contain(tasks.btn.tick, event.target)
    && !contain(tasks.btn.trash, event.target)) modals.show(id + '_modal');
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
for (let i = 0; i < addtask.show_btns.length; i++) {
    addtask.show_btns[i].onclick = () => {
        if(permissions != 0){
            modals.show(addtask.id,()=>{
                addtask.title.value="";
                addtask.desc_input.value="";
                addtask.buttoncate.style.display="flex";
                addtask.inputcate.style.display="none";
                addtask.inputcate.style.opacity=0;
                addtask.buttoncate.style.opacity=1;

            })
        } else {
            const err = new Message('error', 'Action refusée...', "Vous n'avez pas l'autorisation d'ajouter une tâche.")
            err.show()
        }
    }
}


// addtask.buttoncate.onclick=()=>{
//   addtask.buttoncate.style.opacity=0;
//
//   setTimeout(()=>{
//     addtask.buttoncate.style.display="none";
//     addtask.inputcate.style.display="flex";
//   },300);
//   setTimeout(()=>{
//     addtask.inputcate.style.opacity=1;
//     addtask.inputcate.focus()
//   },350);
// }
$(addtask.buttoncate2).click(() => {
    const $btn = $(this)
    const $input = $btn.parent().children(addtask.inputcate2)
    $btn.css('opacity', 0)
    setTimeout(()=>{
        $btn.css('display', 'none')
        $input.css('display', 'flex')
    }, 300);
    setTimeout(()=>{
        $input.css('opacity', 1)
    }, 350);
})
/*addtask.cancel_btn.onclick = () => {
    addtask.title_input.value = "";
    addtask.desc_input.value = "";
};*/

/*
 * SELECT ALL TASKS
 */
function selectAll(display){
    for (let i = 0; i < display.checkbox.length; i++) {
        if (display.checkbox[i].classList.contains('active')
        && !display.checkbox[i].classList.contains('category-check')){
            display.checkbox[i].checked = display.select_all.checked;
        }
    }
    display.trash.style.display = display.select_all.checked ? "inline-block" : "none";

    // Check categories
    if(display === select_all2){
        for (let i = 0; i < select_all2.categories.length; i++) {
            select_all2.categories[i].checked = display.select_all.checked
        }
    }
}
function manageCheckbox(event) {
    const c_checkbox = event.target;
    const display = c_checkbox.classList.contains('to-check2') ? select_all2 : select_all

    // To check or not to check selectAll checkbox
    let all_selected = true
    for (let i = 0; i < display.checkbox.length; i++) {
        if (display.checkbox[i].classList.contains('active')
        && !display.checkbox[i].checked
        && !display.checkbox[i].classList.contains('category-check')) all_selected = false;
    }
    display.select_all.checked = all_selected;

    // Get current category
    const category = getTaskCategory(c_checkbox)
    if (!category) return;
    // To check or not to check category checkbox
    let category_selected = true
    for (let i = 0; i < display.checkbox.length; i++) {
        if (display.checkbox[i].classList.contains('active')
        && !display.checkbox[i].checked
        && !display.checkbox[i].classList.contains('category-check')
        && getTaskCategory(display.checkbox[i]) === category) category_selected = false;
    }
    document.getElementById(category).checked = category_selected

    if (c_checkbox.checked) display.trash.style.display = "inline-block";
    else {
        let all_selected = true
        for (let i = 0; i < display.checkbox.length; i++) {
            if (!display.checkbox[i].checked) all_selected = false;
        }
        display.select_all.checked = all_selected;

        let hide = true;
        for (let i = 0; i < display.checkbox.length; i++) {
            if (display.checkbox[i].checked) hide = false;
        }
        if (hide) display.trash.style.display = "none";
    }
}
function getTaskCategory(input){
    const classes = input.classList
    for (let i = 0; i < classes.length; i++) {
        if(classes[i].indexOf('in-category') !== -1) return classes[i].substring(3)
    }
    return null
}
function getTasksToDelete1(){
    let id_list = []
    for (let i = 0; i < select_all.checkbox.length; i++) {
        const checkbox = select_all.checkbox[i]
        if(checkbox.checked){
            const task = checkbox.parentElement.parentElement.parentElement
            const task_id = task.id.replace('task', '')
            id_list.push(task_id)
        }
    }
    return id_list
}
function getTasksToDelete2(){
    let id_list = []
    for (let i = 0; i < select_all2.checkbox.length; i++) {
        const checkbox = select_all2.checkbox[i]
        if(checkbox.checked && !checkbox.classList.contains('category-check')){
            const task = checkbox.parentElement.parentElement.parentElement.parentElement
            const task_id = task.id.replace('task', '')
            id_list.push(task_id)
        }
    }
    return id_list
}
function deleteTasks(id_list){
    let str = ''
    id_list.forEach((id, i) => {
        str += id + (i === id_list.length-1 ? '' : '+')
    })
    window.location.search = '?action=deleteTasks&tasks=' + str
}

// First display
select_all.select_all.onclick = () => selectAll(select_all)
for (let i = 0; i < select_all.checkbox.length; i++) {
    select_all.checkbox[i].onclick = manageCheckbox
}

select_all.trash.onclick = () => {
    if(permissions == 0){
        const err = new Message('error', 'Action refusée...', "Vous n'avez pas l'autorisation de supprimer une ou plusieurs tâches.")
        err.show()
        return;
    }
    select_all.nb_tasks.innerText = getTasksToDelete1().length
    modals.show(select_all.delete_task)
    select_all.yes_task.onclick = () => deleteTasks(getTasksToDelete1())
}

// Second display
select_all2.select_all.onclick = () => selectAll(select_all2)
for (let i = 0; i < select_all2.checkbox.length; i++) {
    select_all2.checkbox[i].onclick = manageCheckbox
}
for (let i = 0; i < select_all2.categories.length; i++) {
    select_all2.categories[i].onclick = (event) => {
        const c_checkbox = event.target
        const category = c_checkbox.id

        for (let i = 0; i < select_all2.checkbox.length; i++) {
            if (select_all2.checkbox[i].classList.contains('active')
            && !select_all2.checkbox[i].classList.contains('category-check')
            && getTaskCategory(select_all2.checkbox[i]) === category){
                select_all2.checkbox[i].checked = c_checkbox.checked
            }
        }

        let all_categories_checked = true
        for (let i = 0; i < select_all2.categories.length; i++) {
            if(!select_all2.categories[i].checked) all_categories_checked = false
        }
        select_all2.select_all.checked = all_categories_checked

        select_all2.trash.style.display = c_checkbox.checked ? "inline-block" : "none";
    }
}
select_all2.trash.onclick = () => {
    if(permissions == 0){
        const err = new Message('error', 'Action refusée...', "Vous n'avez pas l'autorisation de supprimer une ou plusieurs tâches.")
        err.show()
        return;
    }
    select_all.nb_tasks.innerText = getTasksToDelete2().length
    modals.show(select_all.delete_task)
    select_all.yes_task.onclick = () => deleteTasks(getTasksToDelete2())
}
