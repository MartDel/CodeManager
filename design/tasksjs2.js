var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];
var checkbox = document.getElementsByClassName("input_img");

/*

Si tu veux écrire tes fonction avec des technologies plus récentes tu peux les noter :

var nomDeMaFonction = (arg1, arg2) => {
    mon code...
}

Au lieu de :

function nomDeMaFonction(arg1, arg2){
    mon code...
}

Ca s'appelle ECMAScript et c'est plus conseillé si tu veux être "à la page" :)

 */

btn.onclick = () => {
  modal.style.display = "block";
}

span.onclick = () => {
  modal.style.display = "none";
}

window.onclick = (event) => {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
