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

            // Clear url
            setURLParams(params.has('action') ? 'action=' + params.get('action') : '')
        }
    } catch (e) {
        console.log("Format d'erreur inconnu");
        console.error(e);
    }
}

/*
 * Functions
 */

function focusEmptyInput(){ $("input:first").focus() }
function focusPassword(){ $("input[type='password']:first").focus() }
function focusEmail(){ $("input[type='email']:first").focus() }

function openEditAccount(){ modals.show(project.id) }
function openAddUserModal(){ modals.show(add.id) }

function focusTitleAddTask() {
    modals.show(addtask.id)
    setTimeout(() => $('#addtask_title').focus(), 1000)
}

function focusNameCreateProject(){
    modals.show(project.id)
    setTimeout(() => $('#new_project_name').focus(), 1000)
}

function addUser(email){ window.location.search = '?action=addUserToTeam&mail=' + encodeURIComponent(email) }
