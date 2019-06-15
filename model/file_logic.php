<? php

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

	//in html:
	// ? php include 'file_logic.php'; ?  
	

?>