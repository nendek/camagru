<?php
session_start();
$title = 'Camagru-validation';
ob_start();
?>
<div class="title">VALIDATION</div>
<?php
if (isset($_SESSION['error']))
{
?>
<span><?=$_SESSION['error']?></span>
<?php
} else {
?>
<span>Validation success, welcom to CAMAGRU</span>;
<?php
}
$contents = ob_get_clean();
require 'template.php';
?>
