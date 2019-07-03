<?php require_once __SITE_PATH . '/view/_header.php'; ?>


<div id="div_prikaz_ponuda">

	<table>
		<?php
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
			
	</table>
	<?php } ?>

</div>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>