let add ={
  id:"add",
  button:document.getElementById("new_user_img"),
}

window.onload = () => {
    // Menu/nav onload function and check if there is a message to print
    wOnload()
    checkMessage()
};


add.button.onclick=()=>{
  modals.show(add.id)
}
