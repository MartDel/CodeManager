$("form").submit(function (e){
    const $passwords = $("input[type='password']")
    if($passwords.length === 2 && $passwords[0].value !== $passwords[1].value){
        e.preventDefault()
        const err = new Message('error', 'Oups !', 'Les 2 mots de passe saisis sont différents.')
        err.dynamic = focusPassword
        err.show()
    }
})
