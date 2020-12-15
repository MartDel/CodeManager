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
        const $mess = $('#message')
        $mess.addClass('show-' + this.type)
        $mess.find('#title').text(this.title)
        $mess.find('#content').text(this.content)
        $mess.find('#close_message').click(this.close)

        // Dynamic button
        if(this.dynamic){
            const $btn = $mess.find('#action')
            $btn.find('#icon').attr('name', this.btn2)
            $btn.css('display', 'flex')
            $btn[0].onclick = () => {
                this.close()
                if(this.arg) setTimeout(() => this.dynamic(this.arg), 1000)
                else setTimeout(this.dynamic, 1000)
            }
        }

        setTimeout(this.close, 4000)

        window.cmessage = $mess
        window.ctype = this.type
    }

    close(){
        const $cmessage = window.cmessage
        if(!$cmessage) return
        $cmessage.addClass('hide')
        setTimeout(() => {
            $cmessage.removeClass('show-' + window.ctype)
            $cmessage.removeClass('hide')
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
