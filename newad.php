<?php 
	session_start();
	$pageTitle = "Create New Item";
	include 'init.php';

	if(isset($_SESSION['user']))
	{	

		if($_SERVER['REQUEST_METHOD'] == 'POST')
			

		{
			$formErrors = array();
			$name 		= filter_var($_POST['name'], FILTER_SANITIZE_STRING);
			$desc  		= filter_var($_POST['description'], FILTER_SANITIZE_STRING);
			$price 		= filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
			$country 	= filter_var($_POST['country'], FILTER_SANITIZE_STRING);
			$status 	= filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
			$category 	= filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
			if(strlen($name) < 4)
			{
				$formErrors[] = "item title must be at least 4 char";
			}

			if(strlen($desc) < 10)
			{
				$formErrors[] = "item description must be at least 10 char";
			}
			if(strlen($name) < 4)
			{
				$formErrors[] = "item country must be at least 4 char";
			}		

			if(empty($price))
			{
				$formErrors[] = "item price must be not empty";
			}
			if(empty($country))
			{
				$formErrors[] = "item country must be not empty";
			}			

			if(empty($status))
			{
				$formErrors[] = "item status must be not empty";
			}		
							
			if(empty($category))
			{
				$formErrors[] = "item category must be not empty";
			}	


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
    				'zdescription'	 => $desc,
    				'zprice'		 => $price,
    				'zcountry'		 => $country,	   
    				'zsatus'		 => $status,
    				'zcategory'		 => $category,		   
    				'zmember' 		 =>	$_SESSION['uid']
    			));

    			//Success ']	
    		$errormsg = $stmt->rowCount() 
    		. "Record inserted";	
    		redirectHome ($errormsg, 'back', 4);
    	    
    		}				
					
		}	

?>
<h1 class="text-center"><?php echo $pageTitle = "Create New Item";  ?></h1>
<div class='creat-ad block'>
	<div class='container'>
	<div class='panel panel-primary'>
		<div class='panel-heading'>Create new Ad</div>
		<div class='panel-body'>
			<div class="row">
				<div class="col-md-8">
					 
					<form class="form-horizontal" 
							action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">
										Name
									</label>
									<div class="col-sm-10 col-md-9">
										<input 
											type="text" 
											name="name" 
											class="form-control live-name"
									    	
									    	placeholder="Name of The Item" />
									</div>
								</div>


								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">
										Description
									</label>
									<div class="col-sm-10 col-md-9">
										<input 
											type="text"
											name="description" 
											class="form-control live-desc"
									    	required="required"
									    	placeholder="Description of The Item" />
									</div>
								</div>



								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">
										Price
									</label>
									<div class="col-sm-10 col-md-9">
										<input 
											type="text"
											name="price" 
											class="form-control live-price"
									    	required="required"
									    	placeholder="Price of The Item" />
									</div>
								</div>	



								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">
										Country
									</label>
									<div class="col-sm-10 col-md-9">
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
									<div class="col-sm-10 col-md-9">
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
										Category
									</label>
									<div class="col-sm-10 col-md-9">
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

				<!-- this is ads-->
				<div class="col-md-4">
						<div class='thumbnail item-box live-preview'>
						<span class='price-tag'>$0</span>
						<img class='img-responsive' src='download (3).jpg' alt=''>
						<div class='caption'>
							<h3></h3>
							<p> </p>
						</div>
					</div>
				</div>
			</div>

			<!--start looping errors-->
			<?php
				if(! empty($formErrors))
				{
					foreach ($formErrors as $error) 
					{
						echo "<div class='alert alert-danger'>" . $error . "</div>";	
					}
				}
			 ?>
			<!--start looping errors-->
		</div>
	</div>	
		
	</div>
</div>



<?php 
	

	}
	else{header('Location: login.php');
			exit();
		 }

	include $tbl . "footer.php";
	 	

?>