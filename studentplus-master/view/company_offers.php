<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">

	<button type="submit" name="button" value="dashboard">Natrag na naslovnicu</button><br>
	<button type="submit" name="button" value="make_new">Stvori novu ponudu</button>


	<div id="div_ponude">
		<table id="table_ponude">
		<caption>Moje ponude za prakse: </caption>
		<?php foreach($company_offers as $i=>$ponuda) { ?>

					<tr id="ponude_ <?php echo $i; ?>" >
						<?php 
						echo 'Praksa: ', $ponuda->name; 
						echo 'Tvrtka: ', $ponuda->company;
						echo 'Opis prakse: ', $ponuda->description;
						echo 'Adresa: ', $ponuda->adress;
						echo 'Period rada: ', $ponuda->period;
						?>

						<button type="submit" name="button" value="students_in_offer_<?php echo $ponuda->id ?>">Studenti prijavljeni za praksu <?php echo $ponuda->name ?> </button><br>

					</tr>
					
				<?php } ?>
		</table>
	</div>

</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>