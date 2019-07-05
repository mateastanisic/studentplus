<?php

class studentplus_service {

	/*
	---------------------DOHVATI PODATKE O PONUDI------------------------
	*/
	//vraća polje svih ponuda (od svih tvrtki)
	function get_all_offers(){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_offers ORDER BY id' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ) ; } 

		//polje za spremanje svih ponuda
		while( $row = $st->fetch() ){
			//pronađimo ime tvrtke koja oglašava ovu ponudu
			$name = $this->get_companyname_by_oib($row['oib']);
			$offers[] = new Offer( $row['id'], $name, $row['name'], $row['description'], $row['adress'], $row['period'] );
		}
		return $offers;
	}

	//vraća ponudu s poslanim id-om
	function get_offer_by_id($id){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_offers WHERE id=:id ORDER BY id' );
			$st->execute( array('id' => $id ));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false ) return null;
		else{
			$name = $this->get_companyname_by_oib($row['oib']);
			return new Offer( $row['id'], $name, $row['name'], $row['description'], $row['adress'], $row['period'] );
		} 
	}

	//vraća sve ponude tvrtke s poslanim oib-om (tj dohvati sve ponude neke tvrtke)
	function get_offers_by_oib($oib){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_offers WHERE oib=:oib ORDER BY id' );
			$st->execute( array('oib' => $oib ));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		//polje za spremanje svih ponuda
		$offers = array();
		//pronađimo ime tvrtke koja oglašava ovu ponudu
		$name = $this->get_companyname_by_oib($oib);
		while( $row = $st->fetch() ){
			$offers[] = new Offer( $row['id'], $name, $row['name'], $row['description'], $row['adress'], $row['period'] );
		}
		return $offers;
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

	//vraća sve ponude koje u imenu sadržavaju podstring $ime 
	function get_offers_by_podstring_name($ime){
		$offers = $this->get_all_offers();
		$found = array();

		for( $i = 0; $i<count($offers); $i++ ){
			if( strpos( $offers[i]->ime, $ime) !== false ) $found[] = $offers[i];
		}
		return $found;
	}

	//vraća sve ponude čije ime je JEDNAKO varijabli $name 
	function get_offers_by_name($name){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_offers WHERE name=:name ORDER BY id' );
			$st->execute( array( 'name' => $name ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		//polje za spremanje svih ponuda
		$offers = array();
		while( $row = $st->fetch() ){
			//pronađimo ime tvrtke koja oglašava ovu ponudu
			$company = $this->get_companyname_by_oib($row['oib']);
			$offers[] = new Offer( $row['id'], $company, $row['name'], $row['description'], $row['adress'], $row['period'] );
		}
		return $offers;
	}

	//vraća polje svih ponuda kojima sam poslao zahtjev (bez obzira na status)
	function get_accepted_offers_by_id($id_student){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_members WHERE id_student=:id_student ORDER BY id_student' );
			$st->execute( array( 'id_student' => $id_student ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		//polje za spremanje svih ponuda
		$offers = array();
		while( $row = $st->fetch() ){

			if ($row['status'] !== '1') continue;

			$jedna_ponuda = $this->get_offer_by_id($row['id_offer']);
			if( $jedna_ponuda === null ) continue;
			$offers[] = $jedna_ponuda;
		}
		return $offers;
	}	

		//vraća polje svih ponuda kojima sam poslao zahtjev (bez obzira na status)
	function get_pending_offers_by_id($id_student){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_members WHERE id_student=:id_student ORDER BY id_student' );
			$st->execute( array( 'id_student' => $id_student ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		//polje za spremanje svih ponuda
		$offers = array();
		while( $row = $st->fetch() ){

			if ($row['status'] !== '0') continue;

			$jedna_ponuda = $this->get_offer_by_id($row['id_offer']);
			if( $jedna_ponuda === null ) continue;
			$offers[] = $jedna_ponuda;
		}
		return $offers;
	}

		//vraća polje svih ponuda kojima sam poslao zahtjev (bez obzira na status)
	function get_rejected_offers_by_id($id_student){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_members WHERE id_student=:id_student ORDER BY id_student' );
			$st->execute( array( 'id_student' => $id_student ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		//polje za spremanje svih ponuda
		$offers = array();
		while( $row = $st->fetch() ){

			if ($row['status'] !== '-1') continue;

			$jedna_ponuda = $this->get_offer_by_id($row['id_offer']);
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
			$st = $db->prepare( 'SELECT * FROM studentplus_companies WHERE oib=:oib ORDER BY oib' );
			$st->execute( array( 'oib' => $oib ) );
		}
		catch( PDOException $e ) { 
			exit( 'PDO error ' . $e->getMessage() ); 
		}

		$row = $st->fetch();
		if( $row === false ) return null;
		else{
			return new Company( $row['oib'], $row['password'], $row['name'], $row['email'], $row['adress'], $row['phone'], $row['description'] );
		} 
	}

	//vraća ime tvrtke s poslanim oib-om
	function get_companyname_by_oib($oib){
		//probaj naći oib među tvrtkama
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT name FROM studentplus_companies WHERE oib=:oib' );
			$st->execute( array( 'oib' => $oib ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false ) return null;
		else return $row['name'];
	}

	//vraća ime tvrtke koja je postavila određenu ponudu
	function get_companyname_by_offerid($id){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT oib FROM studentplus_offers WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

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
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

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
			$st = $db->prepare( 'SELECT * FROM studentplus_students WHERE id=:id ORDER BY id' );
			$st->execute( array('id' => $id ) );
		}
		catch( PDOException $e ) { 
			exit( 'PDO error ' . $e->getMessage() ); 
		}

		$row = $st->fetch();
		if( $row === false ) return null;
		else{
			return new Student( $row['id'], $row['username'], $row['password'], $row['name'], $row['surname'], $row['email'], $row['phone'], $row['school'], $row['grades'], $row['free_time'], $row['cv'] );
		} 
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

	// vraća id studenta s određenim username-om
	function get_id_by_username($username){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id FROM studentplus_students WHERE username=:username' );
			$st->execute( array( 'username' => $username ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

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
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false ) return null;
		else return $row['password'];
	}



	/*
	-------------------DOHVATI PODATKE O MEMBERIMA--------------------
	*/
	//vraća polje svih članova (-1/0/1) neke ponude čiji id šaljemo
	function get_students_in_offer_by_id($id_offer){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_members WHERE id_offer=:id_offer ORDER BY id_offer' );
			$st->execute( array( 'id_offer' => $id_offer ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		//polje za spremanje svih ponuda
		$members = array();

		while( $row = $st->fetch() ){
			//pronađimo studenta s danim id-om
			$student = $this->get_student_by_id($row['id_student']);
			if( $student === null ) continue;
			$members[] = $student;
		}
		return $members;
	}

	//vraća polje svih  članova koji su podnijeli zahtjev (za koje još nismo odlučili što ćemo s njima)
	function get_pending_students_in_offer($id_offer){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_members WHERE id_offer=:id_offer ORDER BY id_offer' );
			$st->execute( array( 'id_offer' => $id_offer ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		//polje za spremanje svih ponuda
		$pending = array();

		while( $row = $st->fetch() ){
			//ako nije pending preskoči
			if( $row['status'] !== '0' ) continue;

			//pronađimo studenta s danim id-om
			$student = $this->get_student_by_id($row['id_student']);
			if( $student === null ) continue;
			$pending[] = $student;
		}
		return $pending;
	}

	//vraća polje svih  članova koji su podnijeli zahtjev (i koje je tvrtka prihvatila)
	function get_accepted_students_in_offer($id_offer){
		//polje za spremanje svih ponuda
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_members WHERE id_offer=:id_offer ORDER BY id_offer' );
			$st->execute( array( 'id_offer' => $id_offer ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }		
		$accepted = array();

		while( $row = $st->fetch() ){
			//ako nije accepted preskoči
			if( $row['status'] !== '1' ) continue;

			//pronađimo studenta s danim id-om
			$student = $this->get_student_by_id($row['id_student']);
			if( $student === null ) continue;
			$accepted[] = $student;
		}
		return $accepted;
	}


	//vraća polje svih  članova koji su podnijeli zahtjev (i koje je tvrtka odbila)
	function get_rejected_students_in_offer($id_offer){
		//polje za spremanje svih ponuda
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_members WHERE id_offer=:id_offer ORDER BY id_offer' );
			$st->execute( array( 'id_offer' => $id_offer ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		$rejected = array();

		while( $row = $st->fetch() ){
			//ako nije rejected preskoči
			if( $row['status'] !== '-1' ) continue;

			//pronađimo studenta s danim id-om
			$student = $this->get_student_by_id($row['id_student']);
			if( $student === null ) continue;
			$rejected[] = $student;
		}
		return $rejected;
	}

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



	/*
	------------------- UPDATE AND INSERT IN DB --------------------
	*/
	//obradi prijavu studenta za neku ponudu
	function asign_student_to_offer($id_student, $id_offer){
		//dodajmo studenta u member
		$tvrtka = $this->get_companyname_by_offerid($id_offer);
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO studentplus_members(id_student, id_offer, status) VALUES (:id_student, :id_offer, :status)' );
			$st->execute( array( 'id_student' => $id_student, 'id_offer' => $id_offer, 'status' => '0' ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); 
		}

	}

	//obradi prihvaćanje/odbijanje studenta
	function change_status( $status, $id_student, $id_offer ){
		//moramo actually mjenjati nešto
		if( $status !== -1 && $status !== 1 ) throw new Exception( 'change_status :: Status value is not valid.' );

		//provjeri postoji li takav member
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM studentplus_members WHERE id_student=:id_student AND id_offer=:id_offer' );
			$st->execute( array( 'id_student' => $id_student,  'id_offer' => $id_offer ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		if( $st->rowCount() !== 1 ) throw new Exception( 'change_status :: Member with the given id in the given Offer does not exist.' );

		//update db
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE studentplus_members SET status=:status WHERE id_student=:id_student AND id_offer=:id_offer' );
			$st->execute( array( 'status' => $status, 'id_student' => $id_student,  'id_offer' => $id_offer ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	//dodaj novu ponudu u bazu
	function add_offer($company, $name, $description, $adress, $period){
		//dodajmo ponudu u studentplus_offers
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO studentplus_offers(oib, name, description, adress, period) VALUES (:oib, :name, :description, :adress, :period)' );
			$st->execute( array( 'oib' => $company, 'name' => $name, 'description' => $description, 'adress' => $adress, 'period' => $period ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	//registracija tvrtke
	function add_company($oib, $password_hash, $name, $email, $adress, $phone, $description ){
		//registracija tvrtke
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO studentplus_companies(oib, password, name, email, adress, phone, description ) VALUES (:oib, :password, :name, :email, :adress, :phone, :description)' );
			$st->execute( array( 'oib' => $oib, 'password' => $password_hash, 'name' => $name, 'email' => $email, 'adress' => $adress, 'phone' => $phone, 'description' => $description) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	//registracija studenta
	function add_student($username, $password_hash, $name, $surname, $email, $phone, $school, $grades, $free_time, $cv ){
		if( $cv === false ) throw new Exception( 'add_student :: File was not uploaded properly.' );

		//registriramo usera
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO studentplus_students(username, password, name, surname, email, phone, school, grades, free_time, cv) VALUES (:username, :password, :name, :surname, :email, :phone, :school, :grades, :free_time, :cv)' );
			$st->execute( array('username' => $username, 'password' => $password_hash, 'name' => $name, 'surname' => $surname, 'email' => $email, 'phone' => $phone, 'school' => $school, 'grades' => $grades, 'free_time' => $free_time, 'cv' => $cv ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}




	/*
	------------------- FILES --------------------
	*/
	//dodaj file u bazu
	function upload_file(){
		$filename = $_FILES['new_student_cv']['name'];
		$destination = __DIR__.'/uploads/' . $filename;
		$extension = pathinfo( $filename, PATHINFO_EXTENSION );

		$file = $_FILES['new_student_cv']['tmp_name'];
		$size = $_FILES['new_student_cv']['size'];

		//kreiramo novi jedinstveni id
		$id = 1;
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id FROM studentplus_files' );
			$st->execute( );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		while( $row = $st->fetch() ) $id++;	
			

		//upload
	    if(!in_array($extension, ['zip', 'pdf', 'docx', 'txt'])) echo "Your file extension must be .zip,.txt, .pdf or .docx";
	    elseif ($_FILES['new_student_cv']['size'] > 1000000) echo "File too large!"; //ne više od 1mb
	    else{
	        // move the uploaded (temporary) file to the specified destination
	        if (move_uploaded_file($file, $destination) ) {
	            try{
					$db = DB::getConnection();
					$st = $db->prepare( 'INSERT INTO studentplus_files (id, name, size) VALUES (:id, :name, :size)' );
					$st->execute( array( 'id' => $id, 'name' => $filename, 'size' => $size) );

					echo "File uploaded successfully";
	            	return $id;
				}
				catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	        } 
	        else {
	        	echo "Failed to upload file.";
	        	echo "filename " . $filename;
	        	echo " extension" . $extension;
	        	echo $_FILES['new_student_cv']['error'];
	        }
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
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

};

?>