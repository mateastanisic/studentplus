<?php

class Member{
	
	protected $id_user, $id_ponuda, $tvrtka, $status;

	function __construct( $id_user, $id_ponuda, $tvrtka, $status ){
		$this->id_user = $id_user;
    	$this->id_ponuda = $id_ponuda;
		$this->tvrtka = $tvrtka;
		$this->status = $status;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
