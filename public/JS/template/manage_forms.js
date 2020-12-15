$("form").submit(function (e){
    const $passwords = $("input[type='password']")
    e.preventDefault()
    if($passwords.length === 2 && $passwords[0].value !== $passwords[1].value){
        const err = new Message('error', 'Oups !', 'Les 2 mots de passe saisis sont différents.')
        err.dynamic = focusPassword
        err.show()
    }
})
