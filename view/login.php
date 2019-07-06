<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=index/check_login_type">

	<p>Student ili tvrtka?</p><br>

	<input type="radio" name="odabir" value="student" id="student">Student</input>
	<input type="radio" name="odabir" value="company" id="company">Tvrtka</input>

</form>

<div id="log_student">
	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/check_login">

		Username: <input type="text" name="username" />
		Password: <input type="Password" name="pass" />
		<button type="submit" name="posalji">Log in</button>
	</form>
</div>

<div id="log_company">
	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_login">
		
		OIB: <input type="text" name="oib" />
		Password: <input type="Password" name="pass" />
		<button type="submit" name="posalji">Log in</button>
	</form>
</div>


<script type="text/javascript">
//Kada odaberemo jesmo li student ili tvrtka, pokazuje se forma za login za odgovarajuc odabir
$("document").ready(function() {
	$("#log_student").hide();
	$("#log_company").hide();

	$('input:radio[name="odabir"]').change( function() {
		if( document.getElementById("student").checked ) {
			$("#log_company").hide();
			$("#log_student").show();
		}
		else if( document.getElementById("company").checked ) {
			$("#log_student").hide();
			$("#log_company").show();
		}
	});
	$('#header').on( "click", function() {
		var loc1 = window.location.pathname;
		var loc2 = {
			url : '/?rt=index/all_offers'
		};
		console.log(loc1);
		window.location.assign(loc1+loc2.url);
	});
} )
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>




