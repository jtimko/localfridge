<!DOCTYPE html>
<?php
  session_start();
 ?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php if (isset($title)) echo $title; ?></title>
  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="css/style.css" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
</head>
<body>
  <nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <div class="navbar-brand logo whiteLink">
          <a href="index.php">LocalFridge</a>
        </div><!--end of logo-->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navHeaderCollapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div><!--end of navbar-header-->
    <div class="collapse navbar-collapse navHeaderCollapse" id="navCont">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="mission.php">Mission</a></li>
          <li><a href="meals.php">Meals</a></li>
          <li><a href="contact.php">Contact</a></li>
          <?php if (isset($_SESSION['username'])){
            echo "<li><a href='account.php'>" . $_SESSION['username'] . "</a></li>";
            echo "<li><a href='post.php'>+ Add a Post</a></li>";
            echo "<li><a href='destroy.php'>Log Out</a></li>";
          } else {
            echo "<li><a href='register.php'>Register</a></li>";
            echo "<li><a href='login.php'>Login</a></li>";
          }?>
        </ul><!--end of collapse-->
        <form class="navbar-form navbar-left hidden-xs" action="search.php" method="POST">
          <div class="form-group">
            <input type="text" class="form-control" name="search" placeholder="Search" />
          </div><!--End of form-group-->
          <button type="submit" class="btn btn-default" name="send">Send</button>
        </form><!--end of form-->
      </div><!--end of collapse-->
    </div><!--end of container-fluid-->
  </nav>
