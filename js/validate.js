var errori_presenti = 0;
function checkPassword(str){
    var re = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    return re.test(str);
}

function checkMail(str){
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(str);
}
function checkImgPath(path) { 
  var re = /(?:\.([^.]+))?$/;
  var ext = re.exec(path)[1];
  if (ext == "jpg" || ext == "jpeg" || ext == "png") {
    return true;
  }
  return false;
}
var accentedCharacters = "àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ";
var re_name = new RegExp("^[a-zA-Z" + accentedCharacters + " ]{1,30}$");
var re_date = /^(\d{4})-(\d{2})-(\d{2})$/;
//regex that accept only letters and accetuated characters

function validateAddDead(){
  if (!validateName("nome")){
    return false;
  } else if (!validateName("cognome")) {
    return false;
  } else if (!validateDate("born_d")) {
    return false;
  } else if (!validateDate("death_d","born_d")) {
    return false;
  } else if (!validatePATH("img-add")) {
    return false;
  }
  return true;
}
function validateEditDead(){
  if (!validateName("name")){
    return false;
  } else if (!validateName("surname")) {
    return false;
  } else if (!validateDate("born_date")) {
    return false;
  } else if (!validateDate("death_date","born_date")) {
    return false;
  }
  return true;
}
function validateRegister(){
  if (!validateEmail()){
    return false;
  } else if (!validateUsername()) {
    return false;
  } else if (!validatePassword()) {
    return false;
  } else if (!validateSecondPassword()) {
    return false;
  }
  return true;
}
function validateLogin(){
  if (!validateUsername()){
    return false;
  } else if (!validatePassword()){
    return false;
  }
  return true;
}
function editUsername(){
  if (validateUsername()){
    return true;
  }
  return false;
}
function validateUsername(){
  var x = document.getElementById("username");
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  var username_pattern = /^[\w]{1,40}$/;
  if (!username_pattern.test(x.value)) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Devi inserire un nome utente");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 255) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("L'username deve essere lungo al massimo 255 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}
function validatePassword(){
  var x = document.getElementById("password");
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  if (x.value == "") {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Devi inserire una password");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 255) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("La password deve essere lunga al massimo 255 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}
function validateEmail(){
  var x = document.getElementById("email");
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  if (x.value == "") {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Devi inserire un'email");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (!checkMail(x.value)) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Email non valida");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 255) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("L'email deve essere lunga al massimo 255 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}
function validateSecondPassword(){
  var x = document.getElementById("password1");
  var x2 = document.getElementById("password");
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  if (x.value != x2.value) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Le password non coincidono");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 255) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("La password deve essere lunga al massimo 255 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}
function validateName(id){
  let x = document.getElementById(id);
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  if (!re_name.test(x.value)) {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Il campo può contenere solo lettere e spazi e deve essere lungo almeno 1 carattere");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 255) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Il nome deve essere lungo al massimo 255 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}
function validateDate(id, id2){
  let x = document.getElementById(id);
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  if (!re_date.test(x.value)) {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("La data deve essere nel formato gg/mm/aaaa");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (id2 != null){
    let x2 = document.getElementById(id2);
    if (x2.value > x.value) {
      if (x.parentElement.childNodes.length < 2) {
        const textnode = document.createTextNode("La data di morte deve essere precedente a quella di nascita");
        node.appendChild(textnode);
        x.parentElement.append(node);
      }
      return false;
    } else if (x.parentElement.childNodes.length > 1) {
      x.parentElement.removeChild(x.parentElement.lastChild);
    }
  }
  return true;
}
function validatePATH(id){
  let x = document.getElementById(id);
  const node = document.createElement("p");
  node.classList.add("error-label");
  node.setAttribute("role", "alert");
  if (x.value == "") {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("Inserisci un percorso valido");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (!checkImgPath(x.value)) {
    if (x.parentElement.childNodes.length < 2) {
      const textnode = document.createTextNode("L'immagine deve essere in formato jpg, jpeg o png");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false; 
   } else if (x.parentElement.childNodes.length > 1) {
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  if (x.value.length > 255) {
    if (x.parentElement.childNodes.length < 2){
      const textnode = document.createTextNode("Il PATH deve essere lungo al massimo 255 caratteri");
      node.appendChild(textnode);
      x.parentElement.append(node);
    }
    return false;
  } else if (x.parentElement.childNodes.length > 1){
    x.parentElement.removeChild(x.parentElement.lastChild);
  }
  return true;
}

