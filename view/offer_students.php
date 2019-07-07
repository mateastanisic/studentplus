<?php require_once __SITE_PATH . '/view/_header.php'; ?>


<h2> <?php echo $offer->name; ?> </h2> 

<!-- prvo ispisujemo studente cije su prijave jos otvorene -->
<div id="div_pending">

	<table id="table_studenti_pending">

		<caption>Prijavljeni studenti: </caption><br>
		<!-- za svakog studenta prikazujem ime, prezime i ostatak profila koji se moze po zelji sakriti-->
		<?php foreach($pending_students_in_offer as $i=>$student) { ?>
		
			<tr><td class="ime_pending" id="<?php echo $i ?>" />
				<?php echo $student->name, " ", $student->surname, "<br>"; ?>
			</td></tr>

			<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">
			<tr><td><button type="submit" name="button" value="accept_<?php echo $student->id ?>">Prihvati </button></td></tr>          
			<tr><td><button type="submit" name="button" value="reject_<?php echo $student->id ?>">Odbij </button></td></tr>
			</form>
			
			<!-- dodatni podaci- profil studenta, po defaultu hidden -->
			<?php 
				echo '<tr class="tr_hide_p"  id="s1' . $i . '" hidden><td > Fakultet: ', $student->school, '</td></tr>';
				echo '<tr class="tr_hide_p"  id="p1' . $i . '" hidden><td> Broj mobitela:', $student->phone, '</td></tr>';
				echo '<tr class="tr_hide_p"  id="e1' . $i . '" hidden><td> E-mail: ', $student->email, '</td></tr>';
				echo '<tr class="tr_hide_p"  id="g1' . $i . '" hidden><td> Ocjene: ', $student->grades, '</td></tr>';
				echo '<tr class="tr_hide_p"  id="f1' . $i . '" hidden><td> Slobodno vrijeme: ', $student->free_time, '</td></tr>';
			?>

			<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">
			<tr><td><button class="cv_pending" id="<?php echo "cvp" . $i; ?>" 
				type="submit" name="download" value="<?php echo $student->cv;?>" hidden> Skini Životopis! </button></td></tr>
			</form>

			<tr><td><button class="hide_pending" id ="<?php echo "hp" . $i; ?>" hidden>Sakrij profil </button></td></tr>
									
		<?php } ?>
	</table>

</div>

<!-- studenti cije su prijave odobrene -->
<div id="div_accepted">

	<table id="table_studenti_accepted">

		<caption>Primljeni studenti: </caption><br>

		<?php 

		foreach($accepted_students_in_offer as $i=>$student) { ?>

			<tr><td class="ime_accepted" id="<?php echo $i; ?>" />
				<?php echo $student->name, " ", $student->surname, "<br>"; ?>
			</td></tr>
					
			<?php			
				echo '<tr class="tr_hide_a"  id="s2' . $i . '" hidden><td > Fakultet: ', $student->school, '</td></tr>';
				echo '<tr class="tr_hide_a"  id="p2' . $i . '" hidden><td> Broj mobitela:', $student->phone, '</td></tr>';
				echo '<tr class="tr_hide_a"  id="e2' . $i . '" hidden><td> E-mail: ', $student->email, '</td></tr>';
				echo '<tr class="tr_hide_a"  id="g2' . $i . '" hidden><td> Ocjene: ', $student->grades, '</td></tr>';
				echo '<tr class="tr_hide_a"  id="f2' . $i . '" hidden><td> Slobodno vrijeme: ', $student->free_time, '</td></tr>';
			?> 	
			<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_button_choice">
				<tr><td><button class="cv_accepted" id="<?php echo "cva" . $i; ?>" 
					type="submit" name="download" value="<?php echo $student->cv;?>" hidden> Skini Životopis! </button></td></tr>
			</form>

			<tr><td><button class="hide_accepted" id ="<?php echo "ha" . $i; ?>" hidden>Sakrij profil </button></td></tr>
									
		<?php } ?>

	</table>

</div>

<script type="text/javascript">
	$("document").ready(function() {

		//povratak na naslovnicu, klikom na header
		$('#header').on( "click", function() {
			var loc1 = window.location.pathname;
			var loc2 = {
				url : '?rt=company/all_offers'
			};
			console.log(loc1);
			window.location.assign(loc1+loc2.url);
		});

		//pokdazi/sakrij profil studenta
		var ime_accepted= $( ".ime_accepted" );
		var ime_pending= $( ".ime_pending" );

		var cv_accepted = $( ".cv_accepted" );
		var hide_accepted = $( ".hide_accepted" );

		var cv_pending = $( ".cv_pending" );
		var hide_pending = $( ".hide_pending" );

		var tra = $( ".tr_hide_a" );
		var trp = $( ".tr_hide_p" );

		//klikom na ime studenta prikaze se njegov profil
		ime_pending.on( "click", function(){

			var i = $( this ).attr( "id" );
			console.log( i );
			
			for ( var j = 0; j < trp.length; j++ ){
				if ( trp.eq(j).attr( "id" ).substr( 2 ) === i ){
					trp.eq(j).show();
				}
			}
			cv_pending.eq(i).show();
			hide_pending.eq(i).show();

		});
		ime_accepted.on( "click", function(){

			var i = $( this ).attr( "id" );
			console.log( i );
			
			for ( var j = 0; j < tra.length; j++ ){
				if ( tra.eq(j).attr( "id" ).substr( 2 ) === i ){
					tra.eq(j).show();
				}
			}
			cv_accepted.eq(i).show();
			hide_accepted.eq(i).show();

		});

		//klikom na gumb Sakrij, profil se sakriva
		$( ".hide_pending" ).on( "click", function(){

			for ( var i = 0; i < hide_pending.length; i++ ){
				var id = "hp" + i;
				if ( $( this ).attr( "id" ) === id ) 
					break;
			}
			console.log( i );

			for ( var j = 0; j < trp.length; j++ ){
				if ( trp.eq(j).attr( "id" ).substr( 2 ) === String(i) ){
					console.log( "tu sam " );
					trp.eq(j).hide();
				}
			}

			cv_pending.eq( i ).hide();
			$( this ).hide();
		});

		$( ".hide_accepted" ).on( "click", function(){

			for ( var i = 0; i < hide_accepted.length; i++ ){
				var id = "ha" + i;
				if ( $( this ).attr( "id" ) === id ) 
					break;
			}
			console.log( i );

			for ( var j = 0; j < tra.length; j++ ){
				if ( tra.eq(j).attr( "id" ).substr( 2 ) === String(i) ){
					console.log( "tu sam " );
					tra.eq(j).hide();
				}
			}

			cv_accepted.eq( i ).hide();
			$( this ).hide();

		});

	} )
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>