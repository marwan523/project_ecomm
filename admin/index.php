<?php
	ob_start();
	session_start();
	$nonavbar = " ";
	$pageTitle = "Login";
	if(isset($_SESSION['login']))

	{
		header("Location: dashboard.php");

	}

	include "init.php";

	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$username = $_POST['user1'];
		$password = $_POST['pass1'];
		$hashedpass = sha1($password);




		//if user wxistb in data base 
		$stmt = $con->prepare("SELECT
									 UserID, Username, Password
							   FROM
							    	users
							   WHERE 
									Username = ?
							   AND 
							   		Password = ?
							   AND 
							   		GroupiD = 1
							   LIMIT 1 ");
		$stmt->execute(array($username, $hashedpass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		//if  entered by data base 
		if($count > 0)
		{
			$_SESSION['login'] = $username;
			$_SESSION['ID'] = $row['UserID']; 
			//go to fdashbord page 
			header("Location: dashboard.php");
			exit();

		}
	
		


	}

?>


	<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
		<h4 class="text-center">Admin login</h4>
		<input class="form-control input-lg" type="text" name="user1" placeholder="user name" autocomplete="off">
		<input class="form-control" type="password" name="pass1" placeholder="password" autocomplete="off">	
		<input class="btn btn-danger btn-block" type="submit">

	</form>








<?php
	include $tbl . "footer.php";
	ob_end_flush();
?>