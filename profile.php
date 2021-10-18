<?php 
	session_start();
	$pageTitle = "profile";
	include 'init.php';
	if(isset($_SESSION['user'])){
	$getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
	$getUser ->execute(array($sessionUser));//var exist in init.php
	$info = $getUser ->fetch();
	echo $info['Username'];	
?>
<h1 class="text-center">My profile</h1>
<div class='information block'>
	<div class='container'>
	<div class='panel panel-primary'>
		<div class='panel-heading'>My Information</div>
		<div class='panel-body'>
			<ul class="list-unstyled">
				<li><i class="fa fa-unlock-alt fa-fw"></i>
					<span>Login Name</span>:<?php echo $info['Username'] ?>
				</li>
				<li><i class="fa fa-envelope-o fa-fw"></i>
					<span>Email</span>:<?php echo $info['Email'] ?>
				</li>
				<li><i class="fa fa-user fa-fw"></i>
					<span>Fullname</span>:<?php echo $info['FullName'] ?>
				</li>
				<li><i class="fa fa-calendar fa-fw"></i>
					<span>Date</span>:<?php echo $info['Date']  ?>
				</li>
				<li><i class="fa fa-tags fa-fw"></i>
					<span>Fav category</span>:
				</li>
			</ul>

		</div>
	</div>	
		
	</div>
</div>

<div class='my-adss block'>
	<div class='container'>
	<div class='panel panel-primary'>
		<div class='panel-heading'>My ads</div>
		<div class='panel-body'>

				<?php 
				if(! empty(getItems('Member_ID', $info['UserID'])))
				{
					foreach ( getItems('Member_ID', $info['UserID']) as $item) {
						echo '<div class="">';
							echo "<div class='col-sm-6 col-md-3'>";
								echo "<div class='thumbnail item-box'>";
									echo "<span class='price-tag'>$" . $item["Price"] .  "</span>";
									echo "<img class='img-responsive' src='download (3).jpg' alt='' >";
									echo "<div class='caption'>";
										echo "<h3> <a href='items.php?itemid=" . $item['item_ID'] 
										. "'>" .  $item['Name'] .  "</a></h3>";
							 			echo "<p>" .  $item['Dscription'] . "</p>";
										echo "<div class='date'>" .  $item['Add_Date'] . "</div>";

									echo "</div>";
								echo "</div>";
							echo "</div>";	
						echo "</div>";	
					}	
				
				}
				else
				{
					echo"not ads to show , Create <a href='newad.php'>New ads</a> ";
				}
				?>
			</div>
		</div>
	</div>	
		
</div>





	<div class='container'>
	<div class='panel panel-primary'>
		<div class='panel-heading'>Lateset comment </div>
		<div class='panel-body'>
			<?php
				$stmt = $con->prepare("SELECT  
											Comment
									   FROM 
											comments
									   
									  WHERE User_id = ?");
				$stmt->execute(array($info['UserID']));

									   		
				$comments = $stmt->fetchAll();	
				if(! empty($comments))
				{	
						foreach ($comments as $comment)
						{
							echo '<p>' . $comment['Comment'] .'</p>';
				     	}
				}
				else 
				{
					echo 'not comment to show';
				}


				?>
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