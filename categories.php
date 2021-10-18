<?php include "init.php";?>


<div class="container login-page">
	<h1 class="text-center"> show category</h1>

	
	<div class="row">
		<?php foreach ( getItems('Cat_ID',$_GET ['pageid']) as $item) {
			echo "<div class='col-sm-6 col-md-4'>";
				echo "<div class='thumbnail item-box'>";
					echo "<span class='price-tag'>" . $item["Price"] .  "</span>";
					echo "<img class='img-responsive' src='download (3).jpg' alt='' >";
					echo "<div class='caption'>";
						echo "<h3><a href='items.php?itemid=" . $item['item_ID'] 
						. "'>" .  $item['Name'] .  "</a></h3>";
						echo "<p>" .  $item['Dscription'] . "</p>";
					echo "</div>";
				echo "</div>";
			echo "</div>";		
		}
		?>
	</div>
</div>

<?php	include $tbl . "footer.php"; ?>
