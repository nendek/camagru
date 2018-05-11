function parseTexte(e) {
	var texte = document.getElementById(e.target.id);
	if (texte.value.length < 2 || texte.value.length > 50) {
		texte.style.borderColor = "red";
		return (true);
	} else {
		texte.style.borderColor = "green";
		return (false);
	}
}

function parsePassword(e) {
	var texte = document.getElementById(e.target.id);
	if (texte.value.length < 2 || texte.value.length > 50) {
		texte.style.borderColor = "red";
		return (true);
	} else {
		texte.style.borderColor = "green";
		return (false);
	}
}

function parseMail(e) {
	var texte = document.getElementById(e.target.id);
	//var patt = new RegExp("/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/");
	var patt = new RegExp("a");

	alert(texte);
	if (patt.test(texte)) {
		texte.style.borderColor = "green";
		return (true);
	} else {
		texte.style.borderColor = "red";
		return (false);
	}



	/*if (texte.value.length < 2 || texte.value.length > 50) {
	  texte.style.borderColor = "red";
	  return (true);
	  } else {
	  texte.style.borderColor = "green";
	  return (false);
	  }*/
}

document.querySelectorAll('form input[type="text"]').forEach(function(inp){
	inp.addEventListener("focusout", parseTexte);
});

document.querySelector('#form-passwd').addEventListener("focusout", parsePassword);
document.querySelector('#form-passwd-conf').addEventListener("focusout", parsePassword);
document.querySelector('#form-email').addEventListener("focusout", parseMail);

document.querySelector("#form-submit").addEventListener("click",function(){
	var lastname = document.queryselector("#form-lastname");
	if (lastname.value == "")
	{
		var errors = [];
		event.preventDefault();
		if (lastname.value == "")
			errors.push("Il manque ton nom de famille");
		errors.push("Il manque ton nom 2");
		errors.push("Il manque ton nom de famill 324234 e");
		errors.push("Il manque ton nom de famill 4324243e");
		var error_div = document.queryselector("#errors");
		errors.foreach(function(error){
			var newelem = document.createElement("p");
			newelem.className += "erreur";
			newelem.innerHTML = error;
			error_div.appendChild(newelem);
		});
	}
});
