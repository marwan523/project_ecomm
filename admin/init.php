<?php
  
	include "connectdb.php";


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





	//include navbar expect the one with $nonavbar 
	if(!isset($nonavbar))
	{
		include $tbl . "navbar.php";
	}
	

?>