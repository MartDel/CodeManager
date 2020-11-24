function checkMessage(){
    const search = window.location.search
    const params = new URLSearchParams(search)
    try {
        if(params.has('error') || params.has('info')){
            let type;
            if(params.has('info')) type = 'info'
            else type = 'error'
            const title = params.get('title')
            const message = params.get('message')
            const msg = new Message(type, title, message)
            if(params.has('callback_name')) msg.dynamic = window[params.get('callback_name')]
            if(params.has('btn')) msg.btn2 = params.get('btn')
            if(params.has('arg')) msg.arg = params.get('arg')
            msg.show()
        }
    } catch (e) {
        console.log("Format d'erreur inconnu");
        console.log(e);
    }
}

/*
 * Functions
 */

/**
 * Focus an input
 * @param  {String} key Input param to check
 * @param  {String} value Value of the input param
 */
function focusInput(key, value){
    const inputs = document.getElementsByTagName('input')
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i][key] === value) {
            inputs[i].focus()
            break
        }
    }
}

function focusEmptyInput(){ focusInput('value', '') }
function focusPassword(){ focusInput('type', 'password') }
function focusEmail(){ focusInput('type', 'email') }

function openEditAccount(){ modals.show(project.id) }
function openAddUserModal(){ modals.show(add.id) }

function focusTitleAddTask() {
    modals.show(addtask.id)
    setTimeout(() => document.querySelector('#addtask_title').focus(), 1000)
}

function focusNameCreateProject(){
    modals.show(project.id)
    setTimeout(() => document.querySelector('#new_project_name').focus(), 1000)
}

function addUser(email){ window.location.search = '?action=addUserToTeam&mail=' + encodeURIComponent(email) }
function openPhpMyAdmin(){ window.open("http://localhost:80/phpmyadmin", "_blank") }
