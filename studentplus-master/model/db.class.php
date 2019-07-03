<?php
class DB
{
	private static $db = null;

	private function __construct() { }
	private function __clone() { }

	public static function getConnection()
	{
		if( DB::$db === null )
	    {
	    	try
	    	{
	    		//podatke o studentima, tvrtkama, prijavama i ponudama ćemo spremiti na rp2 serveru u bazu podataka 'stanisic'
	    		//ovdje "otvaramo" tu bazu
		    	DB::$db = new PDO( "mysql:host=rp2.studenti.math.hr;dbname=stanisic;charset=utf8", 'student', 'pass.mysql' );
		    	DB::$db-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
		    catch( PDOException $e ) { exit( 'PDO Error: ' . $e->getMessage() ); }
	    }
		return DB::$db;
	}
}

?>
