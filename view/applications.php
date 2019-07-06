<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div id="div_waiting">
	<table id="table_waiting">
	<caption>Poslani zahtjevi za prakse: </caption>
	<?php foreach($waiting as $i=>$zahtjev) { ?>

				<tr id="waiting_ <?php echo $i; ?>" >
					<?php 
					echo 'Praksa: ', $zahtjev->name; 
					echo 'Tvrtka: ', $zahtjev->company;
					echo 'Opis prakse: ', $zahtjev->description;
					echo 'Adresa: ', $zahtjev->adress;
					echo 'Period rada: ', $zahtjev->period;
					?>
				</tr>
				
			<?php } ?>
	</table>
</div>

<div id="div_accepted">
	<table id="table_accepted">
	<caption>Prihvaćeni zahtjevi za prakse: </caption>
	<?php foreach($accepted as $i=>$zahtjev) { ?>

				<tr id="accepted_ <?php echo $i; ?>" >
					<?php 
					echo 'Praksa: ', $zahtjev->name; 
					echo 'Tvrtka: ', $zahtjev->company;
					echo 'Opis prakse: ', $zahtjev->description;
					echo 'Adresa: ', $zahtjev->adress;
					echo 'Period rada: ', $zahtjev->period;
					?>
				</tr>
				
			<?php } ?>
	</table>
</div>

<div id="div_rejected">
	<table id="table_rejected">
	<caption>Odbijeni zahtjevi za praksu: </caption>
	<?php foreach($rejected as $i=>$zahtjev) { ?>

				<tr id="rejected_ <?php echo $i; ?>" >
					<?php 
					echo 'Praksa: ', $zahtjev->name; 
					echo 'Tvrtka: ', $zahtjev->company;
					echo 'Opis prakse: ', $zahtjev->description;
					echo 'Adresa: ', $zahtjev->adress;
					echo 'Period rada: ', $zahtjev->period;
					?>
				</tr>
				
			<?php } ?>
	</table>
</div>

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