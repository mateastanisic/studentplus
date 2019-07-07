<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<!-- prikazuje se ako si logiran? -->
<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/search_results">
	<div id="div_search" class="transparent_div">
		<input type="text" name="search" class="nice_input" placeholder="pretraži"/>
		<button type="submit" class="search_button"> &#187; </button><br><br>
		<?php if( isset($message) && strlen($message) ) echo $message . ' <br> '; ?>
	</div>
</form>

	<br>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">

	<button class="big_button" type="submit" name="button" value="ours">Moje prakse </button><br><br>


	<!-- Da taj gumb bude samo na stranici "Moje ponude"? -->
	<button class="big_button" type="submit" name="button" value="make_new">Ponudi novu praksu</button>

	<br><br><br>

	<div id="div_prikaz_ponuda"> 
		<?php 
		foreach($offers as $i=>$ponuda) { ?>
			<table>
				<?php 
				echo '<caption class="boldaj">', $ponuda->name, '</caption>'; 
				echo '<tr><td class="boldaj">Tvrtka: </td> <td>', $ponuda->company, '</tr></td>';
				echo '<tr><td class="boldaj">Opis <br> prakse: </td> <td>', $ponuda->description, '</tr></td>';
				echo '<tr><td class="boldaj">Adresa: </td> <td>', $ponuda->adress, '</tr></td>';
				echo '<tr><td class="boldaj">Period <br> rada: </td> <td>', $ponuda->period, '</tr></td>';
				?>
			</table>		
		<?php } ?>

	</div><br><br>

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