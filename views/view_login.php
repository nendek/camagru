<?php
session_start();
$this->title = 'Camagru-login';
?>
<div class="title">LOGIN</div>
	<form method="post" action="../index.php?action=login">
		<label for="form-username">Username:</label>
		<input id="form-username" name="username" placeholder="your username" maxlength="50" minlength="2" type="text">
		<label for="form-passwd">Password:</label>
		<input id="form-passwd" name="passwd" placeholder="your password" maxlength="50" minlength="6" type="password">
		<input name="submit" id="form-submit" type="submit" value="OK">
	</form>
<?php
if (isset($_SESSION['error'])) {
	echo $_SESSION['error'];
	$_SESSION['error'] = null;
}
?>
