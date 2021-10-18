<?php 
	//functoin to title v1.0 

    function getitle ()
	{
		global $pageTitle;
		if(isset($pageTitle))
		{
			echo $pageTitle;
		}
		else
		{
			echo "Default";
		}
	}

	/* function to error browse  v1.0*/
	/*function redirectHome ($errormsg, $seconds = 3)
	{
		echo "<div class='alert alert-danger'> $errormsg </div>";
		echo "<div class='alert alert-info'> $seconds </div>";
		header("refresh:$seconds;url=index.php");
		exit(); 
	}*/
	/* function to error browse  v2.0*/
	function redirectHome ($errormsg, $url = null,  $seconds = 3)
	{
		if ($url === null)
		{
			$url = 'index.php';
		}
		else
		{
			if(isset($_SERVER['HTTP_REFERER']) 
				&& $_SERVER['HTTP_REFERER'] !== '')
			{
				$url = $_SERVER['HTTP_REFERER'];
			}
			else
			{
				$url = 'index.php';
			}
			
		}
		echo $errormsg;
		echo "<div class='alert alert-info'> $seconds </div>";
		header("refresh:$seconds;url=$url");
		exit(); 
	}	

	/*function to cheack utem im data base */
	/* function to check any item */


	function checkitem($select, $from, $value)
	{
		global $con;
		$statement = $con->prepare("SELECT $select FROM $from 
		WHERE $select = ?");
		$statement->execute(array($value));
		$count = $statement->rowCount();
		return $count;
	}

	/*
	1 cont number of items v1.0



	*/

	function countItem($item, $table)
	{
		global $con;	
		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
		$stmt2->execute();
		return $stmt2->fetchColumn();
	}
	/*
	1-get latest records function v1.0
	*/
	function getLatest($selelct, $table, $order, $limit = 5)
	{
		global $con;
		$getStmt = $con->prepare("SELECT $selelct FROM $table ORDER BY $order DESC LIMIT $limit");	
		$getStmt ->execute();
		$rows = $getStmt->fetchAll();
		return $rows;
	}