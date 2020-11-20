function checkMessage(){
    const search = window.location.search
    const params = new URLSearchParams(search)
    try {
        if(params.has('error')){
            const error = params.get('error').split('+')
            let info = {
                title: error[0],
                message: error[1],
                file: error[2],
                line: error[3],
                callback: null
            }
            if(error[4] && error[4] !== ''){
                info.callback = window[error[4]]
            }
            showMessage('error', info.title, info.message, info.callback)
        } else if (params.has('info')) {
            const infos = params.get('error').split('+')
            const title = infos[0]
            const message = infos[1]
            showMessage('info', title, message)
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

function focusEmptyInput(){
    focusInput('value', '')
}

function focusPassword(){
    focusInput('type', 'password')
}

function focusEmail(){
    focusInput('type', 'email')
}

function focusTitleAddTask() {
    modals.show(addtask.id)
    setTimeout(() => document.querySelector('#addtask_title').focus(), 1000)
}

function focusNameCreateProject(){
    modals.show(project.id)
    setTimeout(() => document.querySelector('#new_project_name').focus(), 1000)
}

function openPhpMyAdmin(){
    window.open("http://localhost:80/phpmyadmin", "_blank")
}
