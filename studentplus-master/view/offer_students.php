<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">

	<button type="submit" name="button" value="dashboard">Natrag na naslovnicu</button><br>


	<div id="div_studenti">
		<table id="table_studenti">
		<!-- Tu bih voljela staviti ime ponude, ne znam jel mogu dohvatiti tu -->
		<caption>Studenti prijavljeni za praksu 'ime': </caption>
		<?php foreach($members as $i=>$student) { ?>

					<tr id="student_ <?php echo $i; ?>" >
						<?php 
						echo 'Ime: ', $student->name; 
						echo 'Prezime: ', $student->surname;
						echo 'Fakultet: ', $student->school;
						?>

						<button type="submit" name="button" value="student_in_offer_<?php echo $student->id ?>">Pogledaj profil studenta <?php echo $student->name ?> </button><br>

					</tr>
					
				<?php } ?>
		</table>
	</div>

</form>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>