<?php

    try{
		session_start();
		session_unset();
		session_destroy();
		setcookie("PHPSESSID",session_id(),time()-1);
	}catch(Exception $e)
	{
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
    header("Location: rh/index.php");
?>