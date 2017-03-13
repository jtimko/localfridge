<?php
  $title = "Add a Post";
  require_once("header.php");
  require_once("connect.php");

  if (isset($_POST['submit'])) {
    if (isset($_POST['postTitle'])) {
      $pTitle = htmlspecialchars($_POST['postTitle']);
    } else {
      $error = "Must enter a title<br />";
    }

    if (isset($_POST['postDesc'])) {
      $pDesc = htmlspecialchars($_POST['postDesc']);
    } else {
      $error .= "Must enter a description";
    }

    if ($pTitle && $pDesc) {
      echo "Posted!";
      $dbc->postTheMeal($pTitle, $pDesc, $_SESSION['user_id']);
    } else {
      echo $error;
    }
  }

 ?>
 <div class="container">
   <div class="row">
     <div class="col-md-6 col-xs-12" id="info">
       <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
         <label for="postTitle" class="control-label">Post Title</label>
         <input type="text" class="form-control login" name="postTitle" placeholder="Title" />
         <br />
         <label for="postDec" class="control-label">Description</label>
         <textarea class="form-control login" name="postDesc" placeholder="Explain the meal.." rows="3"></textarea>
         <br />
         <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
       </form><!--end of form-->
     </div><!--end of info-->
   </div><!--end of row-->
 </div><!--end of container-->
   <?php include('footer.php'); ?>
