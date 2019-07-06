<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">

	<button type="submit" name="button" value="make_new">Stvori novu ponudu</button>


	<div id="div_ponude">
		<h2>Moje ponude za prakse: </h2> 
		<table id="table_ponude">
		<caption> </caption>
		<?php foreach($company_offers as $i=>$ponuda) { ?>

					<tr id="ponude_ <?php echo $i; ?>" >
						<?php 
						echo 'Praksa: ', $ponuda->name, '<br>'; 
						echo 'Tvrtka: ', $ponuda->company, '<br>';
						echo 'Opis prakse: ', $ponuda->description, '<br>';
						echo 'Adresa: ', $ponuda->adress, '<br>';
						echo 'Period rada: ', $ponuda->period, '<br>';
						?>

						<button type="submit" name="button" value="students_in_offer_<?php echo $ponuda->id ?>">Studenti prijavljeni za praksu <?php echo $ponuda->name ?> </button><br><br>

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