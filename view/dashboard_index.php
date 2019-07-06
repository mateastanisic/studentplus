<?php require_once __SITE_PATH . '/view/_header.php'; ?>


<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=index/search_results">
	<div id="div_search">
		<input type="text" name="search" />
		<button type="submit">Traži</button><br><br>
	</div>
</form>

<!--<h>Prikaz ponuda nelogiranog korisnika</h><br>-->

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
				echo 'Period rada: ', $ponuda->period, '<br><br>';
				?>
			</tr>
			
	</table>
	<?php } ?>

</div>

<script type="text/javascript">
	$("document").ready(function() {
		$('#header').on( "click", function() {
			var loc1 = window.location.pathname;
			var loc2 = {
				url : '/?rt=index/all_offers'
			};
			console.log(loc1);
			window.location.assign(loc1+loc2.url);
		});
	} )
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>