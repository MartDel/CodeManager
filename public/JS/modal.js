function showTemplateModal(el){
    const modal = document.getElementById(el.id)
    modal.style.display = null
    modal.removeAttribute('aria-hidden')
    modal.setAttribute('aria-modal', 'true')
    window.cmodal = modal
    window.cmodal.addEventListener('click', closeTemplateModal)
    window.cmodal.querySelector('.close-modal').addEventListener('click', closeTemplateModal)
    window.cmodal.querySelector('.modal-wrapper').addEventListener('click', (e) => { e.stopPropagation() })
}

function closeTemplateModal(e){
    const cmodal = window.cmodal
    if(!cmodal) return
    e.preventDefault()
    cmodal.setAttribute('aria-hidden', 'true')
    cmodal.removeAttribute('aria-modal')
    cmodal.removeEventListener('click', closeTemplateModal)
    cmodal.querySelector('.modal-wrapper').removeEventListener('click', (e) => { e.stopPropagation() })
    cmodal.querySelector('.close-modal').removeEventListener('click', (e) => { e.stopPropagation() })
    cmodal.addEventListener('animationend', hideTemplateModal)
}

function hideTemplateModal(){
    const cmodal = window.cmodal
    cmodal.style.display = 'none'
    cmodal.removeEventListener('animationend', hideTemplateModal)
    window.cmodal = null
}

window.addEventListener('keydown', (e) => {
    if(e.key === "Escape" || e.key === "Esc") closeTemplateModal(e)
})
