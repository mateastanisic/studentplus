<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<!-- prikazuje se ako si logiran? -->
<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/search_results">
	<div id="div_search">
		<input type="text" name="search" />
		<button type="submit">Traži</button><br><br>
	</div>
</form>

<h>Prikaz ponuda studenta</h><br>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/check_button_choice">

	<br>
	<button type="submit" name="button" value="applications">Moje prijave</button><br><br>

	<div id="div_prikaz_ponuda">
		<br>

		<table>

		<?php 
		if( isset($message) && strlen($message) ) echo $message . ' <br> ';
		foreach($offers as $i=>$ponuda) { ?>

			<tr id="red_ <?php echo $i; ?>" >
				<?php 
				echo 'Praksa: ', $ponuda->name, '<br>'; 
				echo 'Tvrtka: ', $ponuda->company, '<br>';
				echo 'Opis prakse: ', $ponuda->description, '<br>';
				echo 'Adresa: ', $ponuda->adress, '<br>';
				echo 'Period rada: ', $ponuda->period, '<br>';
				?>

				<!-- Klikom na ovaj gumb se student prijavljuje za praksu -->
				<button type="submit" id="prijava_<?php echo $i; ?>" name="button" value="application_in_offer_<?php echo $ponuda->id ?>">Prijavi se!</button><br><br>
			</tr>
			
		</table>
		<?php } ?>

	</div>

</form>

<script type="text/javascript">
	$("document").ready(function() {
		$('#header').on( "click", function() {
			var loc1 = window.location.pathname;
			var loc2 = {
				url : '/?rt=student/all_offers'
			};
			console.log(loc1);
			window.location.assign(loc1+loc2.url);
		});
	} )
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>