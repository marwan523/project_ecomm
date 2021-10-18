<?php
	ob_start();
	session_start();
	if(isset($_SESSION['login']))


	{
		$pageTitle = "Dashboard";
		include "init.php";
		$numUsers = 6;
		$latestUser = getLatest ("*" , "users", "UserID", $numUsers);


		$numItems = 6;
		$latesItems = getLatest ("*" , "items", "Name", $numItems);

		?>



		<div class="home-stats">
			<div class="container text-center">
				<h1>Dashboard </h1>
				<a href="https://www.alwaseya.com/ar/customer/register_phone" target="-blank">wasia</a>
				<div>
					<div class="row">
						<div class="col-md-3">
							<div class="state members">
								<i class="fa fa-users"></i>
								<div class="info">
									Total Members
									<span><a href="members.php"><?php 
									echo countItem('UserID', 'users')
									?></a></span>									

								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="state endingg">
								<i class="fa fa-user-plus"></i>
								<div class="info">
									Pending Members
									<span>
										<a href="members.php?do=manage&page=pending">
											<?php
											echo checkitem
											('Regstatus', 'users', 0);
											?>
										
										</a>
									</span>									

								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="state items">
								<i class="fa fa-tag"></i>
								<div class="info">
								Total Items
								<span>
									
								<a href="items.php"><?php 
								echo countItem('item_ID', 'items');
								?></a>									
								</span>									
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="state comment">
								<i class="fa fa-comments"></i>
								<div class="info">
								Total Comments

								<span>
								<a href="items.php"><?php 
								echo countItem('C_ID', 'comments');
								?></a>
								</span>

								</div>
							</div>
						</div>				
					</div>
				</div>
			</div>
		</div>


		<div class="latest">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<?php $latestUser = 5; ?>
							<div class="panel-heading">
								<i class="fa fa-users"></i> 
								latest
								<?php echo $numUsers; ?>
								 Registerd users
								 <span class="toggle-info pull-right">
								 	<i class="fa fa-plus fa-lg"></i>
								 </span>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled latest-user">
								<?php
								$latestUser = getLatest('*', 'users', 'UserID',$numUsers);
								if(! empty($latesItems))
								{
									foreach ($latestUser as $user) {

										echo '<li>' . $user['Username'] .
										 ' <span class="btn btn-success pull-right"><i class="fa fa-edit">
										 </i>
										 <a href="members.php?do=edit&userid=' . $user['UserID'] . '"> edit
										 </a>
										 </span><li>' ; 	
									}
								}
								else 
								{
									echo "no records to show";
								}
								?>
								</ul>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-tag"></i> latest item 
								 <span class="toggle-info pull-right">
								 	<i class="fa fa-plus fa-lg"></i>
								 </span>								
							</div>
							<div class="panel-body">
								<ul class="list-unstyled latest-user">
								<?php
								$latestItems = getLatest('*', 'items', 'name',$numItems);
								foreach ($latestItems as $item) {

									echo '<li>' . $item['Name'] .
									 ' <span class="btn btn-success pull-right"><i class="fa fa-edit">
									 </i>
									 <a href="members.php?do=edit&userid=' . $item['Name'] . '"> edit
									 </a>
									 </span><li>' ; 	
								}
								?>
								</ul>
							</div>
						</div>
					</div>

				</div>
				<!-- start latest comment -->
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-comments-o"></i>
								 Latest comments
								 <span class="toggle-info pull-right">
								 	<i class="fa fa-plus fa-lg"></i>
								 </span>								
							</div>
							<div class="panel-body">
								<?php 
									$stmt = $con->prepare("SELECT 
																comments.*,users.Username AS Member
														   FROM 
																comments
														   INNER JOIN
														   		users
														   ON
														   		users.UserID  = comments.User_id
														   	ORDER BY  C_ID DESC

														   LIMIT 1 "
														   		);
									$stmt->execute();
									$comments = $stmt->fetchAll();
									foreach ($comments as $comment )
								    {
								    	echo "<div class='comment-box'>";
								    		echo '<span class="member-n"> ' .  $comment['Member'] . '</span>';
								    		echo '<p class="member-c"> ' .  $comment['Comment'] . '</p>';
								    	echo "</div>";


									}

								?>
								
							</div>
						</div>
					</div>

				</div>

				<!-- end latest comment -->					
			</div>
		</div>



		<?php




		/*end dashbard page*/


		//print_r($_SESSION);
		include $tbl . "footer.php";
	}
	else 
	{
		header("Location: index.php");
		exit();
	}
ob_end_flush();
?>