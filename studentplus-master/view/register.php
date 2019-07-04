<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=index/check_register_type">

	<p>Želim se registrirati kao: </p>

	<input type="radio" name="odabir" value="student" id="student">Student</input>
	<input type="radio" name="odabir" value="company" id="company">Tvrtka</input>
</form>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/check_register" enctype="multipart/form-data">

	<div id="reg_student">
		Username: <input type="text" name="new_student_username" /><br>
		Password: <input type="password" name="new_student_password" /><br>
		Ime: <input type="text" name="new_student_name" /><br>
		Prezime: <input type="text" name="new_student_surname" /><br>
		E-mail: <input type="text" name="new_student_email" /><br>
		Broj mobitela: <input type="text" name="new_student_phone" /><br>
		Fakultet: <input type="text" name="new_student_school" /><br>
		Ocjene: <input type="text" name="new_student_grades" /><br>
		Slobodno vrijeme: <input type="text" name="new_student_free_time" /><br>
		Životopis: <input type="file" name="new_student_cv" /><br><br>

		<button type="submit">Registriraj se!</button><br><br>
	</div>
</form>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_register">
																																																																																																																																																																																																																						
	<div id="reg_company">
		OIB: <input type="text" name="new_company_oib" /><br>
		Password: <input type="password" name="new_company_phonempany_password" /><br>
		Ime: <input type="text" name="namew_company_name" /><br>
		E-mail: <input type="text" name="new_company_email" /><br>
		Adresa: <input type="text" name="new_company_adress" /><br>
		Broj telefona: <input type="text" name="new_company_phone" /><br>
		Opis: <textarea name="new_company_description" rows="10" cols="20"></textarea><br><br>

		<button type="submit">Registriraj se!</button><br><br>
	</div>

	<button type="submit" name="dashboard">Dashboard</button>

</form>

<script type="text/javascript">

//Kada odaberemo jesmo li student ili tvrtka, pokazuje se forma za registraciju za odgovarajuc odabir

$("document").ready(function() {

	//$("#reg_student").hide();
	$("#reg_company").hide();

	$('input:radio[name="odabir"]').change( function() {
		if( document.getElementById("student").checked() ) {
			$("#reg_company").hide();
			$("#reg_student").show();
		}

		else if( document.getElementById("company").checked() ) {
			$("#reg_student").hide();
			$("#reg_company").show();
		}
	});
} )
</script>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>