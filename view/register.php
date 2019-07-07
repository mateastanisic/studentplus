<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<!--STUDENT ILI TVRTKA-->
<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=index/check_register_type">
	<div class="transparent_div">
		<h3 class="boldaj">Registriraj se kao student ili tvrtka?</h3>
		<input type="radio" name="odabir" value="student" id="student">Student</input>
		<input type="radio" name="odabir" value="company" id="company">Tvrtka</input> <br><br>
		<?php if( isset($message_not_filled) && strlen($message_not_filled) ) echo 'Niste se registrirali jer  '. $message_not_filled . ' <br> '; ?>
	</div>
</form>

<!--registracija forma student-->
<div id="reg_student">
	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/check_register" enctype="multipart/form-data" >
		<table>
			<tr> <td class="boldaj"> Username: </td> 
				 <td><input type="text" name="new_student_username" class="nice_input_reg" font-size="100%"/> </td>
			</tr>

			<tr>
			<td class="boldaj">Password:</td><td>  <input class="nice_input_reg" type="password" name="new_student_password" /><br>
			</tr>

			<tr>
			<td class="boldaj">Ime:</td><td>  <input class="nice_input_reg" type="text" name="new_student_name"   /></td>
			</tr>

			<tr>
			<td class="boldaj">Prezime:</td><td>  <input class="nice_input_reg"  type="text" name="new_student_surname" /></td>
			</tr>

			<tr>
			<td class="boldaj">E-mail: </td><td> <input class="nice_input_reg" type="text" name="new_student_email" /></td>
			</tr>

			<tr>
			<td class="boldaj">Broj mobitela:</td><td>  <input class="nice_input_reg"  type="text" name="new_student_phone" /></td>
			</tr>

			<tr>
			<td class="boldaj">Fakultet:</td><td>  <input class="nice_input_reg" type="text" name="new_student_school" /></td>
			</tr>

			<tr>
			<td class="boldaj">Ocjene: </td><td> <input class="nice_input_reg" type="text" name="new_student_grades"  /></td>
			</tr>

			<tr>
			<td class="boldaj">Slobodno vrijeme:</td><td>  <input class="nice_input_reg" type="text" name="new_student_free_time" /></td> 
			</tr> 
			<tr> 
			<td class="boldaj"><br> Životopis:</td><td> <br> <input type="file" name="new_student_cv" /></td> 
			</tr>
		</table>
		<button type="submit" class="registration_login_button" >Registriraj se!</button><br><br>

	</form>
</div>

<!--registracija forma tvrtka-->
<div id="reg_company">
	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_register">
		
		<table>
			<tr>
				<td class="boldaj"> OIB: </td>
				<td> <input class="nice_input_reg" type="text" name="new_company_oib" /> </td>
			</tr>
			<tr>
				<td class="boldaj"> Password:</td>
				<td> <input class="nice_input_reg" type="password" name="new_company_password" /></td>
			</tr>
			<tr>
				<td class="boldaj">Ime: </td>
				<td> <input class="nice_input_reg" type="text" name="new_company_name" /> </td>
			</tr>
			<tr>
				<td class="boldaj"> E-mail: </td>
				<td> <input class="nice_input_reg" type="text" name="new_company_email" /></td>
			</tr>
			<tr>
				<td class="boldaj"> Adresa:</td>
				<td>  <input class="nice_input_reg" type="text" name="new_company_adress" /> </td>
			</tr>
			<tr>
				<td class="boldaj">Broj telefona: </td>
				<td> <input class="nice_input_reg" type="text" name="new_company_phone" /> </td>
			</tr>
			<tr>
				<td class="boldaj"> <br>Opis: </td>
				<td> <br><textarea class="textarea" name="new_company_description" rows="3" cols="30"></textarea></td>
			</tr>
		</table>

		<button type="submit" class="registration_login_button" >Registriraj se!</button><br><br>
		
	</form>
</div>

<script type="text/javascript">
	//Kada odaberemo jesmo li student ili tvrtka, pokazuje se forma za registraciju za odgovarajuc odabir
	$("document").ready(function() {

		$("#reg_student").hide();
		$("#reg_company").hide();
		$("#login").hide();
		$("#register").hide();

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
				url : '?rt=index/all_offers'
			};
			console.log(loc1);
			window.location.assign(loc1+loc2.url);
		});

	});
</script>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>