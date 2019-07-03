<?php
if ( isset($_GET['file_id']) ){
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
?>

