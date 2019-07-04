<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<!-- prikazuje se ako si logiran? -->
<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=index/search_results">
	<div id="div_search">
		<input type="text" name="search" />
		<button type="submit">Traži</button>
	</div>
</form>

<h>Prikaz ponuda tvrtke</h><br>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">

	<button type="submit" name="button" value="ours">Moje ponude</button><br>

	<!-- Da taj gumb bude samo na stranici "Moje ponude"? -->
	<button type="submit" name="button" value="make_new">Stvori novu ponudu</button><br>

	<div id="div_prikaz_ponuda">

		<?php if ($company_logged !== null) {
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
				</tr>
				
			<?php }
			echo "</table>";
		} ?>

	</div>

</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>