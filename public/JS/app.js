function test(){
    modals.show('test1')
}

function test2(){ modals.show('test2') }

window.onload = () => {
    document.querySelector('#modals').style.display = 'block'
}
