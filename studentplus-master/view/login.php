<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=index/check_login_type">

	<p>Student ili tvrtka?</p>

	<input type="radio" name="s_ili_c" value="student" id="student">Student</input>
	<input type="radio" name="s_ili_c" value="company" id="company">Tvrtka</input>

	<div id="log_student">
		Username: <input type="text" name="username" />
		Password: <input type="Password" name="pass" />
	</div>

	<div id="log_company">
		OIB: <input type="text" name="oib" />
		Password: <input type="Password" name="pass" />
	</div>
	

	<button type="submit" name="dashboard">Dashboard</button>

</form>


<script type="text/javascript">

//Kada odaberemo jesmo li student ili tvrtka, pokazuje se forma za login za odgovarajuc odabir

$("document").ready(function() {

	$("#log_student").hide();
	$("#log_company").hide();

	$('input:radio[name="postage"]').change( function() {
		if( document.getElementById("student").checked() ) {
			$("#log_company").hide();
			$("#log_student").show();
		}

		else if( document.getElementById("company").checked() ) {
			$("#log_student").hide();
			$("#log_company").show();
		}
	});
} )
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
