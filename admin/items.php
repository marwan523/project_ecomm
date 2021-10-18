<?php 
	ob_start();
	session_start();
	$pageTitle = "Items";
	if(isset($_SESSION['login']))
	{
		include 'init.php';
		$do = isset($_GET['do']) ? $_GET['do'] : 'manage';
		if( $do == 'manage')
		{

		}

		if( $do == 'manage')
		{


				$stmt = $con->prepare("SELECT 
											items.*,categories3.Name
									   AS 
									    	Category_name, users.Username
									   AS
									   	    Client_name
									   FROM
									   	    items
									   INNER JOIN
									   	    categories3
									   ON 
									   		categories3.ID = items.Cat_ID
									   INNER JOIN
									   	    users 
									   ON
									   	    users.UserID  = items.Member_ID");
				$stmt->execute();
				$items = $stmt->fetchAll();



				?>
				<h1 class="text-center">Manage Items </h1>
				<div class="container">
					<div class=" table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>#ID</td>
								<td>Name</td>
								<td>Description</td>
								<td>Price</td>
								<td>Adding Date</td>
								<td>Category</td>
								<td>User name</td>

								<td>Control</td>
							</tr>

							<?php

								foreach ($items as $item) {



									echo "<tr>";


										echo "<td>" . $item['item_ID'] . "</td>";

										echo "<td>" . $item['Name'] . "</td>";

										echo "<td>" . $item['Dscription'] . "</td>";

										echo "<td>" . $item['Price'] . "</td>";
										//this is date 
										echo "<td>" . $item['Add_Date']. "</td>";
										 
										 echo "<td>" . $item['Category_name'] . "</td>";

										 echo "<td>" . $item['Client_name'] . "</td>";

										echo "<td>
										 <a href ='items.php?do=Edit&itemid="
										 . $item['item_ID'] ."' class = 'btn btn-success'> 
										 <i class='fa fa-edit'></i>
										edit </a>
										 <a href ='items.php?do=Delete&itemid"
										 . $item['item_ID'] ."' class = 'btn btn-danger confirm'> 
										 <i class='fa fa-close'></i>
										delete </a>";
										if($item['Approve'] == 0)
										{
											echo "<a href ='items.php?
													do=Approve&itemid="
											 		. $item['item_ID'] ."
													 ' class = 'btn btn-info activate'> 
											 		<i class='fa fa-check'></i>
													Approve</a>";	
										}



										 echo  "</td>";	


									echo "</tr>";
									
								}

							?>							

 


						</table>	
						

					</div>
					<a href='items.php?do=Add'
					 class="btn btn-primary">+add new Item </a>
				</div>


				<?php
		}

		elseif( $do == 'Add')
		{
			?>
					<h1 class="text-center">Add New Item</h1>
					<div class="container">
						<form class="form-horizontal" 
						action="?do=Insert" method="POST">
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Name
								</label>
								<div class="col-sm-10 col-md-4">
									<input 
										type="text" 
										name="name" 
										class="form-control"
								    	required="required"
								    	placeholder="Name of The Item" />
								</div>
							</div>


							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Description
								</label>
								<div class="col-sm-10 col-md-4">
									<input 
										type="text"
										name="description" 
										class="form-control"
								    	required="required"
								    	placeholder="Description of The Item" />
								</div>
							</div>



							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Price
								</label>
								<div class="col-sm-10 col-md-4">
									<input 
										type="text"
										name="price" 
										class="form-control"
								    	required="required"
								    	placeholder="Price of The Item" />
								</div>
							</div>	



							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Country
								</label>
								<div class="col-sm-10 col-md-4">
									<input 
										type="text"
										name="country" 
										class="form-control"
								    	required="required"
								    	placeholder="Country of The Item" />
								</div>
							</div>													


							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Status
								</label>
								<div class="col-sm-10 col-md-4">
									<select class="form-control" name="status">
										<option value="0">...</option>
										<option value="1">New</option>
										<option value="2">Like New</option>
										<option value="3">Used</option>
										<option value="4">Old</option>
									</select>

								</div>
							</div>	


							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Member
								</label>
								<div class="col-sm-10 col-md-4">
									<select class="form-control" name="member">
										<option value="0">...</option>
										<?php 

											$stmt = $con->prepare(
												"SELECT * FROM users");
											$stmt ->execute();
											$users = $stmt->fetchAll();
											foreach ($users as $user) {

												echo "<option value='". $user['UserID']. "'>" .$user['Username'] . "</option>";
											}

										?>

									</select>

								</div>
							</div>		



							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Category
								</label>
								<div class="col-sm-10 col-md-4">
									<select class="form-control" name="category">
										<option value="0">...</option>
										<?php 

											$stmt2 = $con->prepare(
												"SELECT * FROM categories3");
											$stmt2 ->execute();
											$cats = $stmt2->fetchAll();
											foreach ($cats as $cat) {

												echo "<option value='". $cat['ID']. "'>" .$cat['Name'] . "</option>";
											}

										?>

									</select>

								</div>
							</div>



							<div class="form-group form-group-lg">

								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit"
									 value="Add Item"
									class="btn btn-primary btn-sm">
								</div>
							</div>
							
						</form>
					</div>

			<?php			
		}

		elseif( $do == 'Insert')
		{
		
	    	if($_SERVER["REQUEST_METHOD"]=="POST")
		    	{


		    		echo "<h1 class='text-center'>Insert Item</h1>"; 

		    		echo "<div class='container'>";
		    		
		    		$name   		= $_POST['name'];
		    		$description   	= $_POST['description'];
		    		$price 			= $_POST['price'];
		    		$country 		= $_POST['country'];
		    		$status 		= $_POST['status'];
		    		$member 		= $_POST['member'];
		    		$category 		= $_POST['category'];

		    		$formErrors = array();
		    		if(empty($name))
		    		{
		    			$formErrors[] =
		    			 "Name  cant <strong>Embty</strong>";
		    		}

		    		if(empty($user))
		    		{
		    			$formErrors[] = "Name  cant <strong>Embty</strong>";

		    		}

		    		if(empty($price))
		    		{
		    			$formErrors[] = "price  cant <strong>Embty</strong>";

		    		}


		    		if(empty($country))
		    		{
		    			$formErrors[] = "Name  country <strong>Embty</strong>";
		    			
		    		}


		    		if($status === 0)
		    		{
		    			$formErrors[] = "status  cant <strong>Embty</strong>";
		    			
		    		} 

		    		if($category === 0)
		    		{
		    			$formErrors[] = "category  cant <strong>Embty</strong>";
		    			
		    		}


		    		if($member === 0)
		    		{
		    			$formErrors[] = "member  cant <strong>Embty</strong>";
		    			
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

		    		//inert user info im database
		    			$stmt = $con->prepare("INSERT INTO 
		    											items
		    												(Name, Dscription, Price,Country_Made, Status, Add_Date,Cat_ID,
		    													Member_ID)

		    				VALUES(:zname, :zdescription, :zprice, :zcountry,
		    				 :zsatus, now(), :zcategory, :zmember)"
		    				 );
		    			$stmt->execute(array(

		    				'zname'			 => $name,
		    				'zdescription'	 => $description,
		    				'zprice'		 => $price,
		    				'zcountry'		 => $country,	   
		    				'zsatus'		 => $status,
		    				'zcategory'		 => $category,		   
		    				'zmember' 		 =>	$member
		    			));

		    			//Success ']	
		    		$errormsg = $stmt->rowCount() 
		    		. "Record inserted";	
		    		redirectHome ($errormsg, 'back', 4);
		    	    
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


		elseif( $do == 'Edit')
		{



				$itemid = isset($_GET["itemid"]) &&
				 is_numeric($_GET["itemid"]) ? 
				 intval($_GET["itemid"]) : 0;
				$stmt = $con->prepare("SELECT * FROM items WHERE  item_ID = ?");
				$stmt->execute(array($itemid));
				$item = $stmt->fetch();
				$count = $stmt->rowCount();
				if( $count > 0)
				{
			
			?>
					<h1 class="text-center">Edit New Item</h1>

					<div class="container">
						<form class="form-horizontal" 
						action="?do=Update" method="POST">
						<input type="hidden" name="itemid" 
							value="<?php echo $itemid ?> "/>
							<div class="form-group form-group-lg ">
								<label class="col-sm-2 control-label">
									Name
								</label>
								<div class="col-sm-10 col-md-4">
									<input 
										type="text" 
										name="name" 
										class="form-control"
								    	required="required"
								    	placeholder="Name of The Item"
								    	value="<?php echo $item['Name'] ?>" />
								</div>
							</div>


							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Description
								</label>
								<div class="col-sm-10 col-md-4">
									<input 
										type="text"
										name="description" 
										class="form-control"
								    	required="required"
								    	placeholder="Description of The Item"
								    	value="<?php echo $item['Dscription'] ?>" />
								</div>
							</div>



							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Price
								</label>
								<div class="col-sm-10 col-md-4">
									<input 
										type="text"
										name="price" 
										class="form-control"
								    	required="required"
								    	placeholder="Price of The Item"
								    	value="<?php echo $item['Price'] ?>" />
								</div>
							</div>	



							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Country
								</label>
								<div class="col-sm-10 col-md-4">
									<input 
										type="text"
										name="country" 
										class="form-control"
								    	required="required"
								    	placeholder="Country of The Item" 
								    	value="<?php echo $item['Country_Made'] ?>"/>
								</div>
							</div>													


							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Status
								</label>
								<div class="col-sm-10 col-md-4">
									<select class="form-control" name="status">
										<option value="0">...</option>
										<option value="1" <?php if($item['Status'] == 1 ){echo "selected";}?>>New</option>
										<option value="2" <?php if($item['Status'] == 2 ){echo "selected";}?>>Like New</option>
										<option value="3"<?php if($item['Status'] ==  3 ){echo "selected";}?>>Used</option>
										<option value="4"<?php if($item['Status'] ==  4 ){echo "selected";}?>>Old</option>
									</select>

								</div>
							</div>	


							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Member
								</label>
								<div class="col-sm-10 col-md-4">
									<select class="form-control" name="member">
										<option value="0">...</option>
										<?php 

											$stmt = $con->prepare(
												"SELECT * FROM users");
											$stmt ->execute();
											$users = $stmt->fetchAll();
											foreach ($users as $user) {

												echo "<option value='". $user['UserID']. "'"; 
												if($item['Member_ID'] ==  $user['UserID'] )
													{echo "selected";}
												echo">" .$user['Username'] . "</option>";
											}

										?>

									</select>

								</div>
							</div>		



							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Category
								</label>
								<div class="col-sm-10 col-md-4">
									<select class="form-control" name="category">
										<option value="0">...</option>
										<?php 

											$stmt2 = $con->prepare(
												"SELECT * FROM categories3");
											$stmt2 ->execute();
											$cats = $stmt2->fetchAll();
											foreach ($cats as $cat) {

												echo "<option value='". $cat['ID']. "'";
												if($item['Cat_ID'] ==  $cat['ID'])
													{echo "selected";}
												echo">"
												 .$cat['Name'] . "</option>";
											}

										?>

									</select>

								</div>
							</div>



							<div class="form-group form-group-lg">

								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit"
									 value="Save Item"
									class="btn btn-primary btn-sm">
								</div>
							</div>
							
						</form>

						<?php 

	/*$stmt = $con->prepare("SELECT * FROM comments ");
				$stmt->execute();
				$rows = $stmt->fetchAll();*/



				

				$stmt = $con->prepare("SELECT 
											comments.*,users.Username AS Member
									   FROM 
											comments
									   INNER JOIN
									   		users
									   ON
									   		users.UserID  = comments.User_id

									   WHERE item_ID = ?"
									   		);
				$stmt->execute(array($itemid));
				$rows = $stmt->fetchAll();	
				if (! empty($rows)){								   		
				

				
				

				?>
				<h1 class="text-center">Manage [<?php echo $item['Name'] ?>] Members </h1>
					<div class=" table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>

								<td>Comment</td>
								<td>User_Nname</td>
								<td>Add Date</td>
								<td>Control</td>
							</tr>

							<?php

								foreach ($rows as $row) {



									echo "<tr>";



										echo "<td>" . $row['Comment'] . "</td>";

 
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

					<?php
					}
					else 
					{
						echo "zalapata";
					}
					 ?>
					


						
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



		elseif( $do == 'Update')

		{

		    	//update page
		    	echo "<h1 class='text-center'>update Item</h1>"; 

		    	echo "<div class='container'>";
		    	if($_SERVER["REQUEST_METHOD"]=="POST")
		    	{
		    		//get variable from the form
				$id 		= $_POST['itemid']; //this is name for hidden tybe in edit form
				$name   	= $_POST['name'];
				$desc 		= $_POST['description'];
				$price 		= $_POST['price'];
				$country 	= $_POST['country'];
				$status 	= $_POST['status'];
				$cat 		= $_POST['category'];				
				$member 	= $_POST['member'];


		    		$formErrors = array();
		    		if(empty($name))
		    		{
		    			$formErrors[] =
		    			 "Name  cant <strong>Embty</strong>";
		    		}

		    		if(empty($user))
		    		{
		    			$formErrors[] = "Name  cant <strong>Embty</strong>";

		    		}

		    		if(empty($price))
		    		{
		    			$formErrors[] = "price  cant <strong>Embty</strong>";

		    		}


		    		if(empty($country))
		    		{
		    			$formErrors[] = "Name  country <strong>Embty</strong>";
		    			
		    		}


		    		if($status === 0)
		    		{
		    			$formErrors[] = "status  cant <strong>Embty</strong>";
		    			
		    		} 

		    		if($cat === 0)
		    		{
		    			$formErrors[] = "category  cant <strong>Embty</strong>";
		    			
		    		}


		    		if($member === 0)
		    		{
		    			$formErrors[] = "member  cant <strong>Embty</strong>";
		    			
		    		} 

 

		    		//
		    		foreach ($formErrors as $errors)
		    		{
		    			echo "<div class='alert alert-danger'>" .  
		    			$errors . "</div>" . "<br/>"; 
		    		}




		    		if( empty($formErrors))
		    		{


		    		$stmt = $con->prepare("UPDATE
		    									 items 
		    								set 
		    									Name = ?,
		    									Dscription = ?,
		    								    Price = ?,
		    								    Country_Made = ?,
		    								    Status = ?,
		    								    Cat_ID = ?,
		    								    Member_ID = ?
		    		 						WHERE 
		    		 							item_ID = ?");
		    		$stmt ->execute(array($name, $desc, $price, $country, $status, $cat, $member, $id));
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

		elseif( $do == 'Delete')
		{
	    	echo "<h1 class='text-center'>DELETE Item</h1>"; 

		    	echo "<div class='container'>";
		    	//delete member page
					$itemid = isset($_GET["itemid"]) &&
					 is_numeric($_GET["itemid"]) ? 
					 intval($_GET["itemid"]) : 0;
					//$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1 ");
					$cheack = checkitem('item_ID', 'items', $itemid);
					echo $cheack;
					//$stmt->execute(array($useridd));


					//$count = $stmt->rowCount();
					if( $cheack == 1) //you are dedte the $count dont forget
					{
						$stmt = $con->prepare("DELETE FROM items WHERE item_ID = :zuserr");

						$stmt ->bindParam(":zuserr", $itemid);//
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


		elseif( $do == 'Approve')
		{

		    	echo "<h1 class='text-center'>Approve item</h1>"; 

		    	echo "<div class='container'>";
		    	//delete member page
					$itemid = isset($_GET["itemid"]) &&
					 is_numeric($_GET["itemid"]) ? 
					 intval($_GET["itemid"]) : 0;
					//$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1 ");
					$cheack = checkitem('item_ID', 'items', $itemid);
					echo $cheack;
					//$stmt->execute(array($useridd));


					//$count = $stmt->rowCount();
					if( $cheack > 0) //you are dedte the $count dont forget
					{
						$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE item_ID = ?");

//
						$stmt ->execute(array($itemid));
						$errormsg = $stmt->rowCount() . "Record Activated";
						redirectHome($errormsg);
					}
					else
					{
						$errormsg = "<div class = 'alert alert-danger'>bad this id is not exist</div>";	
						redirectHome($errormsg, "back");
					}
				echo "</div>";	
			
		}

		include $tbl . "footer.php"; 

													
	}
	else
	{
		header('Location: index.php');
	}
	ob_end_flush();