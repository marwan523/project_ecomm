<?php
	session_start();
	$pageTitle = "Categories";
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
				$sort = 'ASC';
				$sort_array = array('ASC', 'DESC');
				if( isset($_GET['sort']) && in_array($_GET['sort'], $sort_array))
				{
					$sort = $_GET['sort'];
				}
				$stmt = $con->prepare("SELECT  * FROM categories3 Order BY Ordering $sort");
				$stmt -> execute();
				$cats = $stmt->fetchAll();?>


				<h1 class="text-center">Manage categories</h1>
				<div class="container categories">
					<div class="panel panel-default">
						<div class="panel-heading">

							<i class="fa fa-edit"></i>Manage categories
							<div class="option pull-right">
								<i class="fa fa-sort"></i>Ordering:[]
								<a class="<?php if($sort == 'ASC') {echo 'active';} ?>" href="?sort=ASC">ASC</a>
								<a  class="<?php if($sort == 'DESC') {echo 'active';} ?>" href="?sort=DESC">DESC</a>]
								<i class="fa fa-eye"></i>view[:<span class="active" data-view="full">Full</span>
								|<span  data-view="classic">Classic</span>]
							</div>
						</div>
						<div class="panel-body">
							<?php 
							foreach ($cats as $cat) {
								echo '<div class="cat">';
								?>

										 <div class="hidden-buttons">
											<?php
											
											echo "<a href = 'categories.php?do=Edit&catid= ". 
											$cat['ID']  . "' class='btn btn-xs btn-primary' >
											<i class='fa fa-edit'></i> Edit</a>"; 	

											echo " <a href = 'categories.php?do=Delete&catid= ". 
											$cat['ID']  . "' class='confirm btn btn-xs btn-danger' >
											<i class='fa fa-close'></i> Delete</a>"; 
											?>	



											</div>
										
										<?php
									echo '<h3>' . $cat['Name'] . '</h3>';
									echo '<div class="full-view">';
										echo '<p>';
											if($cat['Description'] == "")
											{
												echo "this category is embty description";
											}   
											else
											{
												echo $cat['Description'];
											}
										echo'</p>';
										if($cat['Visibility']  == 1)
												{
													echo '<span class="visibility"><i class="fa fa-eye"></i> Hidden </span>'; 
												}

										if($cat['Allow_Comment']  == 1)
												{
													echo '<span class="commenting"><i class="fa fa-close"></i> Comment disable </span>'; 
												}

										if($cat['Allow_Ads']  == 1)
												{
													echo '<span class="advertises"> Advertising disable </span>'; 
												}
									echo '</div>';		

								echo '</div>';
								echo "<hr>";
							}


							?>	
						</div>
					</div>
					<a class="add-category btn btn-primary" href="categories.php?do=Add"> <i class='fa fa-plus'></i>Add new category
					</a>
				</div>


				<?php
			}
			elseif($do == "Add") 	
			{?>
				
					<h1 class="text-center">Add new Category</h1>
					<div class="container">
						<form class="form-horizontal" 
						action="?do=Insert" method="POST">
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Name
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="name" 
									class="form-control"
									 autocomplete="off"
								     required="required"
								     placeholder="Name of category" />
								</div>
							</div>


							<div class="password form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Dsecription
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" 
									name="description" class="form-control"
									placeholder="Descripe the category">

								</div>
							</div>



							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Ordering	
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="ordering" class="form-control"
									placeholder="Number to arrange the category" />
								</div>
							</div>




							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Visibile
								</label>
								<div class="col-sm-10 col-md-4">
									<div>
									<input id="vis-yes" type="radio" name="visibility"value="0" checked />
									<label for="vis-yes">yes</label>	
									</div>

									<div>
									<input id="vis-no" type="radio" name="visibility"value="1"/>
									<label for="vis-no">no</label>	
									</div>

								</div>
							</div>


							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Allow commenting
								</label>
								<div class="col-sm-10 col-md-4">
									<div>
									<input id="com-yes" type="radio" name="commenting"value="0" checked />
									<label for="com-yes">yes</label>	
									</div>

									<div>
									<input id="com-no" type="radio" name="commenting"value="1"/>
									<label for="com-no">no</label>	
									</div>

								</div>
							</div>							



							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Allow Ads
								</label>
								<div class="col-sm-10 col-md-4">
									<div>
									<input id="ads-yes" type="radio" name="ads"value="0" checked />
									<label for="ads-yes">yes</label>	
									</div>

									<div>
									<input id="ads-no" type="radio" name="ads"value="1"/>
									<label for="ads-no">no</label>	
									</div>

								</div>
							</div>




							


							<div class="form-group form-group-lg">

								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit"
									 value="Add Category"
									class="btn btn-primary btn-lg">
								</div>
							</div>
							
						</form>
					</div>

			<?php	
			}	

			elseif($do == "Insert") 
		    {



		    	if($_SERVER["REQUEST_METHOD"]=="POST")
		    	{


		    		echo "<h1 class='text-center'>Insert Category</h1>"; 

		    		echo "<div class='container'>";
		    		//get variable from the form
		    		$name       = $_POST['name'];//this is name for type in form in do =add
		    		$desc  	    = $_POST['description'];
		    		$order 		= $_POST['ordering'];//this is name for type
		    		$visible 	= $_POST['visibility'];//this is name for type
		    		$comment    = $_POST['commenting'];
		    		$ads  		= $_POST['ads'];
		    		

		    			//check if category exist in database by function 
		    		
		    			$check = checkitem("Name", "categories3", $name);
		    			if ($check == 1)
		    			{ 
		    				$errormsg = "<div class='alert alert-danger'>sorry but category is exist</div>";

 			    				redirectHome($errormsg,'back',3);
		    			}
		    			else {

			    			$stmt = $con->prepare("INSERT INTO 
			    				categories3(Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads)

			    				VALUES (:zname,:zdescribtion,:zorder,:zvis,:zcom,:zads)");	
			    			
			    			$stmt ->execute(array(
			    				'zname' 		=> $name,
			    				':zdescribtion' => $desc ,
			    				':zorder' 		=> $order ,
			    				':zvis'			=> $visible ,
			    				':zcom' 		=> $comment , 
			    				':zads' 		=>$ads
			    			));
						//Success ']
		    			
			    		$errormsg = $stmt->rowCount() 
			    		. "Record inserted";	
			    		redirectHome ($errormsg, 'back', 4);
			    		/*/ this is same insert 

				    			$stmt = $con->prepare("INSERT INTO 
			    				categories3(Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads)

			    				VALUES (?,?,?,?,?,?)");	
			    			
			    			$stmt ->execute(array($name,$desc,$order,$visible,$comment,$ads));
						//Success ']
		    			
			    		$errormsg = $stmt->rowCount() 
			    		. "Record inserted";	
			    		redirectHome ($errormsg, 'back', 4);

			    		/*/


		    	
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
			elseif($do == "Edit") 
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

				$catid = isset($_GET["catid"]) &&
				 is_numeric($_GET["catid"]) ? 
				 intval($_GET["catid"]) : 0;
				 //select all data depend on id 
				$stmt = $con->prepare("SELECT * FROM categories3 WHERE ID = ?");
				$stmt->execute(array($catid));

				$cat = $stmt->fetch();

				$count = $stmt->rowCount();

				if( $count > 0)
				{
					?>
					<h1 class="text-center">Edit Category</h1>
					<div class="container">
						<form class="form-horizontal" 
						action="?do=Update" method="POST">
						<input type="hidden" name="catid" value="<?php echo $catid ?>"/>
						<!--$catid given from dababase -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Name
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="name" 
									class="form-control"
								     required="required"
								     placeholder="Name of category"
								     value="<?php echo $cat['Name'] ?>" />
								</div>
							</div>


							<div class="password form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Dsecription
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" 
									name="description" class="form-control"
									placeholder="Descripe the category"
									value="<?php echo $cat['Description'] ?>"/>

								</div>
							</div>



							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Ordering	
								</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="ordering" class="form-control"
									placeholder="Number to arrange the category"
									value="<?php echo $cat['Ordering']?>" />
								</div>
							</div>




							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Visibile
								</label>
								<div class="col-sm-10 col-md-4">
									<div>
									<input id="vis-yes" type="radio" name="visibility"value="0"  
									<?php if($cat['Visibility'] == 0)
									{
										echo 'checked';
									} ?>/>
									<label for="vis-yes">yes</label>	
									</div>

									<div>
									<input id="vis-no" type="radio" name="visibility"value="1"
									<?php if($cat['Visibility'] == 1)
									{
										echo 'checked';
									} ?>

									/>
									<label for="vis-no">no</label>	
									</div>

								</div>
							</div>


							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Allow commenting
								</label>
								<div class="col-sm-10 col-md-4">
									<div>
									<input id="com-yes" type="radio" name="commenting"value="0"  
									<?php if($cat['Allow_Comment'] == 0)
									{
										echo 'checked';
									} ?>/>
									<label for="com-yes">yes</label>	
									</div>

									<div>
									<input id="com-no" type="radio" name="commenting"value="1"
									<?php if($cat['Allow_Comment'] == 1)
									{
										echo 'checked';
									} ?>/>

									<label for="com-no">no</label>	
									</div>

								</div>
							</div>							



							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">
									Allow Ads
								</label>
								<div class="col-sm-10 col-md-4">
									<div>
									<input id="ads-yes" type="radio" name="ads"value="0"
									<?php if($cat['Allow_Ads'] == 0)
									{
										echo 'checked';
									} ?>/>
									<label for="ads-yes">yes</label>	
									</div>

									<div>
									<input id="ads-no" type="radio" name="ads"value="1"
									<?php if($cat['Allow_Ads'] == 1)
									{
										echo 'checked';
									} ?>/>
									<label for="ads-no">no</label>	
									</div>

								</div>
							</div>




							


							<div class="form-group form-group-lg">

								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit"
									 value="Edit Category"
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
			elseif($do == "Update") 

			{
		    	echo "<h1 class='text-center'>update Category</h1>"; 

		    	echo "<div class='container'>";




		    	if($_SERVER["REQUEST_METHOD"]=='POST')
		    	{
		    		//get variable from the form
		    		$id 		= $_POST['catid']; //this is name for type
		    		$name   	= $_POST['name'];//this is name for type
		    		$desc 		= $_POST['description'];//this is name for type
		    		$order 		= $_POST['ordering'];
		    		$visible 	= $_POST['visibility'];
		    		$comment 	= $_POST['commenting'];
		    		$ads 		= $_POST['ads'];

		    		$stmt2=$con->prepare("UPDATE categories3 SET Name=?, 
		    			Description=?, Ordering=?, Visibility=?, Allow_Comment=?, Allow_Ads = ? 
		    			WHERE 
		    				ID=?"); 

		    		$stmt2->execute(array($name, $desc, $order, $visible, $comment, $ads, $id));

					$count=$stmt2->rowCount();
		    		if( $count > 0)
		    		{
		    			echo "pass";
		    		}
		    		else
		    		{echo "faild";}
		    			

		    		/*echo $stmt2 -> rowCount() . "Record Updated";

		    		$errormsg =  "sorry you cant browse this page";
		   			redirectHome ($errormsg, 'back' ,3);*/
		    	}
		    	else
		    	{
		    		$errormsg = "<div class = 'alert alert-danger'>sorry you cant browse this page </div>";
		    		redirectHome($errormsg, 4);
		    	}
				echo "</div>";
			}
			elseif($do == "Delete") 
			{

		    	echo "<h1 class='text-center'>DELETE Category</h1>"; 

		    	echo "<div class='container'>";
		    	//delete member page
					$catid = isset($_GET["catid"]) &&
					 is_numeric($_GET["catid"]) ? 
					 intval($_GET["catid"]) : 0;
					//$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1 ");
					$cheack = checkitem('ID', 'categories3', $catid);
					echo $cheack;
					//$stmt->execute(array($useridd));


					//$count = $stmt->rowCount();
					if( $cheack > 0) //you are dedte the $count dont forget
					{
						$stmt = $con->prepare("DELETE FROM categories3 WHERE ID = :zid");

						$stmt ->bindParam(":zid", $catid);//
						$stmt ->execute();
						$errormsg = $stmt->rowCount() . "Record deleted";
						redirectHome($errormsg, 'back');
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
				header('Location: index.php');
				exit();
			}			

			?>							