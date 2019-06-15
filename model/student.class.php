<?php

class Student{
	
	protected $id, $username, $password, $ime, $prezime, $broj_telefona, $email, $fakultet, $prosjek_ocjena, $broj_slobodnih_sati_tjedno, $zivotopis;

	function __construct( $id, $username, $password, $ime, $prezime, $broj_telefona, $email, $fakultet, $prosjek_ocjena, $broj_slobodnih_sati_tjedno, $zivotopis ){
		$this->id = $id;
    	$this->username = $username;
		$this->ime = $ime;
		$this->prezime = $prezime;
		$this->broj_telefona = $broj_telefona;
		$this->email = $email;
    	$this->fakultet = $fakultet;
    	$this->prosjek_ocjena = $prosjek_ocjena;
		$this->broj_slobodnih_sati_tjedno = $broj_slobodnih_sati_tjedno;
    	$this->zivotopis = $zivotopis;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
