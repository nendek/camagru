function alphanumeric(inputtxt) {
	var patt = new RegExp(/^[0-9a-zA-Z]+$/);

	if(patt.test(inputtxt)) {
		return true;
	} else { 
		return false; 
	}
}

function alpha(inputtxt) {
	var patt = new RegExp(/^[a-zA-Z]+$/);

	if(patt.test(inputtxt)) {
		return true;
	} else { 
		return false; 
	}
}

function validateMail(inputtxt) {
	var patt = new RegExp(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);

	if(patt.test(inputtxt)) {
		return true;
	} else { 
		return false; 
	}
}

function parseTexte(e) {
	var texte = document.getElementById(e.target.id);
	if (texte.value.length < 2 || texte.value.length > 50 || !alpha(texte.value)) {
		texte.style.borderColor = "red";
		return (false);
	} else {
		texte.style.borderColor = "green";
		return (true);
	}
}

function parsePassword(e) {
	var texte = document.getElementById(e.target.id);
	if (texte.value.length < 2 || texte.value.length > 50 || !alphanumeric(texte.value)) {
		texte.style.borderColor = "red";
		return (false);
	} else {
		texte.style.borderColor = "green";
		return (true);
	}
}

function parseMail(e) {
	var texte = document.getElementById(e.target.id);

	if (!(texte.value.length < 2 || texte.value.length > 50 || !validateMail(texte.value))) {
		texte.style.borderColor = "green";
		return (true);
	} else {
		texte.style.borderColor = "red";
		return (false);
	}
}
function validateForm() {
	var errors = [];

	if (document.forms["form"]["firstname"]) {
		var firstname = document.forms["form"]["firstname"].value;

		if (firstname == "" || firstname.length < 2 || firstname.length > 50 || !alpha(firstname)) {
			errors.push("<p>The first name must be between 2 and 50 characters and contain only alphabetic characters</p>");
		}
	}
	if (document.forms["form"]["lastname"]) {
		var lastname = document.forms["form"]["lastname"].value;

		if (lastname == "" || lastname.length < 2 || lastname.length > 50 || !alpha(lastname)) {
			errors.push("<p>The last name must be between 2 and 50 characters and contain only alphabetic characters</p>");
		}
	}
	if (document.forms["form"]["email"]) { 
		var email = document.forms["form"]["email"].value;

		if (email == "" || !validateMail(email)) {
			errors.push("<p>The email not valid</p>");
		}
	}
	if (document.forms["form"]["username"]) {
		var username = document.forms["form"]["username"].value;

		if (username == "" || username.length < 2 || username.length > 50 || !alpha(username)) {
			errors.push("<p>The username must be between 2 and 50 characters and contain only alphabetic characters</p>");
		}
	}
	if (document.forms["form"]["passwd"]) {
		var passwd = document.forms["form"]["passwd"].value;

		if (passwd == "" || passwd.length < 2 || passwd.length > 50 || !alphanumeric(passwd)) {
			errors.push("<p>The password must be between 2 and 50 characters and contain only alphanumeric characters</p>");
		}
	}
	if (document.forms["form"]["passwd_conf"]) {
		var passwd_conf = document.forms["form"]["passwd_conf"].value;

		if (passwd != passwd_conf) {
			errors.push("<p>The two passwords are different</p>");
		}
	}
	if (typeof errors !== 'undefined' && errors.length > 0) {
		var data = "";
		errors.forEach(function (element) {
			console.log(element);
			data += element;
		});
		document.getElementById("errors").innerHTML = data;
		return false;
	}
};

if (document.querySelectorAll('form input[type="text"]')) {
	document.querySelectorAll('form input[type="text"]').forEach(function(inp){
		inp.addEventListener("focusout", parseTexte);
	});
};

if (document.querySelector('#form-passwd')) {
	document.querySelector('#form-passwd').addEventListener("focusout", parsePassword);
};

if (document.querySelector('#form-passwd-conf')) {
	document.querySelector('#form-passwd-conf').addEventListener("focusout", parsePassword);
};

if (document.querySelector('#form-email')) {
	document.querySelector('#form-email').addEventListener("focusout", parseMail);
};
