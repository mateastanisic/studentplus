<?php 

class StudentController extends BaseController{

	public function index() {}

	//obradi logout
	public function logout(){
		//kontroler za provođenje logout-a
		unset($_SESSION['login']); 
		unset($_SESSION['offer']);
		unset($_POST['username']);
		unset($_POST['password']);
		unset($_POST['name']);
		unset($_POST['surname']);
		unset($_POST['email']);
		unset($_POST['phone']);
		unset($_POST['school']);
		unset($_POST['grades']);
		unset($_POST['free_time']);
		unset($_POST['cv']);
		unset($student);
		$noone_logged = true;
		$who_dis = 'nitko';
		$_SESSION['who'] = 'nitko';

		session_unset(); 
		session_destroy();

		$spp = new studentplus_service();
		$offers = $spp->get_all_offers();
		$this->registry->template->offers = $offers;

		$this->registry->template->title = 'Dashboard!';
		$this->registry->template->show( 'dashboard_index' );
	}


	//obradi login
	public function check_login(){
		//kontroler za provođenje logina
		$spp = new studentplus_service();

		if(isset($_POST['username'])){ //napisan je username
			//SANITIZACIJA?????

			//provjeri je li username u bazi
			if( $spp->get_id_by_username($_POST['username']) === null ){
				echo "Student with username". $_POST['username'] ." is not registred.";

				$this->registry->template->title = 'Dashboard!';
				$this->registry->template->show( 'dashboard_index' );
				exit();
			}

			//dohvati lozinku tog studenta
			$pass = $spp->get_password_by_username( $_POST['username'] );


			if(isset( $_POST['pass'] )){
				if( password_verify($_POST['pass'], $pass) ){
					//lozinka je dobra
					
					if (!isset($_SESSION)) {
						session_start();
					}

					//zapamti ulogiranog korisnika
					$_SESSION['login'] = $_POST['username'];
					$noone_logged = false;
					$who_dis = 'student';
					$_SESSION['who'] = 'student';

					//odi prikupi info o svim ponudama
					$this->all_offers();
					exit();
				}
				else{
					echo "Login failed.";
					header( 'Location: ' . __SITE_URL . '/index.php?rt=index/all_offers' );
					exit();
				} 
			}
		}
	}


	//obradi registraciju
	public function check_register(){

		echo "Daj mi bilosta, usao samo u student check register", "<br>";
		echo $_POST["new_student_username"];
		echo isset($_POST['new_student_username']);
		//f( isset($_POST['new_student_username']) && isset($_POST['new_student_password']) && isset($_POST['new_student_name']) && isset($_POST['new_student_email']) && isset($_POST['new_student_surname']) && isset($_POST['new_student_phone']) && isset($_POST['new_student_school']) && isset($_POST['new_student_grades']) && isset($_POST['new_student_free_time']) && isset($_FILES['new_student_cv'] ) && $_FILES['new_student_cv']['error'] == UPLOAD_ERR_OK )

		if( isset($_POST['new_student_username']) )
		{

			$username = $_POST['new_student_username'];
			$password_hash = password_hash($_POST['new_student_password'], PASSWORD_DEFAULT);
			$name = $_POST['new_student_name']; 
			$surname = $_POST['new_student_surname']; 
			$email = $_POST['new_student_email'];
			$phone = $_POST['new_student_phone'];
			$school = $_POST['new_student_school'];
			$grades = $_POST['new_student_grades'];
			$free_time = $_POST['new_student_free_time'];
		
			$spp = new studentplus_service();
			$cv = $spp->upload_file(); //id nam vrati

			echo "Nakon upload file";

			//if( !$cv ){
			//	echo 'Registration failed. File not uploaded properly!';
			//	header( 'Location: ' . __SITE_URL . '/index.php?rt=index/all_offers' );
			//	exit();
			//}

			if( $spp->get_id_by_username($username) !== null ){
				echo 'Registration failed. Username already exists!';
				header( 'Location: ' . __SITE_URL . '/index.php?rt=index/all_offers' );
				exit();
			}

			$spp->add_student($username, $password_hash, $name, $surname, $email, $phone, $school, $grades, $free_time, $cv );
			echo "Dodao je studenta!!!";

			//kao da je ulogiran
			if (!isset($_SESSION)) {
				session_start();
			}

			//zapamti ulogiranog korisnika
			$_SESSION['login'] = $_POST['new_student_username'];
			$noone_logged = false;
			$who_dis = 'student';
			$_SESSION['who'] = 'student';

			//odi prikupi info o svim ponudama
			$this->all_offers();
			exit();

		}
	}


