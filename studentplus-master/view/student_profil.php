<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">

	<button type="submit" name="button" value="dashboard">Natrag na naslovnicu</button><br>


	<div id="div_profil">
		<table id="table_profil">
		<caption>Profil studenta: </caption>

			<tr id="student_ <?php echo $i; ?>" >
				<?php 
				echo 'Ime: ', $student->name; 
				echo 'Prezime: ', $student->surname;
				echo 'Fakultet: ', $student->school;
				echo 'Broj mobitela:', $student->phone;
				echo 'E-mail: ', $student->email;
				echo 'Ocjene: ', $student->grades;
				echo 'Slobodno vrijeme: ', $student->free_time;
				?>

				<button type="submit" name="button" value="accept">Prihvati <?php echo $student->name ?> </button><br>
				<button type="submit" name="button" value="reject">Odjebi <?php echo $student->name ?> </button><br>

			</tr>
					
		</table>
	</div>

</form>
																																																																																											

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>