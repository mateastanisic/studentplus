<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Student++</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>

	<div id="header">
		<h1 id="naslov"> Student++ </h1>
		<?php 
		//ako nitko nije logiran, ponudi login i registraciju
		if($who === false) { 
		?>
			<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=index/check_button_choice">
				<button id="login" type="submit" name="login">Log in!</button>
				<button id="register" type="submit" name="register">Register!</button>
			</form> 

			<br><br>

		<?php }

		//ako je netko logiran, ponudi logout
		if( $who !== false ){ 
			if( $who === 'student' ){
			?>
				<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/logout">
					<button id="logout" type="submit" name="logout">Log out student</button>
				</form>	
			<?php			
			}
			else if( $who === 'company' ){
			?>
				<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/logout">
					<button id="logout" type="submit" name="logout">Log out tvrtka</button>
				</form>
			<?php
			}
			?>
		<?php 
		} ?>

	</div>
