<?php
  $title = "Mailing List";
  require_once("header.php");
  require_once("functions.php");
  require_once("connect.php");

  if (isset($_POST['submit'])) {
    if (filter_var($_POST['mailList'], FILTER_VALIDATE_EMAIL)) {
      $mail = cleanUpInput($_POST['mailList']);
      $dbc->addMailList($mail);
    }
  };
?>
<div class="container">
  <div class="row">
    <div class="col-md-6 col-xs-12" id="info">
      <p>Thanks for signing up!</p>
    </div><!--end of info-->
  </div><!--end of row-->
</div><!--end of container-->
<?php include('footer.php'); ?>
