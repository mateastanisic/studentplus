<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">

	<br>
	
	<button class="big_button" type="submit" name="button" value="make_new">Stvori novu ponudu</button>

	<br><br><br>

	<div id="div_ponude">
		<h2>Moje prakse: </h2> 
		<?php foreach($company_offers as $i=>$ponuda) { ?>
			<table class="ponuda">
				<caption class="caption"> 
					<button class="big_button" type="submit" name="button" value="students_in_offer_<?php echo $ponuda->id ?>"> Prijavljeni studenti  </button> 
				</caption>

				<?php 
				echo '<tr><td></td><td><h3>', $ponuda->name, '</h3></td></tr>'; 
				echo '<tr><td class="boldaj">Opis <br> prakse: </td> <td>', $ponuda->description, '</td></tr>';
				echo '<tr><td class="boldaj">Adresa: </td> <td>', $ponuda->adress, '</td></tr>';
				echo '<tr><td class="boldaj">Period <br> rada: </td> <td>', $ponuda->period, '</td></tr>';
				?>
			</table>		
		<?php } ?>
	</div>

</form>

<script type="text/javascript">
	$("document").ready(function() {
		$('#header').on( "click", function() {
			var loc1 = window.location.pathname;
			var loc2 = {
				url : '?rt=company/all_offers'
			};
			console.log(loc1);
			window.location.assign(loc1+loc2.url);
		});
	} )
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>