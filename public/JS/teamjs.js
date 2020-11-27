const add ={
  id:"add",
  button:document.getElementById("new_user_img"),
}

window.onload = () => {
    // Menu/nav onload function and check if there is a message to print
    wOnload()
    checkMessage()
};


add.button.onclick=()=>{
    if(permissions == 2) modals.show(add.id)
    else{
        const err = new Message('error', 'Action refusée...', "Vous n'avez pas l'autorisation nécessaire pour ajouter un utilisateurà l'équipe.")
        err.show()
    }
}
