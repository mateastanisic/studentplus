<?php
	//vraća status trenutno logiranog studenta u ponudi s idom $id_offer
	function get_status(){
		if( !isset($_SESSION['login']) || !isset($_SESSION['offer']) ) throw new Exception( 'get_status :: Values are not properly set.' );
		//saznaj o kojem se studentu radi
		$id_student = $this->get_id_by_username($_SESSION['login']);
		//saznaj o kojoj se ponudi radi
		$id_offer = $_SESSION['offer'];

		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT status FROM studentplus_members WHERE id_student=:id_student AND id_offer=:id_offer' );
			$st->execute( array( 'id_student' => $id_student,  'id_offer' => $id_offer ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false ) return null;
		else return $row['status'];
	}




	//JA BI OVO OBRISALA
	//vraća sve ponude neke tvrtke (ne šaljemo oib nego ime tvrtke)
	function get_offers_by_company($tvrtka){
		$offers = $this->get_all_offers();
		$found = array();

		for( $i = 0; $i<count($offers); $i++ ){
			if( $offers[i]->ime === $tvrtka ) $found[] = $offers[i];
		}

		return $found;
	}


	//vraća username studenta
	function get_username_by_id($id){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT username FROM studentplus_students WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false ) return null;
		else return $row['username'];	
	}





?>