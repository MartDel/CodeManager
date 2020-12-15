let cmessage = null
let ctype = null

class Message {
    constructor(type, title, content) {
        this.type = type === 'info' ? type : 'error'
        this.title = title
        this.content = content
        this.dynamic = null
        this.btn2 = 'eye'
        this.arg = null
    }

    show(){
        const mess = document.getElementById('message')
        mess.classList.add('show-' + this.type)
        mess.querySelector('#title').innerHTML = this.title
        mess.querySelector('#content').innerHTML = this.content
        mess.querySelector('#close_message').onclick = this.close

        // Dynamic button
        if(this.dynamic){
            const btn = mess.querySelector('#action')
            btn.style.display = 'flex'
            btn.querySelector('#icon').name = this.btn2
            btn.onclick = () => {
                this.close()
                if(this.arg) setTimeout(() => this.dynamic(this.arg), 1000)
                else setTimeout(this.dynamic, 1000)
            }
        }

        setTimeout(this.close, 4000)

        window.cmessage = mess
        window.ctype = this.type
    }

    close(){
        const cmessage = window.cmessage
        if(!cmessage) return
        cmessage.classList.add('hide')
        setTimeout(() => {
            cmessage.classList.remove('show-' + window.ctype)
            cmessage.classList.remove('hide')
        }, 500)
        window.cmessage = null
    }
}

/**
 * Change Url without reloading
 * @param {String} params Url params
 */
function setURLParams(params){
    // Get file name
    let file_name = null
    const path = window.location.pathname.split('/')
    path.forEach((item, i) => {
        if(i === path.length-1) file_name = item
    })

    const obj = {
        title: document.title,
        url: file_name + '?' + params
    }
    history.pushState(obj, obj.title, obj.url)
}
