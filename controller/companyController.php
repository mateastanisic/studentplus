<?php 

class CompanyController extends BaseController{

	//obradi logout
	public function logout(){
		//kontroler za provođenje logout-a
		unset($_SESSION['login']); 
		unset($_SESSION['offer']);
		unset($_SESSION['student']);
		unset($_POST['oib']);
		unset($_POST['password']);
		unset($_POST['name']);
		unset($_POST['email']);
		unset($_POST['phone']);
		unset($_POST['adress']);
		unset($_POST['description']);
		unset($company);
		$noone_logged = true;

		session_unset(); 
		session_destroy();

		$this->registry->template->title = 'Dashboard!';
		$this->registry->template->show('dashboard_index');
	}


	//obradi login
	public function check_login(){
		//kontroler za provođenje logina
		$spp = new studentplus_service();

		if(isset($_POST['oib'])){ //napisan je oib
			//SANITIZACIJA?????

			//provjeri je li oib u bazi
			if( $spp->get_company_by_oib($_POST['oib']) === null ){
				echo "Company with oib ". $_POST['oib'] ."  is not registred.";

				$this->registry->template->title = 'Dashboard!';
				$this->registry->template->show( 'dashboard_index' );
				exit();
			}

			//dohvati lozinku tog studenta
			$pass = $spp->get_password_by_oib( $_POST['oib'] );

			if(isset( $_POST['password'] )){
				if( password_verify($_POST['pass'], $pass) ){
					//lozinka je dobra
					session_start();

					//zapamti ulogiranog korisnika
					$_SESSION['login'] = $_POST['oib'];
					$noone_logged = false;

					//odi prikupi info o svim ponudama
					$this->all_offers();
					exit();
				}
				else{
					echo "Login failed."
					header( 'Location: ' . __SITE_URL . '/index.php?rt=index/all_offers' );
					exit();
				} 
			}
		}
	}


	//obradi register
	public function check_register(){
		if( isset($_POST['new_company_oib']) && isset($_POST['new_company_password']) && isset($_POST['new_company_name']) && isset($_POST['new_company_email']) && isset($_POST['new_company_adress']) && isset($_POST['new_company_phone']) && isset($_POST['new_company_description']) ){

			$oib = $_POST['new_company_oib'];
			$password_hash = password_hash($_POST['new_company_password'], PASSWORD_DEFAULT);
			$name = $_POST['new_company_name']; 
			$email = $_POST['new_company_email'];
			$adress = $_POST['new_company_adress'];
			$phone = $_POST['new_company_phone'];
			$description = $_POST['new_company_description'];

			$spp = new studentplus_service();

			if( $spp->get_company_by_oib($oib) !== null ){
				echo 'Company already exists!';
				header( 'Location: ' . __SITE_URL . '/index.php?rt=index/all_offers' );
				exit();
			}

			$spp->add_company($oib, $password_hash, $name, $email, $adress, $phone, $description );

			//kao da je ulogiran
			session_start();

			//zapamti ulogiranog korisnika
			$_SESSION['login'] = $_POST['oib'];
			$noone_logged = false;

			//odi prikupi info o svim ponudama
			$this->all_offers();
			exit();

		}
	}


	//provjerava na koje smo dugme stisnuli
	public function check_button_choice(){
		if(isset($_POST['logout'])){
			$this->logout();
			exit();
		}
		if(isset($_POST['button'])){
			if($_POST['button'] === 'dashboard'){
				//uništi $_SESSION['offer']
				unset($_SESSION['offer']);

				//vrati se na naslovnicu
				$this->registry->template->title = 'Company Dashboard!';
				$this->registry->template->show( 'logdash_index' );
				exit();
			}
			if($_POST['button'] === 'ours'){
				//uništi $_SESSION['offer']
				unset($_SESSION['offer']);

				//prikaži ponude koje je tvrtka objavila
				$this->company_offers();
				exit();
			}
			if($_POST['button'] === 'make_new'){
				//uništi $_SESSION['offer']
				unset($_SESSION['offer']);

				//prikaži formu za pravljenje nove ponude
				$this->registry->template->show( 'new_offer' );
				exit();
			}
			if( substr($_POST['button'], 0, 17 ) === 'students_in_offer_' ){
				//stisnuli smo na neki button da želimo vidjeti sve studente koji su se prijavili na tu ponudu
				$this->show_students();

			}
			if( substr($_POST['button'], 0, 16 ) === 'student_in_offer_' ){
				//stisnuli smo na neki button da želimo vidjeti profil studenta s nekim id-om
				$this->show_profil();

			}
			if( $_POST['button'] === 'accept' ){
				$spp = new studentplus_service();

				if( !isser($_SESSION['student']) || !isser($_SESSION['offer'])  ){
					echo 'Not all variables set!';
					$this->all_offers();
				} 
				$spp->change_status( 1, $_SESSION['student'], $_SESSION['offer'] );
				$this->show_students();
			}
			if( $_POST['odbiji'] === 'reject'){
				$spp = new studentplus_service();

				if( !isser($_SESSION['student']) || !isser($_SESSION['offer'])  ){
					echo 'Not all variables set!';
					$this->all_offers();
				} 
				$spp->change_status( -1, $_SESSION['student'], $_SESSION['offer'] );
				$this->show_students();
			}
			if( isset($_GET['file_id']) ){
				//downloadanje zivotopisa
				$id = $_GET['file_id'];

			    $spp = new studentplus_service();
			    $result = $spp->get_file_by_id($id);
			    $file = mysqli_fetch_assoc($result);

			    $filepath = 'uploads/' . $file['name'];

			    if (file_exists($filepath)) {
			        header('Content-Description: File Transfer');
			        header('Content-Type: application/octet-stream');
			        header('Content-Disposition: attachment; filename=' . basename($filepath));
			        header('Expires: 0');
			        header('Cache-Control: must-revalidate');
			        header('Pragma: public');
			        header('Content-Length: ' . filesize('uploads/' . $file['name']));
			        readfile('uploads/' . $file['name']);
			        exit;
			    }
			}

		}
	}


