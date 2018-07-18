<?php
 
    $name= $_GET['name'];
    $filepath= $_GET['filepath'];
    
   // $configs = include('../common/guiCommon.php');
//     $file_name = $configs->appURL.$filepath."/".$name;
    $file_name = "../".$filepath."/".$name;
  
    // make sure it's a file before doing anything!
     if(is_file($file_name)) {

    	// required for IE
    	if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}
    
    	// get the file mime type using the file extension
    	switch(strtolower(substr(strrchr($file_name, '.'), 1))) {
    		case 'pdf': ;
    		case 'PDF': $mime = 'application/pdf'; break;
    		case 'zip': $mime = 'application/zip'; break;
    		case 'csv': $mime = 'application/csv'; break;
    		case 'jpeg':
    		case 'jpg': $mime = 'image/jpg'; break;
    		default: $mime = 'application/force-download';
    	}
    	header('Pragma: public'); 	// required
    	header('Expires: 0');		// no cache
    	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      	header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file_name)).' GMT');
    	header('Cache-Control: private',false);
    	header('Content-Type: '.$mime);
    	header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
    	header('Content-Transfer-Encoding: binary');
    	header('Content-Length: '.filesize($file_name));	// provide file size
    	header('Connection: close');
    	readfile($file_name);		// push it out
    	exit();
    
    }
?>