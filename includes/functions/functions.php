<?php 

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
	/*1-get latest records function v1.0
	*/
	function getCat()
	{
		global $con;
		$getCat = $con->prepare("SELECT * FROM categories3 ORDER BY ID ASC");	
		$getCat ->execute();
		$cats = $getCat->fetchAll();
		return $cats;
	}


		function getItems($where , $value)
	{
		global $con;
		$getItems = $con->prepare("SELECT * FROM items WHERE $where = ? ORDER BY item_ID DESC");	
		$getItems ->execute(array($value));
		$items = $getItems->fetchAll();
		return $items;
	}
	/*
	Sky High (2005)
	*/

	/* check user status */


	function checkUserStatus($user)
	{
			global $con;
			$stmtx = $con->prepare("SELECT
								    Username, Regstatus
							   FROM
							    	users
							   WHERE 
									Username = ?
							   AND 
							   		Regstatus = 0");
								 
		$stmtx->execute(array($user));

		$status = $stmtx->rowCount();
		return $status;
	
	}
	
	/*check item*/
	function checkitem($select, $from, $value)
	{
		global $con;
		$statement = $con->prepare("SELECT $select FROM $from 
		WHERE $select = ?");
		$statement->execute(array($value));
		$count = $statement->rowCount();
		return $count;
	}

	/*redirect home*/

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