	//dohvaća sve ponude
	public function all_offers(){
		$spp = new studentplus_service();

		$offers = $spp->get_all_offers();
		$this->registry->template->offers = $offers;
		unset($_SESSION['offer']);
		$company_logged = get_company_by_oib($_SESSION['login']); //sa ovim u viewu saznajemo je li student ili tvrtka

		//sad znaš koje su sve ponude i koji je user(sve potrebne info za obični dashboard)  -- odi na logdash_index.php
		$this->registry->template->title = 'Company Dashboard!';
		$this->registry->template->show( 'logdash_index' );
	}


	//ide kad stisnemo da želimo vidjeti sve ponude koje je ta tvrtka napravila
	public function company_offers(){
		$spp = new studentplus_service();

		$company_offers = $spp->get_offers_by_oib( $_SESSION['login'] );
		$this->registry->template->company_offers = $company_offers;
		unset($_SESSION['offer']);

		//sad znaš koje su sve ponude i koji je user(sve potrebne info za obični dashboard)  -- odi na logdash_index.php
		$this->registry->template->title = 'Company Offers!';
		$this->registry->template->show( 'company_offers' );	
	}


	//ide poslije ispunjavanja forme za pravljenje nove ponude
	public function check_new_offer(){
		if( isset($_POST['dashboard']) ){
			$this->all_offers();
			exit();
		}
		else if( isset($_POST['new_offer_name']) && isset($_POST['new_offer_description']) && isset($_POST['new_offer_adress']) && isset($_POST['new_offer_period']) ){

			$company = $_SESSION['login'];
			$name = $_POST['new_offer_name']; 
			$description = $_POST['new_offer_description'];
			$adress = $_POST['new_offer_adress'];
			$period = $_POST['new_offer_period'];

			$spp = new studentplus_service();
			$spp->add_offer($company, $name, $description, $adress, $period);

			$offer = $spp->get_offers_by_name($_POST['new_offer_name']);
			$_SESSION['offer'] = $offer->id;

			$this->all_offers();
			exit();
			
		}
	}


	//svi studenti koji su se prijavili na neku ponudu
	public function show_students(){
		if( !isset($_SESSION['offer']) ){
			$extract_offerid = substr($_POST['button'], 18); //npr students_in_offer_1 - vrati nam natrag 1

			//provjeri postoji li ta ponuda
			if( get_offer_by_id($extract_offerid) === null ){
				echo 'Id not valid.';
				$this->all_offers();
				exit();
			}
			//spremi o kojoj ponudi se radi
			$_SESSION['offer'] = $extract_offerid;
		}
		unset($_SESSION['student']);

		$students_in_offer = get_students_in_offer_by_id($_SESSION['offer']);

		$this->registry->template->title = 'Offer Students!';
		$this->registry->template->show('offer_students');
	}


	//profil studenta
	public function show_profil(){
		$extract_studentid = substr($_POST['button'], 17); //npr student_in_offer_1 - vrati nam natrag 1

		//provjeri postoji li takav student
		if( get_student_by_id($extract_studentid) === null ){
			echo 'Id not valid.';
			$this->all_offers();
			exit();
		}

		//spremi o kojem studentu se radi
		$_SESSION['student'] = $extract_studentid;

		$student_in_offer = get_student_by_id($extract_studentid);

		$this->registry->template->title = 'Student Profile!';
		$this->registry->template->show('student_profil'); 
	}

}; 

