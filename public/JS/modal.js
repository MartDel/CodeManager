function show(id){
    const modal = document.getElementById(id)
    modal.style.display = null
    modal.removeAttribute('aria-hidden')
    modal.setAttribute('aria-modal', 'true')
    window.cmodal = modal
    window.cmodal.addEventListener('click', close)
    window.cmodal.querySelector('.close-modal').addEventListener('click', close)
    window.cmodal.querySelector('.modal-wrapper').addEventListener('click', (e) => { e.stopPropagation() })
}

function close(e){
    const cmodal = window.cmodal
    if(!cmodal) return
    e.preventDefault()
    cmodal.setAttribute('aria-hidden', 'true')
    cmodal.removeAttribute('aria-modal')
    cmodal.removeEventListener('click', close)
    cmodal.querySelector('.modal-wrapper').removeEventListener('click', (e) => { e.stopPropagation() })
    cmodal.querySelector('.close-modal').removeEventListener('click', (e) => { e.stopPropagation() })
    cmodal.addEventListener('animationend', hide)
}

function hide(){
    const cmodal = window.cmodal
    cmodal.style.display = 'none'
    cmodal.removeEventListener('animationend', hide)
    window.cmodal = null
}

window.addEventListener('keydown', (e) => {
    if(e.key === "Escape" || e.key === "Esc") close(e)
})

// class Modal {
//     constructor(id) {
//         this.id = id
//     }
//
//     show(){
//         const modal = document.getElementById(this.id)
//         modal.style.display = null
//         modal.removeAttribute('aria-hidden')
//         modal.setAttribute('aria-modal', 'true')
//         window.cmodal = modal
//         window.cmodal.addEventListener('click', this.close)
//         window.cmodal.querySelector('.close_modal').addEventListener('click', this.close)
//         window.cmodal.querySelector('#modal_main').addEventListener('click', (e) => { e.stopPropagation() })
//         window.addEventListener('keydown', (e) => {
//             if(e.key === "Escape" || e.key === "Esc") this.close(e)
//         })
//     }
//
//     close(e){
//         const cmodal = window.cmodal
//         if(!cmodal) return
//         e.preventDefault()
//         cmodal.setAttribute('aria-hidden', 'true')
//         cmodal.removeAttribute('aria-modal')
//         cmodal.removeEventListener('click', cmodal.close)
//         cmodal.querySelector('#modal_main').removeEventListener('click', (e) => { e.stopPropagation() })
//         cmodal.querySelector('.close_modal').removeEventListener('click', (e) => { e.stopPropagation() })
//         cmodal.addEventListener('animationend', cmodal.hide)
//     }
//     hide(){
//         const cmodal = window.cmodal
//         cmodal.style.display = 'none'
//         cmodal.removeEventListener('animationend', cmodal.hide)
//         window.cmodal = null
//     }
// }
