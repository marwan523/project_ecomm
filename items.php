<?php 
	ob_start();
	session_start();
	$pageTitle = "Show Item";
	include 'init.php';
	$itemid = isset($_GET["itemid"]) &&
	 is_numeric($_GET["itemid"]) ? 
	 intval($_GET["itemid"]) : 0;
	$stmt = $con->prepare("SELECT
								 items.*,categories3.Name AS category_name,
								 users.Username AS varible 
								  FROM 
								  items
								  INNER JOIN
								  	categories3
								  	ON
								  	 categories3.ID = items.Cat_ID 
								  INNER JOIN
								  	users
								  	ON
								  	 users.UserID = items.Member_ID

								  WHERE
								    item_ID = ?");
	$stmt->execute(array($itemid));
	$count = $stmt->rowCount();
	if($count > 0)
	{
	$item = $stmt->fetch();	



?>
<h1 class="text-center"><?php echo $item['Name']; ?></h1>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<img class='img-responsive img-thumbnail center-block' src='download (3).jpg' alt=''>
		</div>
		<div class="col-md-9 item-info">
			<h2><?php echo $item['Name']; ?></h2>
			<ul class="list-unstyled">
				<p><?php echo $item['Dscription']; ?></p>
				<li><i class="fa fa-calendar"></i>
					<span>Added Date: </span><?php  echo " " .  $item['Add_Date']; ?>
				</li>
				<li><i class="fa fa-money"></i>
					<span>Price: </span><?php echo $item['Price'] . "$"; ?>
				</li>
				<li> <i class="fa fa-building"></i>		
				<span>Made In: </span> Made In :<?php echo $item['Country_Made']; ?>
				</li>
				<li><i class="fa fa-tags"></i>
					<span>Category: </span><a href="categories.php?pageid= <?php echo
					  $item['Cat_ID'] ?>">
						<?php echo $item['category_name']; ?></a>
				</li>
				<li><i class="fa fa-user"></i>
					<span>Added By: </span><a href="#"><?php echo $item['varible']; ?></a>
				</li>
			</ul>
		</div>
	</div>
	<hr class="custom-hr">
	<div class="row">
		<div class="col-md-3">User Image</div>
		<div class="col-md-9">User Comment</div>
	</div>
</div>

<?php 
}
	else 
	{
		echo "no id is entry";
	}

	include $tbl . "footer.php";
	ob_end_flush();
	 	

?>