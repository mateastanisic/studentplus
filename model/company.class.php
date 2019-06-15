<?php

class Company {
	
	protected $oib , $password, $ime, $email, $adresa, $broj_telefona, $opis_tvrtke;

	function __construct( $oib , $password, $ime, $email, $adresa, $broj_telefona, $opis_tvrtke ){
		$this->oib = $oib;
		$this->ime = $ime;
		$this->email = $email;
    	$this->adresa = $adresa;
    	$this->broj_telefona = $broj_telefona;
		$this->opis_tvrtke = $opis_tvrtke;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
