function checkMessage(){
    const search = window.location.search
    const params = new URLSearchParams(search)
    if(params.has('error')){
        try {
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
        } catch (e) {
            console.log("Format d'erreur inconnu");
            console.log(e);
        }
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
    // Focus sur le champ title
}

function focusNameCreateProject(){
    modals.show(project.id)
    // Focus sur le champ name
}

function openPhpMyAdmin(){
    window.open("http://localhost:80/phpmyadmin", "_blank")
}
