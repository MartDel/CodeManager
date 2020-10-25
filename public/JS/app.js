window.onload = () => {
    document.querySelector('#modals').style.display = 'block'
}

function testModal(){
    modals.show('test1')
}

function error(){
    showMessage('error', 'test', 'yoooo', () => alert('yo'))
}

function info(){
    showMessage('info', 'test', 'yoooo', () => alert('yo'))
}
