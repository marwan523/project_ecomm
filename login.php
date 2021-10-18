<?php 
	session_start();
	$pageTitle = "Login";
	include "init.php";
	if(isset($_SESSION['user']))
	{
		header("Location: index.php");

	}



if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
			if(isset($_POST['login']))
			{
				$user = $_POST['username'];
				$pass = $_POST['password'];
				$hashedpass = sha1($pass);


		//if user wxistb in data base 
				$stmt = $con->prepare("SELECT
										     UserID, Username, Password
									   FROM
									    	users
									   WHERE 
											Username = ?
									   AND 
									   		Password = ?");
										 
				$stmt->execute(array($user, $hashedpass));

				$get = $stmt->fetch();
				$count = $stmt->rowCount();


				//if  entered by data base 
				if($count > 0)
				{
					$_SESSION['user'] = $user;
					$_SESSION['uid'] = $get['UserID'];
	 
					//go to fdashbord page 
					header("Location: index.php");
					exit();
			

				}
			}
		else
		{ 
			
			$formErrors = array();

			$username = $_POST['username']; 
			$password = $_POST['password']; 
			$email = $_POST['emil']; 

			if(isset($username))
			{
				$filterdUser = filter_var($username, FILTER_SANITIZE_STRING);
				if(strlen($filterdUser) < 4)
				{
					$formErrors[] = 'Username must be 4 char';	
				}
				
			}
			//filter to user name 

			if(isset($password))
			{
				/*$filterdUser = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
				if(strlen($filterdUser) < 4)
				{
					$formErrors[] = 'Username must be 4 char';	
				}
				*/
			}	
			//filter to password 
			if(isset($email))
			{
				$filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
				if(filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true)
				{
					$formErrors[] = 'this email is not valid';
				}				
			}
			if( empty($formErrors))
			{

				//check if isername exist in database by function 
				$check = checkitem("Username", "users", $username);
				if ($check == 1)
				{
					$formErrors[] = "<div class='alert alert-danger'>sorry but user is exist</div>";

				}
				else {

				//inert user info im database
					$stmt = $con->prepare("INSERT INTO 
						users(Username, Password, Email, Regstatus, Date)
						VALUES(:zuser, :zpass, :zmail, 0, now())");
						 
						 
					$stmt->execute(array(

						'zuser' => $username,
						'zpass' => sha1($password),
						'zmail' => $email ));

						$successMessage = 'congrats you are member now';
		

				}
			}		

		}

		
	}



?>

	<div class="container login-page">
		<h1 class="text-center">
		 <span class="selected" data-class="login">Login</span>  | 
		 <span data-class="signup">Signup</span>
		</h1>
		<!--start login form -->
		<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<input class="form-control" type="text" name="username" autocomplete="off" 
			placeholder="user name" />
			<input class="form-control" type="password" name="password" autocomplete="new-password">
			<input class="btn btn-primary btn-block" name="login" type="submit" value ="Login">

		</form>

		<!-- end login form -->

		<!-- start sign up form -->
		<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<input pattern=".{4,}" title="Username must be 4 chars" class="form-control" type="text" name="username" autocomplete="off" 
			placeholder="user name" />
			<input minlength="4" class="form-control" type="password" name="password" autocomplete="new-password"
			placeholder="password" />
			<input class="form-control" type="emil" name="emil" autocomplete="off"
			placeholder="emil" />			
			<input class="btn btn-success btn-block" name="signup" type="submit" value ="Signup">

		</form>
		<!-- end sign up form -->
		<div class="the-errors text-center">
			<?php 
			if(!empty($formErrors))
			{
				foreach ($formErrors as $error) {
					echo $error . '<br>';
				}
			}

			if(isset($successMessage))
			{
				echo 'w';
			}

			?>
			
		</div>
	</div>
<?php 
	include $tbl . "footer.php";
?>