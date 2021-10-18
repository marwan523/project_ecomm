
	<nav class="navbar navbar-inverse">
	  <div class="container">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="dashboard.php"><?php echo langs('HOME_ADMIN') ?></a>
	    </div>
	    <div class="collapse navbar-collapse" id="app-nav">
	      <ul class="nav navbar-nav">  
	        <li> <a href="categories.php"><?php echo langs('CATEGORIES') ?></a></li>
	        <li> <a href="items.php"><?php echo langs('ITEMS') ?></a></li>
	        <li> <a href="members.php?do=manage"><?php echo langs('MEMBERS') ?></a></li>
	        <li> <a href="comments.php"><?php echo langs('COMMENTS') ?></a></li>
	        <li> <a href="#"><?php echo langs('STATISCICS') ?></a></li>
	        <li> <a href="#"><?php echo langs('LOGS') ?></a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="#">Link</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">marwan <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="../index.php">Visit Shop</a> </li>
	            <li><a href="members.php?do=edit&userid=<?php echo $_SESSION['ID']?>
	              ">Edit profile</a></li>
	            <li><a href="#">Settings</a></li>
	            <li><a href="logout.php
	              ">Logout</a></li>
	          </ul>
	        </li>
	      </ul>
	    </div>
	  </div>
	</nav>


