<?php
  $title = "Register";
  require_once("header.php");
  require_once("connect.php");
  require_once("functions.php");

  if (isset($_POST['submit'])) {
    $message = '';
    $zip = array();

    if (isset($_POST['zCode']) && strlen($_POST['zCode']) == 5 ) {
      if ($zip = $dbc->checkZip($_POST['zCode'])) {
        $zCode = $zip["zId"];
        $city = $zip["cityId"];
      }
    } else {
      $message .= "Must enter a Solano County Zip code<br />";
    }

    if (filter_var($_POST['eMail'], FILTER_VALIDATE_EMAIL)) {
      $eMail = cleanUpInput($_POST['eMail']);
    } else {
      $message .= "Must enter a valid email address<br />";
    }
    if (isset($_POST['uName']) && strlen($_POST['uName']) > 3 ) {
      if ($dbc->checkUser($_POST['uName']) == 0) {
          $uName = cleanUpInput($_POST['uName']);
      } else {
        $message .= "Username already exists<br />";
      }
    } else {
      $message .= "Must enter a valid username.<br />User names must be at least four characters long<br />";
    }
    if (isset($_POST['pWord1']) && strlen($_POST['pWord1']) > 5 ) {
      if ($_POST['pWord1'] == $_POST['pWord2']) {
        $pWord = cleanUpInput($_POST['pWord1']);
      } else {
        $message .= "Passwords did not match<br />";
      }
    } else {
      $message .= "Password must be at least 6 characters long<br />";
    }
    if ($zCode && $eMail && $uName && $pWord) {
      $dbc->registerUser($fName = "none", $lName = "none", $zCode, $city, $tPhone = 0000000, $eMail, $uName, $pWord);
      echo "Thank you for registering! Now please log in";
    } else {
      echo $message;
    }
  }
 ?>
 <div class="container">
   <div class="row">
     <div class="col-md-6 col-xs-12" id="info">
       <h1>Register</h1>
       <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
         <div class="row">
           <div class="col-md-12">
             <input type="text" class="form-control" name="eMail" placeholder="Email" />
           </div>
         </div><!--end of row-->
         <div class="row">
           <div class="col-md-12">
             <input type="text" class="form-control" name="uName" placeholder="Username" />
           </div>
         </div><!--end of row-->
         <div class="row">
           <div class="col-md-5">
             <input type="password" class="form-control" name="pWord1" placeholder="Password" />
           </div>
           <div class="col-md-5 col-md-offset-2">
             <input type="password" class="form-control" name="pWord2" placeholder="Retype Password" />
           </div>
         </div><!--end of row-->
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" name="zCode" placeholder="Zip Code" />
          </div>
        </div><!--end of row-->
        <br />
        <button type="submit" class="btn btn-primary" name="submit" value="submit">Send</button>
     </form><!--end of form-->
   </div><!--end of info-->
 </div><!--end of row-->
</div><!--end of container-->
  <?php include('footer.php'); ?>
