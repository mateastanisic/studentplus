<?php

class Offer{

	protected $id, $tvrtka, $ime, $opis, $lokacija, $razdoblje;

	function __construct( $id, $tvrtka, $ime, $opis, $lokacija, $razdoblje ){
		$this->id = $id;
    	$this->tvrtka = $tvrtka;
		$this->ime = $ime;
		$this->opis = $opis;
		$this->lokacija = $lokacija;
		$this->razdoblje = $razdoblje;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
