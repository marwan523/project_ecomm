<?php 
	$do = '';

	if(isset($_GET["do"]))
	{
		$do = $_GET["do"];


	}

    else
	{
		$do = "manage";
	}

	if($do == "manage")
	{
		echo "welcom m";
		echo "<a href='page.php?do=add'>add new cat..</a>";
	}
	elseif ($do == "add")
	{
		echo "add";
	}
	elseif ($do == "insert")
	{
		echo "insert";
	}	
	else
	{
		echo "err";
	}
