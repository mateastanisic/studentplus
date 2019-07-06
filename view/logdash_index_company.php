<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<!-- prikazuje se ako si logiran? -->
<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/search_results">
	<div id="div_search">
		<input type="text" name="search" />
		<button type="submit">Traži</button><br><br>
	</div>
</form>

<h>Prikaz ponuda tvrtke</h><br>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">

	<button type="submit" name="button" value="ours">Moje ponude</button><br><br>

	<!-- Da taj gumb bude samo na stranici "Moje ponude"? -->
	<button type="submit" name="button" value="make_new">Stvori novu ponudu</button><br>

	<div id="div_prikaz_ponuda">

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
				echo 'Period rada: ', $ponuda->period, '<br>', '<br>';
				?>
			</tr>
			
		<?php } ?>
		</table>

	</div><br><br>

</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>