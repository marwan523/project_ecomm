<?php
	ob_start();
	session_start();
	$pageTitle = "Members";
	if(isset($_SESSION['login']))




		{

		include "init.php";
			$do = '';

			if(isset($_GET["do"]))
			{
				$do = $_GET["do"];
			}
			else
			{
				$do = "manage";
			}	
			//start manage page 
			if($do == "manage") 


			{

				$query = '';
				if(isset($_GET['page']) && $_GET['page'] == 'pending')
				{
					$query = 'AND Regstatus = 0';
				}

				$stmt = $con->prepare("SELECT * FROM users 
					WHERE GroupID != 1 $query");
				$stmt->execute();
				$rows = $stmt->fetchAll();



				?>
				<h1 class="text-center">Manage Members </h1>
				<div class="container">
					<div class=" table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>#ID</td>
								<td>Username</td>
								<td>Email</td>
								<td>FullNname</td>
								<td>Registerd database</td>
								<td>Control</td>
							</tr>

							<?php

								foreach ($rows as $row) {



									echo "<tr>";


										echo "<td>" . $row['UserID'] . "</td>";

										echo "<td>" . $row['Username'] . "</td>";

										echo "<td>" . $row['Email'] . "</td>";

										echo "<td>" . $row['FullName'] . "</td>";
										//this is date 
										echo "<td>" . $row['Date'].
										 "</td>";

										echo "<td>
										 <a href ='members.php?do=edit&userid="
										 . $row['UserID'] ."' class = 'btn btn-success'> 
										 <i class='fa fa-edit'></i>
										edit </a>
										 <a href ='members.php?do=delete&userid="
										 . $row['UserID'] ."' class = 'btn btn-danger confirm'> 
										 <i class='fa fa-close'></i>
										delete </a>";
										if($row['Regstatus'] == 0)
										{
											echo "<a href ='members.php?
											do=activate&userid="
											 . $row['UserID'] ."
											 ' class = 'btn btn-info activate'> 
											 <i class='fa fa-close'></i>
											Activate </a>";	
										}


										 echo  "</td>";	


									echo "</tr>";
									
								}

							?>							

 


						</table>	
						

					</div>
					<a href='members.php?do=Add'
					 class="btn btn-primary">+add new member </a>
				</div>


				<?php
			}	

			elseif ($do == "Add") {
				?>

					<h1 class="text-center">Add new Member</h1>
					<div class="container">
						<form class="form-horizontal" 
						action="?do=Insert" method="POST">
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Username
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="user1" 
									class="form-control"
									 autocomplete="off"
								     required="required"
								     placeholder="user name to login into shop" />
								</div>
							</div>


							<div class="password form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Password
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="password" 
									name="pass1" 
									class="password form-control"
									
									placeholder="password must be hard and comblex" 
									required="required" 
									>
									<i class="show-pass fa fa-eye fa-2x"></i> 

								</div>
							</div>



							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Email
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="email" name="email" class="form-control"
									required="required"
									placeholder="Email must be valid" />
								</div>
							</div>




							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Fullname
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="full" class="form-control" 
									required="required"
									placeholder="full name appear in your page" />
								</div>
							</div>




							<div class="form-group form-group-lg">

								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit"
									 value="Add member"
									class="btn btn-primary btn-lg">
								</div>
							</div>
							
						</form>
					</div>



					<?php 
			}

			elseif ($do == "Insert")
		    {



		    	if($_SERVER["REQUEST_METHOD"]=="POST")
		    	{


		    		echo "<h1 class='text-center'>Insert Member</h1>"; 

		    		echo "<div class='container'>";
		    		//get variable from the form
		    		$user   = $_POST['user1'];//this is name for type in form in do =add
		    		$pass   = $_POST['pass1'];
		    		$email 	= $_POST['email'];//this is name for type
		    		$name 	= $_POST['full'];//this is name for type

		    		$hashpass = sha1($_POST['pass1']);


		    		//trick new password_hash(string, PASSWORD_DEFAULT)

		    		//validate the form

		    		$formErrors = array();
		    		if(strlen($user) < 4)
		    		{
		    			$formErrors[] =
		    			 "username cant <strong>less than 4</strong>";
		    		}

		    		if(empty($user))
		    		{
		    			$formErrors[] = "username cant be embty";

		    		}

		    		if(empty($pass))
		    		{
		    			$formErrors[] = "password cant be embty";

		    		}


		    		if(empty($name))
		    		{
		    			$formErrors[] = "fullname cant be embty";
		    			
		    		}


		    		if(empty($email))
		    		{
		    			$formErrors[] = "email cant be embty";
		    			
		    		} 

		    		//
		    		foreach ($formErrors as $errors)
		    		{
		    			echo "<div class='alert alert-danger'>" .  
		    			$errors . "</div>" . "<br/>"; 
		    		}

		    		//echo $id . $user . $email . $name;

		    		//check if there no errors 

		    		//update the database with the info  

		    		if( empty($formErrors))
		    		{

		    			//check if isername exist in database by function 
		    			$check = checkitem("Username", "users", $user);
		    			if ($check == 1)
		    			{
		    				$errormsg = "<div class='alert alert-danger'>sorry but user is exist</div>";
		    				redirectHome($errormsg,'back',3);
		    			}
		    			else {

			    		//inert user info im database
			    			$stmt = $con->prepare("INSERT INTO 
			    				users(Username, Password, Email, FullName, Regstatus, Date)
			    				VALUES(:zuser, :zpass, :zmail, :zfull,
			    				 1, now())"
			    				 );
			    			$stmt->execute(array(

			    				'zuser' => $user,
			    				'zpass' => $hashpass,
			    				'zmail' => $email,
			    				'zfull' => $name

			    			));

			    				



			    			//Success ']
		    			
			    		$errormsg = $stmt->rowCount() 
			    		. "Record inserted";	
			    		redirectHome ($errormsg, 'back', 4);
		    	    	}
		    		}

		    	}
		    	else
		    	{
		    		echo "<div class='container'>";
		    		$errormsg =  "<div class='alert alert-danger'>sorry you cant browse this page</div>";
		    		redirectHome ($errormsg, 'back' , 4);
		    		echo "</div>";
	    		}

		    	echo "</div>";

 
			}

			elseif ($do == "edit")
			{
				/*if( isset($_GET["userid"]) &&
				 is_numeric($_GET["userid"]))
				{
					echo intval($_GET["userid"]);
				}
				else
				{
					echo 0;
				}*/

				$useridd = isset($_GET["userid"]) &&
				 is_numeric($_GET["userid"]) ? 
				 intval($_GET["userid"]) : 0;
				$stmt = $con->prepare("SELECT * FROM users WHERE UserID = $useridd LIMIT 1 ");
				$stmt->execute(array($useridd));
				$row = $stmt->fetch();
				$count = $stmt->rowCount();
				if( $count > 0)
				{
					?>
				
					<h1 class="text-center">Edit Member</h1>
					<div class="container">
						<form class="form-horizontal" 
						action="?do=update" method="POST">
							<input type="hidden" name="userid" 
							value="<?php echo $useridd ?> "/>
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Username
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="user1" 
									class="form-control"
									 autocomplete="off"
									 required="required"
									  value="<?php
									 echo $row ["Username"] ?>" />

								</div>
							</div>


							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Password
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="hidden" name="oldpass"
									value="<?php echo $row ["Password"] ?>"	/>						 
									<input type="password" 
									name="newpass" class="form-control"
									placeholder="if you dont write password no problem" 
									>

								</div>
							</div>



							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Email
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="email" name="email" class="form-control"
									required="required"
									value="<?php
									 echo $row ["Email"] ?>" >
								</div>
							</div>




							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Fullname
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="full" class="form-control" 
									required="required"
									value="<?php
									 echo $row ["FullName"] ?>"/>
								</div>
							</div>




							<div class="form-group form-group-lg">

								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="save"
									class="btn btn-primary btn-lg">
								</div>
							</div>
							
						</form>
					</div>
				<?php
			    }
			    else
			    {
			    	echo "<div class='container'>";
			    	$errormsg = "<div class='alert alert-danger'>thsre is no sush id</div>"; 
			    	redirectHome($errormsg, 4);
			    	echo "</div>";
			    }

		    }
		    elseif ($do == "update") {

		    	//update page
		    	echo "<h1 class='text-center'>update Member</h1>"; 

		    	echo "<div class='container'>";
		    	if($_SERVER["REQUEST_METHOD"]=="POST")
		    	{
		    		//get variable from the form
		    		$id 	= $_POST['userid']; //this is name for type
		    		$user   = $_POST['user1'];//this is name for type
		    		$email 	= $_POST['email'];//this is name for type
		    		$name 	= $_POST['full'];//this is name for type

		    		//trick new password
		    		$passs = "";


		    		if(empty($_POST["newpass"]))
		    		{
		    			$passs = $_POST["oldpass"];
		    		}
		    		else
		    		{
		    			$passs = sha1($_POST["newpass"]);
		    		}


		    		//validate the form
		    		$formErrors = array();
		    		if(strlen($user) < 4)
		    		{
		    			$formErrors[] =
		    			 "username cant <strong>less than 4</strong>";
		    		}

		    		if(empty($user))
		    		{
		    			$formErrors[] = "username cant be embty";

		    		}

		    		if(empty($name))
		    		{
		    			$formErrors[] = "fullname cant be embty";
		    			
		    		}


		    		if(empty($email))
		    		{
		    			$formErrors[] = "email cant be embty";
		    			
		    		} 

		    		//
		    		foreach ($formErrors as $errors)
		    		{
		    			echo "<div class='alert alert-danger'>" .  
		    			$errors . "</div>" . "<br/>"; 
		    		}

		    		//echo $id . $user . $email . $name;

		    		//check if there no errors 

		    		//update the database with the info  

		    		if( empty($formErrors))
		    		{


		    		$stmt = $con->prepare("UPDATE users set Username = ?, Email = ?, Fullname = ?, Password = ?
		    		 WHERE UserID = ?");
		    		$stmt ->execute(array($user, $email, $name, $passs, $id));
		    		echo $stmt->rowCount() . "Record Updated";

		    		$errormsg =  "sorry you cant browse this page";
		    		redirectHome ($errormsg, 'back' ,3);	    			

		    	    }

		    	}
		    	else
		    	{
		    		$errormsg = "<div class = 'alert alert-danger'>sorry you cant browse this page </div>";
		    		redirectHome($errormsg, 4);
		    	}

		    	echo "</div>";
		    	
		    	
		    } 
		    elseif ($do == 'delete') {

		    	echo "<h1 class='text-center'>DELETE Member</h1>"; 

		    	echo "<div class='container'>";
		    	//delete member page
					$useridd = isset($_GET["userid"]) &&
					 is_numeric($_GET["userid"]) ? 
					 intval($_GET["userid"]) : 0;
					//$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1 ");
					$cheack = checkitem('userid', 'users', $useridd);
					echo $cheack;
					//$stmt->execute(array($useridd));


					//$count = $stmt->rowCount();
					if( $cheack > 0) //you are dedte the $count dont forget
					{
						$stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");

						$stmt ->bindParam(":zuser", $useridd);//
						$stmt ->execute();
						$errormsg = $stmt->rowCount() . "Record deleted";
						redirectHome($errormsg);
					}
					else
					{
						$errormsg = "<div class = 'alert alert-danger'>bad this id is not exist</div>";	
						redirectHome($errormsg);
					}
				echo "</div>";
		    }
		    elseif ($do == 'activate') {

		    	echo "<h1 class='text-center'>Activate Member</h1>"; 

		    	echo "<div class='container'>";
		    	//delete member page
					$useridd = isset($_GET["userid"]) &&
					 is_numeric($_GET["userid"]) ? 
					 intval($_GET["userid"]) : 0;
					//$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1 ");
					$cheack = checkitem('userid', 'users', $useridd);
					echo $cheack;
					//$stmt->execute(array($useridd));


					//$count = $stmt->rowCount();
					if( $cheack > 0) //you are dedte the $count dont forget
					{
						$stmt = $con->prepare("UPDATE users SET Regstatus = 1 WHERE UserID = ?");

//
						$stmt ->execute(array($useridd));
						$errormsg = $stmt->rowCount() . "Record Activated";
						redirectHome($errormsg);
					}
					else
					{
						$errormsg = "<div class = 'alert alert-danger'>bad this id is not exist</div>";	
						redirectHome($errormsg);
					}
				echo "</div>";		    	
		    }

		include $tbl . "footer.php";
	}
	else 
	{
		header("Location: index.php");
		exit();
	}