	//studento glavni dashboard
	public function all_offers(){
		$spp = new studentplus_service();

		$offers = $spp->get_all_offers();
		$this->registry->template->offers = $offers;
		unset($_SESSION['offer']);

		$student = $_SESSION['login']; //sa ovim u viewu saznajemo je li student ili tvrtka

		//sad znaš koje su sve ponude i koji je user(sve potrebne info za obični dashboard)  -- odi na logdash_index.php
		$this->registry->template->title = 'Student Dashboard!';
		$this->registry->template->show( 'logdash_index_student' );
	}


	//koji button je stisnuo
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
				$this->all_offers();

				exit();
			}
			if($_POST['button'] === 'applications'){
				//uništi $_SESSION['offer']
				unset($_SESSION['offer']);

				//prikaži ponude na koje se student prijavio
				$this->my_applications();
				exit();
			}
			if( substr($_POST['button'], 0, 21 ) === 'application_in_offer_' ){


				$spp = new studentplus_service();

				$extract_offerid = substr($_POST['button'], 21);//npr application_in_offer_1 - vrati nam natrag 1
				//provjeri postoji li ta ponuda
				if( $spp->get_offer_by_id($extract_offerid) === null ){
					echo 'Id not valid.';
					$this->all_offers();
					exit();
				}
				$_SESSION['offer'] = $extract_offerid;

				//nije postavljen session od username-a ili username nije dobar - netko se igra sa sessionom
				$id = $spp->get_id_by_username($_SESSION['login']);
				if( !isset($_SESSION['login']) || $id === null ){
					echo 'Something is wrong!';
					header( 'Location: ' . __SITE_URL . '/index.php?rt=index/all_offers' );
				} 

				//ne postoji ta ponuda
				if( $spp->get_offer_by_id($_SESSION['offer']) === null ){
					echo 'Offer does not exists!';
					$this->all_offers();
				}

				$spp->asign_student_to_offer($id, $_SESSION['offer'] );
				$this->all_offers();
			}
		}
	}


	//vidi studentove prijave
	public function my_applications(){
		$spp = new studentplus_service();
		
		//netko se igra sa asessionom
		/*if( !isset($_SESSION['offer']) ){
			echo 'Something is wrong!';
			header( 'Location: ' . __SITE_URL . '/index.php?rt=index/all_offers' );
		}*/

		//ne kuzim id kojeg offera?
		//$id_offer = $_SESSION['offer'];

		//u bazi ne postoji takva ponuda
		/*if( $spp->get_offer_by_id($id_offer) === null ){
			echo 'Id not valid.';
			$this->all_offers();
			exit();
		}*/


		$id_student = $spp->get_id_by_username($_SESSION['login']);


		//dohvati podatke o prijavama
		$waiting = $spp->get_accepted_offers_by_id($id_student);
		$accepted = $spp->get_pending_offers_by_id($id_student);
		$rejected = $spp->get_rejected_offers_by_id($id_student);	

		//prikaži ih 
		$this->registry->template->accepted = $accepted;	
		$this->registry->template->waiting = $waiting;
		$this->registry->template->rejected = $rejected;
		
		

		$this->registry->template->title = 'Student Applications!';
		$this->registry->template->show( 'applications' );
	}


}; 

?>
