<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Camagru-signup</title>
</head>
<body>
	<div class="title">SIGNUP</div>
	<form method="post" action="create_acc.php">
		<label for="form-lastname">Lastname:</label>
		<input id="form-lastname" name="lastname" placeholder="your lastname" maxlength="50" type="text">
		<label for="form-firstname">Firstname:</label>
		<input id="form-firstname" name="firstname" placeholder="your firstname" maxlength="50" type="text">
		<label for="form-email">Email:</label>
		<input id="form-email" name="email" placeholder="your email" maxlength="50" type="mail">
		<label for="form-username">Username:</label>
		<input id="form-username" name="username" placeholder="your username" maxlength="50" type="text">
		<label for="form-passwd">Password:</label>
		<input id="form-passwd" name="passwd" placeholder="your password" maxlength="50" minlength="6" type="password">
		<input name"submit" id="form-submit" type="submit" value="OK">
	</form>
</body>
</html>
