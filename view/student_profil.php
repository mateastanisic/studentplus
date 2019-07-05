<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">

	<button type="submit" name="button" value="dashboard">Natrag na naslovnicu</button><br>


	<div id="div_profil">
		<table id="table_profil">
		<caption>Profil studenta: </caption>

			<tr >
				<?php 
				echo 'Ime: ', $student_in_offer->name, "<br>"; 
				echo 'Prezime: ', $student_in_offer->surname, "<br>";
				echo 'Fakultet: ', $student_in_offer->school, "<br>";
				echo 'Broj mobitela:', $student_in_offer->phone, "<br>";
				echo 'E-mail: ', $student_in_offer->email, "<br>";
				echo 'Ocjene: ', $student_in_offer->grades, "<br>";
				echo 'Slobodno vrijeme: ', $student_in_offer->free_time, "<br>";
				?>

				<button type="submit" name="button" value="accept">Prihvati <?php echo $student_in_offer->name ?> </button><br>
				<button type="submit" name="button" value="reject">Odjebi <?php echo $student_in_offer->name ?> </button><br>

			</tr>
					
		</table>
	</div>

</form>
																																																																																											

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>