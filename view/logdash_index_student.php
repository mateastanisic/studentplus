<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<!-- prikazuje se ako si logiran? -->
<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/search_results">
	<div id="div_search" class="transparent_div">
		<input type="text" name="search" class="nice_input" placeholder="pretraži"/>
		<button type="submit" class="search_button"> &#187; </button><br><br>
		<?php if( isset($message) && strlen($message) ) echo $message . ' <br> '; ?>
	</div>
</form>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=student/check_button_choice">


	<button class="big_button" type="submit" name="button" value="applications">Moje prijave </button><br><br>
	

	<div id="div_prikaz_ponuda">
		<?php 
		foreach($offers as $i=>$ponuda) { ?>
			<table>
				<?php 
				echo '<tr><td class="boldaj">Praksa:</td> <td>', $ponuda->name, '</tr></td>'; 
				echo '<tr><td class="boldaj">Tvrtka: </td> <td>', $ponuda->company, '</tr></td>';
				echo '<tr><td class="boldaj">Opis <br> prakse: </td> <td>', $ponuda->description, '</tr></td>';
				echo '<tr><td class="boldaj">Adresa: </td> <td>', $ponuda->adress, '</tr></td>';
				echo '<tr><td class="boldaj">Period <br> rada: </td> <td>', $ponuda->period, '</tr></td>';
				?>
				<!-- Klikom na ovaj gumb se student prijavljuje za praksu -->
				<tr> <td></td> <td> <button class="log_reg_button" type="submit" id="prijava_<?php echo $i; ?>" name="button" value="application_in_offer_<?php echo $ponuda->id ?>">Prijavi se!</button> </td> </tr>
			</table>		
		<?php } ?>

	</div>

</form>

<script type="text/javascript">
	$("document").ready(function() {
		$('#header').on( "click", function() {
			var loc1 = window.location.pathname;
			var loc2 = {
				url : '?rt=student/all_offers'
			};
			console.log(loc1);
			window.location.assign(loc1+loc2.url);
		});
	} )
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>