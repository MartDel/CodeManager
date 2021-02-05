// 'Add task' elements
const addtask = {
  id: 'add_task',
  modal: document.getElementById("add_task_modal"),
  show_btns: document.getElementsByClassName("new_task_img"),
  cancel_btn: document.getElementById("addtask_cancel"),
  title_input: document.querySelector(".textarea_title"),
  cate: document.getElementById("addtask_cate"),
  buttoncate: document.getElementById("new_cat_button"),
  inputcate: document.getElementById("input_new_cat"),
  buttoncate2: ".new_cat_button2",
  inputcate2: ".input_new_cat2"
};


// Selectall
const select_all = {
  select_all: document.getElementById("select_all"),
  checkbox: document.getElementsByClassName("to_check"),
  trash: document.getElementsByClassName("trash")[0],
  trash2: document.getElementsByClassName("trash2")[0],
  delete_task: "delete_task",
  yes_task: document.getElementById("yes_delete_task"),
  nb_tasks: document.getElementById('nb_tasks')
};
const select_all2 = {
  select_all: document.getElementById("select_all2"),
  category_names: document.getElementsByClassName('categories'),
  categories: document.getElementsByClassName('category-check'),
  checkbox: document.getElementsByClassName("to-check2"),
  trash: document.getElementsByClassName("trash")[1],
};

/*
=========================
======= MAIN CODE =======
=========================
*/

const tasks = {
    list: ".task",
    list1: ".myBtn",
    container2: '#liste_taches',
    edit: {
        btn: '.tick2'
    },
    done: {
        btn: '.tasks_done',
        list: '.done_task',
        tick: ".tick",
        tick2: ".tick2",
        check_js: ".check_js"
    },
    add: {
        id: 'add_task',
        show_btns: ".new_task_img",
        title: document.getElementById("addtask_title"),
        desc_input: document.getElementById("textarea_desc"),
        buttoncate: ".new_cat_button2",
        inputcate: ".input_new_cat2"
    },
    categories: {
        table: '.table_contain'
    },
    other_btns: ['tick', 'to_check'],
    ////////////////////////////////
    btn: {
        trash: document.getElementsByClassName("trash-btn")
    },
    container: document.getElementById('liste_taches'),
}
let tasks_done = {
    show: false,
    btn: document.getElementsByClassName('tasks_done'),
    list: '.done_task'
}

const display = {
    btn: '.selected_display',
    opened: '.notselected_display',
    global: '#select_display_global',
    first: '#firstdisplay',
    second: '#seconddisplay',
    category_2: '#category_2',
    category_1: '#category_1',
}

new Vue({
    el: '#app',
    data: {
        done_task: false
    },
    methods: {
        switchDoneTask(e){
            // UPDATE DISPLAY
            const display = getCookie('display') === '1' ? select_all : select_all2
            display.select_all.checked = false
            for (let i = 0; i < display.checkbox.length; i++) {
                display.checkbox[i].checked = false
            }

            // Update btn
            const $this = $(e.target)
            if(this.done_task) $this.css('filter', 'grayscale(100%)').css('animation', '0.5s RotateInv')
            else $this.css('filter', 'grayscale(0%)').css('animation', '0.5s Rotate')

            setURLParams(this.done_task ? '' : 'endTask')
            this.done_task = !this.done_task

            // Update category
            // manageCategoryNames(this.done_task)
        },
        showCategory(id){
            const $table = $('#category' + id).parents('.table_contain')
            const rows = $table.find('tr').not(':hidden').length
            console.log($table.find('tr').not(':hidden'));
            console.log(id + ' -> ' + rows);
            return rows < 1
        }
    },
    mounted(){
        window.onload = () => {
            wOnload()
            checkMessage()

            // Set display
            setDisplay(getCookie('display'))

            // Show done tasks or not
            const search = window.location.search
            const params = new URLSearchParams(search)
            this.done_task = params.has('endTask')

            // Update btn for showing done tasks
            if(this.done_task) $(tasks.done.btn).css('filter', 'grayscale(0%)').css('animation', '0.5s Rotate')
            else $(tasks.done.btn).css('filter', 'grayscale(100%)').css('animation', '0.5s RotateInv')

            // Update category
            manageCategoryNames(this.done_task)

            $(tasks.container2).css('opacity', 1)
        }
    }
})

/*
 * SHOW DONE TASKS
 */
// function showTasks(print) {
//     $(tasks.list).each(function (){
//         if(print) show(this)
//         else hide(this)
//         manageActivesInputs($(this).find('input'), print)
//     })
//     manageCategoryNames(!print)
// }
// function showDoneTasks(print) {
//     $(tasks_done.list).each(function (){
//         if(print) show(this)
//         else hide(this)
//         manageActivesInputs($(this).find('input'), print)
//     })
//     manageCategoryNames(!print)
// }

