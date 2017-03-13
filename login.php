<?php
  $title = "Login";
  require_once('header.php');
  require_once('connect.php');

  if (isset($_POST['submit'])) {
    if (isset($_POST['user'])) {
      $user = htmlspecialchars($_POST['user']);
    } else {
      die('invalid input');
    }

    if (isset($_POST['pass'])) {
      $pass = $_POST['pass'];
    } else {
      die('invalid input');
    }

    if ($user && $pass) {
      if ($dbc->login($user, $pass) != 0) {
        header("Location: index.php");
      } else {
        header("Location: login.php");
      };

    }
  }
 ?>
 <div class="container">
   <div class="row">
     <div class="col-md-6 col-md-offset-3 col-xs-12" id="info">
       <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
         <h1>Log in</h1>
         <input type="text" name="user" class="form-control login" placeholder="Username" />
         <input type="password" name="pass" class="form-control login" placeholder="Password" />
         <br />
         <button type="submit" class="btn btn-primary" name="submit" value="submit">submit</button>
       </form> <!--end of form-->
     </div><!--end of info-->
   </div><!--end of row-->
 </div><!--end of container-->
   <?php include('footer.php'); ?>
