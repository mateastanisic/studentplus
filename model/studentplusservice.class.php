<?php

class studentplus_service {

	/*
	---------------------DOHVATI PODATKE O PONUDI------------------------
	*/
	//vraća polje svih ponuda (od svih tvrtki)
	function get_all_offers(){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, oib, ime, opis, lokacija, razdoblje FROM studentplus_offers ORDER BY id' );
			$st->execute();
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		//polje za spremanje svih ponuda
		$offers = array();
		while( $row = $st->fetch() ){
			//pronađimo ime tvrtke koja oglašava ovu ponudu
			$name = $this->get_companyname_by_oib($row['oib']);
			$offers[] = new Offer( $row['id'], $name, $row['ime'], $row['opis'], $row['lokacija'], $row['razdoblje'] );
		}
		return $offers;
	}

	//vraća ponudu s poslanim id-om
	function get_offer_by_id($id){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, oib, ime, opis, lokacija, razdoblje FROM studentplus_offers WHERE id:=id ORDER BY id' );
			$st->execute( 'id' => $id );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		$row = $st->fetch();
		if( $row === false ) return null;
		else{
			$name = $this->get_companyname_by_oib($row['oib']);
			return new Offer( $row['id'], $name, $row['ime'], $row['opis'], $row['lokacija'], $row['razdoblje'] );
		} 
	}

	//vraća sve ponude tvrtke s poslanim oib-om (tj dohvati sve ponude neke tvrtke)
	function get_offers_by_oib($oib){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id, oib, ime, opis, lokacija, razdoblje FROM studentplus_offers WHERE oib:=oib ORDER BY id' );
			$st->execute( 'oib' => $oib );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		//polje za spremanje svih ponuda
		$offers = array();
		//pronađimo ime tvrtke koja oglašava ovu ponudu
		$name = $this->get_companyname_by_oib($oib);
		while( $row = $st->fetch() ){
			$offers[] = new Offer( $row['id'], $name, $row['ime'], $row['opis'], $row['lokacija'], $row['razdoblje'] );
		}
		return $offers;
	}

	//vraća sve ponude neke tvrtke (ne šaljemo oib nego ime tvrtke)
	function get_offers_by_tvrtka($tvrtka){
		$offers = $this->get_all_offers();
		$found = array();

		for( $i = 0; $i<count($offers); $i++ ){
			if( $offers[i]->ime === $tvrtka ) $found[] = $offers[i];
		}

		return $found;
	}

	//vraća sve ponude koje u imenu sadržavaju podstring $ime 
	function get_offers_by_ime($ime){
		$offers = $this->get_all_offers();
		$found = array();

		for( $i = 0; $i<count($offers); $i++ ){
			if( strpos( $offers[i]->ime, $ime) !== false ) $found[] = $offers[i];
		}
		return $found;
	}

	//vraća polje svih ponuda kojima sam poslao zahtjev (bez obzira na status)
	function get_all_my_offers_by_id($id_user){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_user, id_ponuda, oib, status FROM studentplus_members WHERE id_user:=id_user ORDER BY id_user' );
			$st->execute( 'id_user' => $id_user );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		//polje za spremanje svih ponuda
		$offers = array();
		while( $row = $st->fetch() ){
			$jedna_ponuda = $this->get_offer_by_id($row['id_ponuda']);
			if( $jedna_ponuda === null ) continue;
			$offers[] = $jedna_ponuda;
		}
		return $offers;
	}	



	/*
	---------------------DOHVATI PODATKE O TVRTKI------------------------
	*/
	//vraća tvrtku (klasa) s određenim oib-om
	function get_company_by_oib($oib){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_companies WHERE oib:=oib ORDER BY oib' );
			$st->execute( 'oib' => $oib );
		}
		catch( PDOException $e ) { 
			exit( 'PDO error ' . $e->getMessage() ); 
		}