/**
 * Set checkboxes to active or inactive
 * @param  {JQuery} inputs Inputs list
 * @param  {bool} active If it should be active or not
 */
// function manageActivesInputs(inputs, active) {
//     inputs.each(function (){
//         if(this.type === 'checkbox') {
//           if (active) $(this).addClass('active')
//           else $(this).removeClass('active')
//         }
//     })
// }

/**
 * Show/hide some categories
 * @param {bool} done_task If the tasks must be done or not
 */
function manageCategoryNames(done_task) {
    $('.table_contain').each(function (){
        const $rows = $(this.rows)
        let useful_tasks = 0
        $rows.each(function (){
            const match = classContains(this.classList, 'task')
            if (match) {
                if ((match.indexOf('done_') !== -1 && done_task) || (match.indexOf('done_') === -1 && !done_task)){
                    useful_tasks++
                }
            }
        })
        if (useful_tasks === 0) $(this).css('display', 'none')
        else $(this).css('display', 'table')
    })
}

/*
 * CHANGE DISPLAY
 */
$(display.btn).click(function (){
    if ($(display.opened).css('display') === "block") {
        $(display.opened).css('display', 'none').css('opacity', 0)
        $(display.global).css('border-radius', '50%').css('height', '39px')
    } else {
        $(display.opened).css('display', 'block')
        setTimeout(()=> $(display.opened).css('opacity', 1), 200);
        $(display.global).css('border-radius', '500px').css('height', '88px')
    }
})
function setDisplay(to_display = null){
    if(!to_display) to_display = $(display.first).css('display') === "block" ? '2' : '1'
    if (to_display === '2') {
        $(display.first).css('display', "none")
        $(display.second).css('display', "block")
        $(display.category_2).attr('src', "public/img/category_1.png")
        $(display.category_1).attr('src', "public/img/category_2.png")
        setCookie("display", "2")
    } else {
        $(display.first).css('display', "block")
        $(display.second).css('display', "none")
        $(display.category_2).attr('src', "public/img/category_2.png")
        $(display.category_1).attr('src', "public/img/category_1.png")
        setCookie("display", "1")
    }
    $(display.opened).css('display', "none").css('opacity', 0)
    $(display.global).css('border-radius', "50%").css('height', "39px")
}

/*
 * MODAL TASK
 */
function showModal(event) {
    // Get task id
    let id = null;
    const path = event.path;
    for (let i = 0; i < path.length; i++) {
        const classes = path[i].classList
        if(classes !== undefined && (classes.contains('task') || classes.contains('done_task'))){
            const match = classContains(classes, 'task')
            if(match) id = match
        }
    }
    if (!id) return;

    if (contain($(tasks.btn.tick2), event.target)) {
        if (permissions != 0) {
            modals.show(id + '_edit', () => {
                $(addtask.buttoncate2).css('opacity', 1).css('display', 'flex')
                $(addtask.inputcate2).css('display', "none").css('opacity', 0)
            })
        } else {
            const err = new Message('error', 'Action refusée...', "Vous n'avez pas l'autorisation de modifier une tâche.")
            err.show()
        }
    } else if (!contain($(tasks.btn.check_js), event.target) && !contain($(tasks.btn.tick), event.target) && !contain($(tasks.btn.trash), event.target)){
        if($('#' + id + '_modal').toArray().length === 0) return;
        modals.show(id + '_modal');
    }
}
$(tasks.list).click(function (event){ showModal(event) })
$(tasks_done.list).click(function (event){ showModal(event) })

/*
 * ADD TASK MODAL
 */
$(tasks.add.show_btns).click(function (){
    if (permissions != 0) {
        modals.show(tasks.add.id, () => {
            $(tasks.add.title).attr('value', "")
            $(tasks.add.desc_input).attr('value', "")
            $(tasks.add.buttoncate).css('opacity', 1).css('display', 'block')
            $(tasks.add.inputcate).css('display', "none").css('opacity', 0)
        })
    } else {
        const err = new Message('error', 'Action refusée...', "Vous n'avez pas l'autorisation d'ajouter une tâche.")
        err.show()
    }
})
$(addtask.buttoncate2).click(function() {
  const $btn = $(this)
  const $input = $btn.parent().children(addtask.inputcate2)
  $btn.css('opacity', 0)
  setTimeout(() => {
    $btn.css('display', 'none')
    $input.css('display', 'flex').css('opacity', 1).focus()
  }, 300);
})
/*addtask.cancel_btn.onclick = () => {
    addtask.title_input.value = "";
    addtask.desc_input.value = "";
};*/

/*
 * SELECT ALL TASKS
 */
