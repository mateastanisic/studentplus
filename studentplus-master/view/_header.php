<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Student++</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>

<?php 
//ako nitko nije logiran, ponudi login i registraciju
if(!isset($_SESSION['login']) && !isset($_SESSION['checked'])) { 
?>
	<p id="p_header">Tražiš ili nudiš praksu?</p>

	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=index/check_button_choice">
		<button id="login" type="submit" name="login">Log in!</button>
		<button id="register" type="submit" name="register">Register!</button>
	</form> 

	<br><br>

<?php }

//ako je netko logiran, ponudi logout
if (isset($_SESSION['login'])) { ?>

	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/logout">
		<button id="logout" type="submit" name="logout">Log out student</button>
	</form>
	
	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/logout">
		<button id="logout" type="submit" name="logout">Log out tvrtka</button>
	</form>
	<br><br>

<?php } ?>
