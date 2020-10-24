let cmodal = null

function showTemplateModal(id){
    const modal = document.getElementById(id)
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

const modals = new Vue({
    el: '#modals',
    components: {
        modal: {
            template: `
            <aside class="modal" aria-hidden="true" role="dialog" aria-modal="false" style="display: none;">
                <div class="modal-wrapper">
                    <slot></slot>
                </div>
            </aside>`
        }
    },
    methods: {
        show(id){ showTemplateModal(id) }
    }
})
