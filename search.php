<?php
  require_once("header.php");
  require_once("connect.php");
 ?>
 <div class="container">
   <div class="row">
     <div class="col-md-6 col-xs-12" id="info">
       <?php if (isset($_POST['send'])) $dbc->search($_POST['search']); ?>
     </div><!--End of info-->
   </div><!--end of row-->
 </div><!--end of container-->
   <?php include('footer.php'); ?>
