<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Student++</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.scss">

	 <link href="https://fonts.googleapis.com/css?family=Bungee+Shade|Just+Another+Hand|Montserrat|Rajdhani&display=swap" rel="stylesheet">    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>

	<div id="header">
		<h1 id="naslov">Student++</h1> <br>
		<?php 
		//ako nitko nije logiran, ponudi login i registraciju
		if($who === false) { 
		?>	
			<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=index/check_button_choice" >
				<button id="login" type="submit" name="login" class="log_reg_button" >Prijava</button>
				<button id="register" type="submit" name="register" class="log_reg_button">Registracija</button>
			</form> 
			<br><br>

		<?php }

		//ako je netko logiran, ponudi logout
		if( $who !== false ){ 
			if( $who === 'student' ){
			?>
				<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/logout">
					<button id="logout" type="submit" name="logout" class="log_reg_button">Odjava</button>
				</form>	
			<?php			
			}
			else if( $who === 'company' ){
			?>
				<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/logout">
					<button id="logout" type="submit" name="logout" class="log_reg_button">Odjava</button>
				</form>
				<br><br>
			<?php
			}
			?>
		<?php 
		} ?>

	</div>

	<script type="text/javascript">
		$("document").ready(function() {
			var v = window.innerWidth;
			v *= 0.75;
			v /= 2;
			$("#logout").css("margin-left", v-80);
			v -= 190;
			$("#login").css("margin-left", v);
			

			$(window).resize(function() {
				var v = window.innerWidth;
				v *= 0.75;
				v /= 2;
				$("#logout").css("margin-left", v-80);
				v -= 190;
				$("#login").css("margin-left", v);
			});
			
		} )
	</script>
