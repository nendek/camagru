<?php
session_start();
$title = 'Camagru-signup';
ob_start();
?>
	<div class="title">SIGNUP</div>
	<form method="post" action="../index.php?action=signup">
<label for="form-firstname">Firstname:</label>
		<input id="form-firstname" name="firstname" placeholder="your firstname" maxlength="50" type="text">

		<label for="form-lastname">Lastname:</label>
		<input id="form-lastname" name="lastname" placeholder="your lastname" maxlength="50" type="text">
				<label for="form-email">Email:</label>
		<input id="form-email" name="email" placeholder="your email" maxlength="50" type="mail">
		<label for="form-username">Username:</label>
		<input id="form-username" name="username" placeholder="your username" maxlength="50" minlength="2" type="text">
		<label for="form-passwd">Password:</label>
		<input id="form-passwd" name="passwd" placeholder="your password" maxlength="50" minlength="6" type="password">
		<label for="form-passwd-conf">Password:</label>
		<input id="form-passwd-conf" name="passwd_conf" placeholder="confirm your password" maxlength="50" minlength="6" type="password">
		<input name="submit" id="form-submit" type="submit" value="OK">
	</form>
	<div id="errors"></div>

<script>

function parseTexte(e) {
	console.log(e.target.id);
	var texte = document.getElementById(e.target.id);
	if (texte.value.length < 2 || texte.value.length > 50) {
		texte.style.borderColor = "red";
		return (1);
	} else {
		texte.style.borderColor = "green";
		return (0);
	}
}

document.querySelectorAll('form input[type="text"]').forEach(function(inp){
	inp.addEventListener("focusout", parseTexte);
});

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

</script>

<?php
if (isset($_SESSION['error'])) {
	echo $_SESSION['error'];
	$_SESSION['error'] = null;
}
?>
<?php $contents = ob_get_clean(); ?>
<?php require 'template.php'; ?>
