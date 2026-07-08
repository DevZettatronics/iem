function validar() {

var nombre = document.getElementById("nombre_id");
var tel = document.getElementById("telefono_id");
var email = document.getElementById("correo_id");
var comenta = document.getElementById("comentarios_id");

if(nombre.value== "" || nombre.value== null) {
alert("Falta ingresar tu nombre");
document.getElementById("nombre_id").focus();
return false;
}else if(tel.value== "" || tel.value== null) {
alert("Falta ingresar tu teléfono");
document.getElementById("telefono_id").focus();
return false;
}else if ((email.value == "") || 
    //Si no contiene un arroba 
    (email.value.indexOf('@') == -1) || 
    //o un punto 
    (email.value.indexOf('.') == -1)) { 
     //lo informamos. 
    alert ("Falta el correo electrónico o se encuentra incompleto");
	document.getElementById("correo_id").focus();
	return false;
} 

}

function SoloNum() {
 if ((event.keyCode < 48) || (event.keyCode > 57)) 
  event.returnValue = false;
}