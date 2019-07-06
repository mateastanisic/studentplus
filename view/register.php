<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<!--STUDENT ILI TVRTKA-->
<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=index/check_register_type">
	<p>Želim se registrirati kao: </p>
	<input type="radio" name="odabir" value="student" id="student">Student</input>
	<input type="radio" name="odabir" value="company" id="company">Tvrtka</input>
</form>

<!--registracija forma student-->
<div id="reg_student">
	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/check_register" enctype="multipart/form-data" >
		
		Username: <input type="text" name="new_student_username" value="sdf" /><br>
		Password: <input type="password" name="new_student_password" value="pass" /><br>
		Ime: <input type="text" name="new_student_name"  value="ghbnj" /><br>
		Prezime: <input type="text" name="new_student_surname" value="ghbnj"/><br>
		E-mail: <input type="text" name="new_student_email" value="ghbnj" /><br>
		Broj mobitela: <input type="text" name="new_student_phone" value="099" /><br>
		Fakultet: <input type="text" name="new_student_school" value="ghbnj" /><br>
		Ocjene: <input type="text" name="new_student_grades"value="4.55"  /><br>
		Slobodno vrijeme: <input type="text" name="new_student_free_time" value="43"/><br>
		Životopis: <input type="file" name="new_student_cv" /><br><br>

		<button type="submit">Registriraj se!</button><br><br>

	</form>
</div>

<!--registracija forma tvrtka-->
<div id="reg_company">
	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_register">
																																																																																																																																																																																																																							
		OIB: <input type="text" name="new_company_oib" /><br>
		Password: <input type="password" name="new_company_password" /><br>
		Ime: <input type="text" name="new_company_name" /><br>
		E-mail: <input type="text" name="new_company_email" /><br>
		Adresa: <input type="text" name="new_company_adress" /><br>
		Broj telefona: <input type="text" name="new_company_phone" /><br>
		Opis: <textarea name="new_company_description" rows="10" cols="20"></textarea><br><br>
		<button type="submit">Registriraj se!</button><br><br>
		
	</form>
</div>

<script type="text/javascript">
	//Kada odaberemo jesmo li student ili tvrtka, pokazuje se forma za registraciju za odgovarajuc odabir
	$("document").ready(function() {

		$("#reg_student").hide();
		$("#reg_company").hide();

		$('input:radio[name="odabir"]').change( function() {
			if( document.getElementById("student").checked ) {
				$("#reg_company").hide();
				$("#reg_student").show();
			}

			else if( document.getElementById("company").checked ) {
				$("#reg_student").hide();
				$("#reg_company").show();
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

	});
</script>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>