		$row = $st->fetch();
		if( $row === false ) return null;
		else{
			return new Company( $row['oib'], $row['password'], $row['ime'], $row['email'], $row['adresa'], $row['broj_telefona'], $row['opis_tvrtke'] );
		} 
	}

	//vraća ime tvrtke s poslanim oib-om
	function get_companyname_by_oib($oib){
		//probaj naći oib među tvrtkama
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT ime FROM studentplus_companies WHERE oib=:oib' );
			$st->execute( array( 'oib' => $oib ) );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		$row = $st->fetch();
		if( $row === false ) return null;
		else return $row['ime'];
	}

	//vraća ime tvrtke koja je postavila određenu ponudu
	function get_companyname_by_offerid($id){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT oib FROM studentplus_offers WHERE id:=id' );
			$st->execute( 'id' => $id );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		$row = $st->fetch();
		if( $row === false ) return null;
		else return $this->get_companyname_by_oib($row['oib']);
	}

	//vraća lozinku od neke tvrtke
	function get_password_by_oib($oib){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT password FROM studentplus_companies WHERE oib=:oib' );
			$st->execute( array( 'oib' => $oib ) );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		$row = $st->fetch();
		if( $row === false ) return null;
		else return $row['password'];
	}



	/*
	-------------------DOHVATI PODATKE O STUDENTIMA--------------------
	*/
	//vraća studenta(klasa) s određenim id-om
	function get_student_by_id($id){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_students WHERE id:=id ORDER BY id' );
			$st->execute( 'id' => $id );
		}
		catch( PDOException $e ) { 
			exit( 'PDO error ' . $e->getMessage() ); 
		}

		$row = $st->fetch();
		if( $row === false ) return null;
		else{
			return new Student( $row['id'], $row['username'], $row['password'], $row['ime'], $row['prezime'], $row['broj_telefona'], $row['email'], $row['fakultet'], $row['prosjek_ocjena'], $row['broj_slobodnih_sati_tjedno'], $row['zivotopis'] );
		} 
	}

	//vraća username studenta
	function get_username_by_id($id){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT username FROM studentplus_students WHERE id:=id' );
			$st->execute( 'id' => $id );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		$row = $st->fetch();
		if( $row === false ) return null;
		else return $row['username'];	
	}

	// vraća id studenta s određenim username-om
	function get_id_by_username($username){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id FROM studentplus_students WHERE username:=username' );
			$st->execute( 'username' => $username );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		$row = $st->fetch();
		if( $row === false ) return null;
		else return $row['id'];
	}

	//vraća lozinku nekog studenta
	function get_password_by_username($username){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT password FROM studentplus_students WHERE username=:username' );
			$st->execute( array( 'username' => $username ) );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		$row = $st->fetch();
		if( $row === false ) return null;
		else return $row['password'];
	}



	/*
	-------------------DOHVATI PODATKE O MEMBERIMA--------------------
	*/
	//vraća polje svih članova (-1/0/1) neke ponude čiji id šaljemo
	function get_students_in_offer(){
		//varijabla mora biti postavljena u session
		if( !isset($_SESSION['offer']) ) throw new Exception( 'get_students_in_offer_by_id :: Values are not properly set.' );

		$id_ponuda = $_SESSION['offer'];

		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_user, id_ponuda, oib, status FROM studentplus_members WHERE id_ponuda:=id_ponuda ORDER BY id_ponuda' );
			$st->execute( 'id_ponuda' => $id_ponuda );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		//polje za spremanje svih ponuda
		$members = array();

		while( $row = $st->fetch() ){
			//pronađimo studenta s danim id-om
			$student = $this->get_student_by_id($row['id_user']);
			if( $student === null ) continue;
			$members[] = $student;
		}
		return $members;
	}

	//vraća polje svih  članova koji su podnijeli zahtjev (za koje još nismo odlučili što ćemo s njima)
	function get_pending_students_in_offer(){
		//varijabla mora biti postavljena u session
		if( !isset($_SESSION['offer']) ) throw new Exception( 'get_pending_students_in_offer_by_id :: Values are not properly set.' );

		$id_ponuda = $_SESSION['offer'];

		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_user, id_ponuda, oib, status FROM studentplus_members WHERE id_ponuda:=id_ponuda ORDER BY id_ponuda' );
			$st->execute( 'id_ponuda' => $id_ponuda );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		//polje za spremanje svih ponuda
		$pending = array();

		while( $row = $st->fetch() ){
			//ako nije pending preskoči
			if( $row['status'] !== 0 ) continue;

			//pronađimo studenta s danim id-om
			$student = $this->get_student_by_id($row['id_user']);
			if( $student === null ) continue;
			$members[] = $student;
		}
		return $pending;
	}

	//vraća status trenutno logiranog studenta u ponudi s idom $id_ponuda
	function get_status(){
		if( !isset($_SESSION['login']) || !isset($_SESSION['offer']) ) throw new Exception( 'get_status :: Values are not properly set.' );
		//saznaj o kojem se studentu radi
		$id_user = $this->get_id_by_username($_SESSION['login']);
		//saznaj o kojoj se ponudi radi
		$id_ponuda = $_SESSION['offer'];

		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT status FROM studentplus_members WHERE id_user=:id_user AND id_ponuda=:id_ponuda' );
			$st->execute( array( 'id_user' => $id_user,  'id_ponuda' => $id_ponuda ) );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

		$row = $st->fetch();
		if( $row === false ) return null;
		else return $row['status'];
	}



	/*
	------------------- UPDATE AND INSERT IN DB --------------------
	*/
	//obradi prijavu studenta za neku ponudu
	function asign_student_to_offer(){
		//provjeri jesu li postavljene vrijednosti u SESSION
		if( !isset($_SESSION['login']) || !isset($_SESSION['offer']) ) throw new Exception( 'asign_student_to_offer :: Values are not properly set.' );

		//saznaj o kojem se studentu radi
		$id_user = $this->get_id_by_username($_SESSION['login']);
		//saznaj o kojoj se ponudi radi
		$id_ponuda = $_SESSION['offer'];


		//pogledaj postoji li uopće taj student 
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_students WHERE id=:id' );
			$st->execute( array( 'id' => $id_user ) );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 
		if( $st->rowCount() !== 1 ) throw new Exception( 'asign_student_to_offer :: Student with the given id does not exist.' );

		//pogledaj postoji li uopće ta ponuda 
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_offers WHERE id=:id' );
			$st->execute( array( 'id' => $id_ponuda ) );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 
		if( $st->rowCount() !== 1 ) throw new Exception( 'asign_student_to_offer :: Offer with the given id does not exist.' );



		//dodajmo studenta u member
		$tvrtka = $this->get_companyname_by_offerid($id_ponuda);
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO studentplus_members(id_user, id_ponuda, tvrtka, status) VALUES (:id_user, :id_ponuda, :tvrtka, :status)' );
			$st->execute( array( 'id_user' => $id_user, 'id_ponuda' => $id_ponuda, 'tvrtka' => $tvrtka, 'status' => 0 ) );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 

	}

	//obradi prihvaćanje/odbijanje studenta
	function change_status( $status, $id_user ){
		//moramo actually mjenjati nešto
		if( $status !== -1 || $status !== 1 ) throw new Exception( 'change_status :: Status value is not valid.' );

		//varijable moraju biti postavljene
		if( !isset($_SESSION['offer']) || !isset($id_user) ) throw new Exception( 'change_status :: Values are not properly set.' );
		
		$id_ponuda = $_SESSION['offer'];

		//provjeri postoji li takav member
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_members WHERE id_user=:id_user AND id_ponuda=:id_ponuda' );
			$st->execute( array( 'id_user' => $id_user,  'id_ponuda' => $id_ponuda ) );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 
		if( $st->rowCount() !== 1 ) throw new Exception( 'change_status :: Member with the given id in the given Offer does not exist.' );

		//update db
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE studentplus_members SET status=:status WHERE id_user=:id_user AND id_ponuda=:id_ponuda' );
			$st->execute( array( 'status' => $status, 'id_user' => $id_user,  'id_ponuda' => $id_ponuda ) );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() );
	}

	//dodaj novu ponudu u bazu
	function add_offer(){
		if( !isset($_POST['login']) || !isset($_POST['new_offer_name']) || isset($_POST['new_offer_description']) || isset($_POST['location']) || isset($_POST['period']) ) throw new Exception( 'add_offer :: Values are not properly set.' );

		$tvrtka = $this->get_companyname_by_oib($_POST['login']);
		$ime = $_POST['new_offer_name']; 
		$opis = $_POST['new_offer_description'];
		$lokacija = $_POST['location'];
		$razdoblje = $_POST['period'];


		//kreiramo novi jedinstveni id
		$id = 1;
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id FROM studentplus_offers' );
			$st->execute( );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() );

		while( $row = $st->fetch() ) $id++;


		//dodajmo ponudu u studentplus_offers
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO studentplus_offers(id, tvrtka, ime, opis, lokacija, razdoblje) VALUES (:id, :tvrtka, :ime, :opis, :lokacija, :razdoblje)' );
			$st->execute( array( 'id' => $id, 'tvrtka' => $tvrtka, 'ime' => $ime, 'opis' => $opis, 'lokacija' => $lokacija, 'razdoblje' => $razdoblje ) );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 
	}

	//registracija tvrtke
	function add_company(){

		if( !isset($_POST['new_company_oib']) || !isset($_POST['new_company_password']) || !isset($_POST['new_company_ime']) || !isset($_POST['new_company_email']) || !isset($_POST['new_company_adresa']) || !isset($_POST['new_company_telefon']) || !isset($_POST['new_company_opis']) ) 
				throw new Exception( 'add_company :: Values are not properly set.' );


		$oib = $_POST['new_company_oib'];
		$password_hash = password_hash($_POST['new_company_password'], PASSWORD_DEFAULT);
		$ime = $_POST['new_company_ime']; 
		$email = $_POST['new_company_email'];
		$adresa = $_POST['new_company_adresa'];
		$broj_telefona = $_POST['new_company_telefon'];
		$opis_tvrtke = $_POST['new_company_opis'];

		//provjerimo postoji li već tvrtka s takvim oib-om (ne može biti)
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_companies WHERE oib=:oib' );
			$st->execute( 'oib' => $oib );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() );
		if( $st->fetch() !== false ) throw new Exception( 'add_company :: Oib already exist.' );

		//registracija tvrtke
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO studentplus_companies(oib, password, ime, email, adresa, broj_telefona, opis_tvrtke ) VALUES (:oib, :password, :ime, :email, :adresa, :broj_telefona, :opis_tvrtke)' );
			$st->execute( array( 'oib' => $oib, 'password' => $password_hash, 'ime' => $ime, 'email' => $email, 'adresa' => $adresa, 'broj_telefona' => $broj_telefona, 'opis_tvrtke' => $opis_tvrtke) );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 
	}

	//registracija studenta
	function add_student(){
		if( !isset($_POST['new_student_username']) || !isset($_POST['new_student_password']) || !isset($_POST['new_student_ime']) || !isset($_POST['new_student_prezime']) || !isset($_POST['new_student_telefon']) || !isset($_POST['new_student_email']) || !isset($_POST['new_student_fakultet']) || !isset($_POST['new_student_ocjene']) || !isset($_POST['new_student_sati']) || !isset($_FILES['new_student_zivopis']) ) throw new Exception( 'add_student :: Values are not properly set.' );

		$username = $_POST['new_student_username'];
		$password_hash = password_hash($_POST['new_student_password'], PASSWORD_DEFAULT);
		$ime = $_POST['new_student_ime']; 
		$prezime = $_POST['new_student_prezime']; 
		$broj_telefona = $_POST['new_student_telefon'];
		$email = $_POST['new_student_email'];
		$fakultet = $_POST['new_student_fakultet'];
		$prosjek_ocjena = $_POST['new_student_ocjene'];
		$broj_slobodnih_sati_tjedno = $_POST['new_student_sati'];
		$zivotopis = $this->upload_file(); //id nam vrati

		if( $zivotopis === false ) throw new Exception( 'add_student :: File was not uploaded properly.' );


		//provjerimo postoji li već student s takvim usernameom (ne može biti)
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_students WHERE username=:username' );
			$st->execute( 'username' => $username );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() );
		if( $st->fetch() !== false ) throw new Exception( 'add_student :: Username already exist.' );


		//kreiramo novi jedinstveni id
		$id = 1;
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id FROM studentplus_students' );
			$st->execute( );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() );
		while( $row = $st->fetch() ) $id++;


		//registriramo usera
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO studentplus_students(id, username, password, ime, prezime, broj_telefona, email, fakultet, prosjek_ocjena, broj_slobodnih_sati_tjedno, zivotopis) VALUES (:id, :username, :password, :ime, :prezime, :broj_telefona, :email, :fakultet, :prosjek_ocjena, :broj_slobodnih_sati_tjedno, :zivotopis)' );
			$st->execute( array( 'id' => $id, 'username' => $username, 'password' => $password_hash, 'ime' => $ime, 'prezime' => $prezime, 'broj_telefona' => $broj_telefona, 'email' => $email, 'fakultet' => $fakultet, 'prosjek_ocjena' => $prosjek_ocjena, 'broj_slobodnih_sati_tjedno' => $broj_slobodnih_sati_tjedno, 'zivotopis' => $zivotopis ) );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() ); 
	}




	/*
	------------------- FILES --------------------
	*/
	//dodaj file u bazu
	function upload_file(){
		$filename = $_FILES['new_student_zivopis']['name'];
		$destination = 'uploads/' . $filename;
		$extension = pathinfo( $filename, PATHINFO_EXTENSION );

		$file = $_FILES['new_student_zivopis']['tmp_name'];
		$size = $_FILES['new_student_zivopis']['size'];

		//kreiramo novi jedinstveni id
		$id = 1;
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id FROM studentplus_files' );
			$st->execute( );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() );
		while( $row = $st->fetch() ) $id++;	
			

		//upload
	    if(!in_array($extension, ['zip', 'pdf', 'docx'])) echo "You file extension must be .zip, .pdf or .docx";
	    elseif ($_FILES['new_student_zivopis']['size'] > 1000000) echo "File too large!"; //ne više od 1mb
	    else{
	        // move the uploaded (temporary) file to the specified destination
	        if (move_uploaded_file($file, $destination)) {
	            try{
					$db = DB::getConnection();
					$st = $db->prepare( 'INSERT INTO studentplus_files (id, name, size, downloads) VALUES (:id, :name, :size, :downloads)' );
					$st->execute( array( 'id' => $id, 'name' => $filename, 'size' => $size, 'downloads' => 0) );

					echo "File uploaded successfully";
	            	return $id;
				}
				catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() );
	        } 
	        else echo "Failed to upload file.";
	        return false;
	    }
	}

	//dohvati file po njegovom id-u (id je spremljen u studenta)
	function get_file_by_id($id){
	    try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_files WHERE id=:id' );
			$st->execute( array( 'id' => $id) );

			$row = $st->fetch();
			if( $row === false ) return null;
			else return mysqli_fetch_all( $row, MYSQLI_ASSOC );
		}
		catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() );
	}

	//skini file (link - u tablici za tvrtke)
	function download_file_by_id($id){
		$result = $this->get_file_by_id($id);

		$file = mysqli_fetch_assoc($result);
		$filepath = 'uploads/' . $file['name'];

		if (file_exists($filepath)){
	        header('Content-Description: File Transfer');
	        header('Content-Type: application/octet-stream');
	        header('Content-Disposition: attachment; filename=' . basename($filepath));
	        header('Expires: 0');
	        header('Cache-Control: must-revalidate');
	        header('Pragma: public');
	        header('Content-Length: ' . filesize('uploads/' . $file['name']));
	        readfile('uploads/' . $file['name']);

	        //now update downloads count
	        $new_count = $file['downloads'] + 1;
	        try{
				$db = DB::getConnection();
				$st = $db->prepare( 'UPDATE studentplus_files SET downloads=:downloads WHERE id=:id' );
				$st->execute( array( 'downloads' => $new_count, 'id' => $id ) );
			}
			catch( PDOException $e ) exit( 'PDO error ' . $e->getMessage() );

        	exit;
    	}
	}

};

?>
