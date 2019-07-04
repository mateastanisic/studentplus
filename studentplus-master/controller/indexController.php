<?php 


class IndexController extends BaseController
{

	//samo preusmjeri na dashboard
	public function index() {
		unset($_SESSION['checked']);
		//$this->registry->template->show( '404_index' );
		header( 'Location: ' . __SITE_URL . '/index.php?rt=index/all_offers' );	
	}

	//dohvaća sve ponude
	public function all_offers(){


		$spp = new studentplus_service();

		$offers = $spp->get_all_offers();
		$this->registry->template->offers = $offers;
		unset($_SESSION['offer']);
		$noone_logged = true;

		//sad znaš koje su sve ponude i koji je user(sve potrebne info za obični dashboard)  -- odi na logdash_index.php
		$this->registry->template->title = 'Dashboard!';
		$this->registry->template->show( 'dashboard_index' );
	} 

	//ako se stisnuo button login/register
	public function check_button_choice(){
		if( isset($_POST['login']) ){
			$_SESSION["checked"] = "yes";
			$this->registry->template->title = 'Login!';
			$this->registry->template->show( 'login' );
			
		}
		if( isset($_POST['register']) ){
			$_SESSION["checked"] = "yes";
			$this->registry->template->title = 'Register!';
			$this->registry->template->show( 'register' );
		}
	}

	//procesuiraj login
	public function check_login_type(){
		if( isset($_POST['dashboard']) ){
			$this->all_offers();
		}
		if( isset($_POST['odabir']) ){

			if ($_POST['odabir'] === 'student'){
				header( 'Location: ' . __SITE_URL . '/index.php?rt=student/check_login' );
				exit();
			}

			else if( $_POST['odabir'] === 'company' ){
				header( 'Location: ' . __SITE_URL . '/index.php?rt=company/check_login' );
				exit();
			}
		echo 'Neuspjeli login!';
		$this->all_offers();
		}
	}

	//procesuiraj register
	public function check_register_type(){

		$this->komentar = "usli u check register type index";

		if( isset($_POST['dashboard']) ){
			$this->komentar.= "tu sam";
			$this->all_offers();
		}

		if( isset($_POST['odabir']) ){

			if( $_POST['odabir'] === "student"){

				echo "Usao u odabir student", "<br>";
		
				//$spp = new studentplus_service();
				//$cv = $spp->upload_file(); //id nam vrati

				echo "Nakon upload cv file", "<br>";

				header( 'Location: ' . __SITE_URL . '/index.php?rt=student/check_register' );
				exit();

			}

			else if( $_POST['odabir'] === "company" ){
				echo "odabir kompanije";
				header( 'Location: ' . __SITE_URL . '/index.php?rt=company/check_register' );
				exit();
				}
		}
		
		echo 'Neuspjeli register!';
		$this->all_offers();
	}

	public function search_results() {

		$spp = new studentplus_service();

		$offers = $spp->get_offers_by_name($_POST['search']);
		//$results_podstring = $spp->get_offers_by_podstring_name();

		$this->registry->template->offers = $offers;
		//$this->registry->template->title = $results_podstring;

		$this->registry->template->show( 'dashboard_index' );
	}
}; 

?>