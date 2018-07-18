<?php

$name= $_GET['name'];
$filepath= $_GET['filepath'];


if(isset($_GET['uploads'])){
	$filepath ="uploads/". $filepath;
}
// ob_clean();
// flush();
$configs = include('../common/guiCommon.php');
$fileName = $filepath."/".$name;
    header('Content-Description: File Transfer');
    header('Content-Type: application/force-download');
//       header('Content-Type: application/pdf');
    header("Content-Disposition: attachment; filename=\"" . basename($fileName) . "\";");
   header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    
    header('Content-Length: ' . filesize($fileName));
     ob_clean();
//        flush();
    
//     echo $fileName;
//      echo file_get_contents($filename);
    readfile($fileName); //showing the path to the server where the file is to be download
//      flush();
    exit;
?>