// Find all of inputs
let fields = {
    password: [],
    mail: [],
    submit: null
}
const inputs = document.getElementsByTagName('input')
for (let i = 0; i < inputs.length; i++) {
    switch (inputs[i].type) {
        case 'password':
            fields.password.push(inputs[i])
            break;
        case 'email':
            if(!inputs[i].placeholder.toLowerCase().includes('pseudo')) fields.mail.push(inputs[i])
            break;
        case 'submit':
            fields.submit = inputs[i]
            break;
    }
}

fields.submit.onclick = (event) => {
    if(fields.password.length == 2 && fields.password[0].value !== fields.password[1].value){
        event.preventDefault()
        showMessage('error', 'Mots de passe différents', 'Les 2 mots de passe saisis sont différents. Veuillez les resaisir.', focusPassword)
    }
    if(fields.mail.length > 0){
        let wrong_mail = false
        const regex = /\S+@\S+\.\S+/
        for (let i = 0; i < fields.mail.length; i++) {
            if(!regex.test(fields.mail[i])) wrong_mail = true
        }
        if(wrong_mail){
            event.preventDefault()
            showMessage('error', 'E-mail incorrect', "Le format de l'addrese e-mail n'est pas correct. Veuillez la resaisir.", focusEmail)
        }
    }
}
