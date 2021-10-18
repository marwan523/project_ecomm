<?php
  
	ini_set('display_errors', 'on');
	error_reporting(E_ALL);	



	include "admin/connectdb.php";


	$sessionUser = '';
	if(isset($_SESSION['user'])){
		$sessionUser = $_SESSION['user'];
	}
	//this is routes
	$tbl = "includes/templates/";
	$langs = "includes/languages/";	
	$func = "includes/functions/";
	$css = "layout/css/";
	$js = "layout/js/";

	//important file 
	include $langs . "english.php";	
	include $func . "functions.php";
    include $tbl . "header.php";






	



	





?>