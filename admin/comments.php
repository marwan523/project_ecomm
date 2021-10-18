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
				/*$stmt = $con->prepare("SELECT * FROM comments ");
				$stmt->execute();
				$rows = $stmt->fetchAll();*/


				

				$stmt = $con->prepare("SELECT  
											comments.*,items.Name AS Item_Name,users.Username   AS Member
									   FROM 
											comments
									   INNER JOIN
									   		items
									   ON
									   		items.item_ID = comments.Item_ID


									   INNER JOIN
									   		users
									   ON
									   		users.UserID  = comments.User_id

									   		");
				$stmt->execute();
				$rows = $stmt->fetchAll();							   		
				

				
				

				?>
				<h1 class="text-center">Manage Members </h1>
				<div class="container">
					<div class=" table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>ID</td>
								<td>Comment</td>
								<td>Item</td>
								<td>User_Nname</td>
								<td>Add Date</td>
								<td>Control</td>
							</tr>

							<?php

								foreach ($rows as $row) {



									echo "<tr>";


										echo "<td>" . $row['C_ID'] . "</td>";

										echo "<td>" . $row['Comment'] . "</td>";

										echo "<td>" . $row['Item_Name'] . "</td>";

										echo "<td>" . $row['Member'] . "</td>";

										echo "<td>" . $row['Comment_Date'] . "</td>";
										

										echo "<td>
										 <a href ='comments.php?do=Edit&comid="
										 . $row['C_ID'] ."' class = 'btn btn-success'> 
										 <i class='fa fa-edit'></i>
										edit </a>
										 <a href ='comments.php?do=Delete&comid="
										 . $row['C_ID'] ."' class = 'btn btn-danger confirm'> 
										 <i class='fa fa-close'></i>
										delete </a>";
										if($row['Status'] == 0)
										{
											echo "<a href ='comments.php?
											do=Aprrove&comid="
											 . $row['C_ID'] ."
											 ' class = 'btn btn-info activate'> 
											 <i class='fa fa-close'></i>
											Approve </a>";	
										}


										 echo  "</td>";	


									echo "</tr>";
									
								}

							?>							

 


						</table>	
						

					</div>
				</div>


				<?php
			}	
			elseif ($do == "Edit")
			{

				$comid = isset($_GET["comid"]) &&
				 is_numeric($_GET["comid"]) ? 
				 intval($_GET["comid"]) : 0;
				$stmt = $con->prepare("SELECT * FROM comments WHERE C_ID = ?");
				$stmt->execute(array($comid));
				$row = $stmt->fetch();
				$count = $stmt->rowCount();
				if( $count > 0)
				{
					?>
				
					<h1 class="text-center">Edit Comments </h1>
					<div class="container">
						<form class="form-horizontal" 
						action="?do=update" method="POST">
							<input type="hidden" name="comid" 
							value="<?php echo $comid ?> "/>
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Comment
								</label>
								<div class="col-sm-10 col-md-4">
								 <textarea class="form-control" name="comment"><?php echo $row[$comid] ?></textarea>

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
		    		$comid 		= $_POST['comid']; //this is name for type
		    		$comment    = $_POST['comment'];//this is name for type

		    		

		    		$stmt = $con->prepare("UPDATE comments set Comment = ? WHERE C_ID = ?");	
		    		$stmt ->execute(array($comment, $comid));
		    		echo $stmt->rowCount() . "Record Updated";

		    		$errormsg =  "sorry you cant browse this page";
		    		redirectHome ($errormsg, 'back' ,3);	    			

		    	 }


		    	else
		    	{
		    		$errormsg = "<div class = 'alert alert-danger'>sorry you cant browse this page </div>";
		    		redirectHome($errormsg, 4);
		    	}

		    	echo "</div>";
		    	
		    	
		    } 
		    elseif ($do == 'Delete') {

		    	echo "<h1 class='text-center'>DELETE Member</h1>"; 

		    	echo "<div class='container'>";
		    	//delete member page
					$comid = isset($_GET["comid"]) &&
					 is_numeric($_GET["comid"]) ? 
					 intval($_GET["comid"]) : 0;
					//$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1 ");
					$cheack = checkitem('C_ID', 'comments', $comid);
					echo $cheack;
					//$stmt->execute(array($useridd));


					//$count = $stmt->rowCount();
					if( $cheack > 0) //you are dedte the $count dont forget
					{
						$stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :zid");

						$stmt ->bindParam(":zid", $comid);//
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
		    elseif ($do == 'Aprrove') {

		    	echo "<h1 class='text-center'>Approve comment</h1>"; 

		    	echo "<div class='container'>";
		    	//delete member page
					$comid = isset($_GET["comid"]) &&
					 is_numeric($_GET["comid"]) ? 
					 intval($_GET["comid"]) : 0;
					//$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1 ");
					$cheack = checkitem('C_ID', 'comments', $comid);
					echo $cheack;
					//$stmt->execute(array($useridd));


					//$count = $stmt->rowCount();
					if( $cheack > 0) //you are dedte the $count dont forget
					{
						$stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE C_ID = ?");

//
						$stmt ->execute(array($comid));
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