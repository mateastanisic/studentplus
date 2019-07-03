<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<!-- prikazuje se ako si logiran? -->
<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=index/search_results">
	<div id="div_search">
		<input type="text" name="search" />
		<button type="submit">Traži</button>
	</div>
</form>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/check_button_choice">

	<button type="submit" name="button" value="applications">Moje prijave</button>

	<div id="div_prikaz_ponuda">

		<?php if ($student !== null) {
			echo "<table>";
			foreach($offers as $i=>$ponuda) { ?>

				<tr id="red_ <?php echo $i; ?>" >
					<?php 
					echo 'Praksa: ', $ponuda->name; 
					echo 'Tvrtka: ', $ponuda->company;
					echo 'Opis prakse: ', $ponuda->description;
					echo 'Adresa: ', $ponuda->adress;
					echo 'Period rada: ', $ponuda->period;
					?>

					<!-- Klikom na ovaj gumb se student prijavljuje za praksu -->
					<button type="submit" id="prijava_<?php echo $i; ?>" name="button" value="application_in_offer_<?php echo $ponuda->id ?>">Prijavi se!</button>
				</tr>
				
			<?php }
			echo "</table>";
		} ?>

	</div>

</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>