function selectAll(display) {
  for (let i = 0; i < display.checkbox.length; i++) {
    if (display.checkbox[i].classList.contains('active') &&
      !display.checkbox[i].classList.contains('category-check')) {
      display.checkbox[i].checked = display.select_all.checked;
    }
  }
  display.trash.style.display = display.select_all.checked ? "inline-block" : "none";

  // Check categories
  if (display === select_all2) {
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
    if (display.checkbox[i].classList.contains('active') &&
      !display.checkbox[i].checked &&
      !display.checkbox[i].classList.contains('category-check')) all_selected = false;
  }
  display.select_all.checked = all_selected;

  // Get current category
  const category = getTaskCategory(c_checkbox)
  if (category) { // To check or not to check category checkbox
    let category_selected = true
    for (let i = 0; i < display.checkbox.length; i++) {
      if (display.checkbox[i].classList.contains('active') &&
        !display.checkbox[i].checked &&
        !display.checkbox[i].classList.contains('category-check') &&
        getTaskCategory(display.checkbox[i]) === category) category_selected = false;
    }
    document.getElementById(category).checked = category_selected
  }

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

function getTaskCategory(input) {
  const classes = input.classList
  for (let i = 0; i < classes.length; i++) {
    if (classes[i].indexOf('in-category') !== -1) return classes[i].substring(3)
  }
  return null
}

function getTasksToDelete1() {
  let id_list = []
  for (let i = 0; i < select_all.checkbox.length; i++) {
    const checkbox = select_all.checkbox[i]
    if (checkbox.checked) {
      const task = checkbox.parentElement.parentElement.parentElement
      const task_id = task.id.replace('task', '')
      id_list.push(task_id)
    }
  }
  return id_list
}

function getTasksToDelete2() {
  let id_list = []
  for (let i = 0; i < select_all2.checkbox.length; i++) {
    const checkbox = select_all2.checkbox[i]
    if (checkbox.checked && !checkbox.classList.contains('category-check')) {
      const task = checkbox.parentElement.parentElement.parentElement.parentElement
      const task_id = task.id.replace('task', '')
      id_list.push(task_id)
    }
  }
  return id_list
}

function deleteTasks(id_list) {
  let str = ''
  id_list.forEach((id, i) => {
    str += id + (i === id_list.length - 1 ? '' : '+')
  })
  window.location.search = '?action=deleteTasks&tasks=' + str
}

// First display
select_all.select_all.onclick = () => selectAll(select_all)
for (let i = 0; i < select_all.checkbox.length; i++) {
  select_all.checkbox[i].onclick = manageCheckbox
}

select_all.trash.onclick = () => {
  if (permissions == 0) {
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
      if (select_all2.checkbox[i].classList.contains('active') &&
        !select_all2.checkbox[i].classList.contains('category-check') &&
        getTaskCategory(select_all2.checkbox[i]) === category) {
        select_all2.checkbox[i].checked = c_checkbox.checked
      }
    }

    let all_categories_checked = true
    for (let i = 0; i < select_all2.categories.length; i++) {
      if (!select_all2.categories[i].checked) all_categories_checked = false
    }
    select_all2.select_all.checked = all_categories_checked

    select_all2.trash.style.display = c_checkbox.checked ? "inline-block" : "none";
  }
}
select_all2.trash.onclick = () => {
  if (permissions == 0) {
    const err = new Message('error', 'Action refusée...', "Vous n'avez pas l'autorisation de supprimer une ou plusieurs tâches.")
    err.show()
    return;
  }
  select_all.nb_tasks.innerText = getTasksToDelete2().length
  modals.show(select_all.delete_task)
  select_all.yes_task.onclick = () => deleteTasks(getTasksToDelete2())
}

function deleteTask(id) {
  if (permissions == 0) {
    const err = new Message('error', 'Action refusée...', "Vous n'avez pas l'autorisation de supprimer une tâche.")
    err.show()
    return;
  }
  select_all.nb_tasks.innerText = 1
  select_all.yes_task.onclick = () => window.location.search = '?action=deleteTasks&tasks=' + id
  modals.show(select_all.delete_task)
}

/**
 * Show a specific element
 * @param  {DOM element} element Element to show
 */
function show(element) {
  element.style.display = "flex";
}

/**
 * Hide a specific element
 * @param  {DOM element} element Element to hide
 */
function hide(element) {
  element.style.display = "none";
}

/**
 * Check if a value is contained in a specific array
 * @param  {Array} array Array to analyse
 * @param  {various} value Value to check
 * @return {Boolean}
 */
function contain(array, value) {
  let r = false;
  for (let i = 0; i < array.length; i++) {
    if (array[i] === value) r = true;
  }
  return r;
}

/**
 * Check if a DOM element has a class which contains the string 'classe'
 * @param {DOMTokenList} classList The DOM classList
 * @param {String} classe The string to test
 * @return {String} The matched class (null if nothing is found)
 */
function classContains(classList, classe){
    let r = null
    classList.forEach((item) => {
        if(item.indexOf(classe) !== -1) r = item
    })
    return r
}
