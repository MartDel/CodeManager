let cmessage = null
let ctype = null

function showMessage(type, title, content, dynamic){
    ctype = type === 'info' ? type : 'error'
    console.log(ctype);
    const mess = document.getElementById('message')
    mess.classList.add('show-' + ctype)
    mess.querySelector('#title').innerHTML = title
    mess.querySelector('#content').innerHTML = content
    mess.querySelector('#close_message').onclick = closeMessage

    // Dynamic button
    if(dynamic){
        const btn = mess.querySelector('#action')
        btn.style.display = 'block'
        btn.onclick = () => {
            closeMessage()
            dynamic()
        }
    }

    window.cmessage = mess
    window.ctype = ctype
}

function closeMessage(){
    const cmessage = window.cmessage
    if(!cmessage) return
    cmessage.classList.add('hide')
    setTimeout(() => {
        cmessage.classList.remove('show-' + ctype)
        cmessage.classList.remove('hide')
    }, 1000)
    window.cmessage = null
}
