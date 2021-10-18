<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php getitle () ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery-ui.css"> 
	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery.selectBoxIt.css">	
	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>front2.css">
</head>
<body>
	<div class="upper-bar">
    <div class="container">
<?php 
  if(isset($_SESSION['user']))
  {
    echo 'Welcom' . $sessionUser;

    echo '<a href = "profile.php"> My Profile </a>';

    echo '<a href = "logout.php"> Logout </a>';
    echo '<a href = "newad.php"> New ads </a>';
    $userStatus = checkUserStatus($sessionUser);
    if ($userStatus == 1)
    {
      echo "your member need to activate by admin";
    }

  } 
  else
  {
  ?>
      <a href="login.php">
        <span class="pull-right">Login/Signup</span>
      </a>
      <?php } ?>

    </div>
  </div>
	<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home page</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">  
        <?php 
        $categories = getCat();
        foreach ($categories as $cat ) {
          echo '<li>
                 <a href="categories.php?pageid='.$cat["ID"] .  '">  
                  
                 '. $cat['Name'] . ' 
                 </a>
                </li>';
        }
        ?>
      </ul>

    </div>
  </div>
</nav>
