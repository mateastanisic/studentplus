<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Student++</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<link rel="icon" href="data:;base64,iVBORw0KGgo=">
	<!--<link rel="icon" href="data:;base64,=">
	 <link rel="shortcut icon" href="/home/tihana/public_html/studentplus-master/view/favicon/favicon.ico">
	<link rel="icon" type="image/gif" href="/home/tihana/public_html/studentplus-master/view/favicon/animated_favicon1.gif">-->
</head>
<body>

<?php 
//ako nitko nije logiran, ponudi login i registraciju
if(!isset($_SESSION['login'])) { 
?>
	<p id="p_header">Tražiš ili nudiš praksu?</p>

	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=index/check_button_choice">
		<button id="login" type="submit" name="login">Log in!</button>
		<button id="register" type="submit" name="register">Register!</button>
	</form> 

<?php }

//ako je netko logiran, ponudi logout
if (isset($_SESSION['login'])) {

	if ($student !== null) { ?>
	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/logout">
		<button id="logout" type="submit" name="logout">Log out</button>
	</form>
<?php } 
	
	else if ($company_logged !== null) { ?>
		<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/logout">
		<button id="logout" type="submit" name="logout">Log out</button>
	</form>
	}


}
