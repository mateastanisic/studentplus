<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=company/check_new_offer">

	Unesi ime prakse: <input type="text" name="new_offer_name" /><br>
	Dodaj opis prakse: <textarea name="new_offer_description" rows="10" cols="20"></textarea><br>
	Adresa: <input type="text" name="new_offer_adress" /><br>
	Vremenski period rada:  <input type="text" name="new_offer_period" /><br>

	<button type="submit" name="stvori">Stvori novu ponudu</button>

</form>

<script type="text/javascript">
	$("document").ready(function() {
		$('#header').on( "click", function() {
			var loc1 = window.location.pathname;
			var loc2 = {
				url : '/rt=company/all_offers'
			};
			console.log(loc1);
			window.location.assign(loc1+loc2.url);
		});
	} )
</script>


<?php require_once __SITE_PATH . '/view/_footer.php'; ?>