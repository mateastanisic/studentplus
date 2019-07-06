<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">

	<div id="div_studenti_accepted">
		<table id="table_studenti_accepted">
		<!-- Tu bih voljela staviti ime ponude, ne znam jel mogu dohvatiti tu -->
		<caption>Studenti prijavljeni za praksu, prihvaceni <?php echo $offer->name ?>: </caption><br>
		<?php foreach($accepted_students_in_offer as $i=>$student) { ?>

					<tr id="student_ <?php echo $i; ?>" >
						<?php 
						echo 'Ime: ', $student->name, "<br>"; 
						echo 'Prezime: ', $student->surname, "<br>";
						echo 'Fakultet: ', $student->school, "<br>";
						?>

						<button type="submit" name="button" value="student_in_offer_<?php echo $student->id ?>">Pogledaj profil studenta <?php echo $student->name ?> </button><br><br>

						<button type="submit" name="button" value="accept_<?php echo $student->id ?>">Prihvati <?php echo $student->name ?> </button><br>

						<button type="submit" name="button" value="reject_<?php echo $student->id ?>">Odjebi <?php echo $student->name ?> </button><br>

					</tr>
					
				<?php } ?>
		</table>
	</div>

	<div id="div_studenti_pending">
		<table id="table_studenti_pending">
		<!-- Tu bih voljela staviti ime ponude, ne znam jel mogu dohvatiti tu -->
		<caption>Studenti prijavljeni za praksu, pending <?php echo $offer->name ?>: </caption><br>
		<?php foreach($pending_students_in_offer as $i=>$student) { ?>

					<tr id="student_ <?php echo $i; ?>" >
						<?php 
						echo 'Ime: ', $student->name, "<br>"; 
						echo 'Prezime: ', $student->surname, "<br>";
						echo 'Fakultet: ', $student->school, "<br>";
						?>

						<button type="submit" name="button" value="student_in_offer_<?php echo $student->id ?>">Pogledaj profil studenta <?php echo $student->name ?> </button><br><br>

						<button type="submit" name="button" value="accept_<?php echo $student->id ?>">Prihvati <?php echo $student->name ?> </button><br>

						<button type="submit" name="button" value="reject_<?php echo $student->id ?>">Odjebi <?php echo $student->name ?> </button><br>

					</tr>
					
				<?php } ?>
		</table>
	</div>

</form>

<script type="text/javascript">
	$("document").ready(function() {
		$('#header').on( "click", function() {
			var loc1 = window.location.pathname;
			var loc2 = {
				url : '/?rt=company/all_offers'
			};
			console.log(loc1);
			window.location.assign(loc1+loc2.url);
		});
	} )
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>