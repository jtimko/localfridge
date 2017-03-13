<!DOCTYPE html>
<?php
  session_start();
  require_once("connect.php");
 ?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>

  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div id="banner">
      <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <div class="navbar-brand logo">
              <a href="index.php">LocalFridge</a>
            </div><!--end of logo-->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navHeaderCollapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div><!--end of navbar-header-->
        <div class="collapse navbar-collapse navHeaderCollapse">
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

      <div id="message" class="col-md-8 col-md-offset-2 col-xs-12">
        <h1>Local Fridge</h1>
        <h2>Welcome to Solano Counties Digital Community Garden</h2>
        <p>We aim to end the wasting of food and start providing back to our own community</p>

        <div id="deets" class="col-md-10 col-md-offset-1 col-xs-12 hidden-xs">
          <p>In North America, it is estimated that 20 pounds of food is wasted each month, per person! In 2015, 42.2 million Americans lived in a household considered food insecure. 13.1 million of that population was children. We can help change that by sharing what we do not need!</p>
        </div><!--end of deets-->
    </div><!--end of message-->
      <div id="joinus" class="hidden-xs">
        <a href="register.php">
          <p>Join Us</p>
          <img src="../img/ddarrow.png" alt="arrows" />
        </a>
      </div><!--end of joinus-->
    </div> <!--end of banner-->
    </div> <!--end of row-->
    <div id="main-body">
      <div id="cta">
        <div class="row">
          <div id="what-menu" class="col-md-3 col-md-offset-1">
            <h3 class="header-red">Whats on the menu?</h3>
            <table class="table table-hover">
              <tr>
                <th>Item(s)</th>
                <th>Name</th>
                <th>Location</th>
              </tr>
              <?php $dbc->grabMeals(); ?>
            </table>
          </div><!--end of what-menu-->
          <div id="solano-map" class="col-md-6 col-md-offset-1 hidden-xs">
            <h3 class="header-red pull-right">Solano County Map</h3>
            <img src="img/maps.png" alt="Maps" class="pull-right" />
          </div><!--end of solano-map-->
      </div><!--end of row-->
        <div class="shortBorder"></div>
    </div><!--end of cta-->
    <div id="goal">
      <div class="row">
        <div id="whoweare" class="col-md-6 col-md-offset-3 hidden-xs">
          <hr />
          <p>LocalFridge is a free community to post what you do not need. No items are to be sold. Anything posted is openly available to anyone within our community. This project will continue to grow over time to help build a easily, friendly, social site. Over time, through funding and donations, we look to expand to further counties and eventually all over the united states. However, for now, we will focus on home, Solano County. Please be respectful to one another, and help us to change the world.</p>
        </div><!--end of whoweare-->
      </div><!--end of row-->
    </div><!--end of goal-->
  </div><!--end of main-body-->
  </div><!--end of container-fluid-->
  <?php include('footer.php'); ?>
