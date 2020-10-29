// Find all of inputs
let inputs_type = {
    password: null,
    mail: null
}
const inputs = document.getElementsByTagName('input')
for (let i = 0; i < inputs.length; i++) {
    if(inputs[i].type === 'submit') submit = inputs[i]
}

// submit.onclick = (event) => {
//
// }
