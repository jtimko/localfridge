<?php
  $title = "Meal";
  require_once("header.php");
  require_once("connect.php");
?>
<div class="container">
  <div class="row">
    <div class="col-md-6 col-xs-12" id="info">
      <?php if (isset($_GET['id'])) { ?>
      <h1><?php echo $dbc->getMealTitle($_GET['id']); ?></h1>
      <br />
      <p>Posted By: <?php echo $dbc->getMealAuth($_GET['id']); ?></p>
      <p><?php echo $dbc->getMealDesc($_GET['id']); } ?></p>
      <br />
      <a href="mailto:<?php echo $dbc->grabEmail($_GET['id']); ?>?Subject=<?php echo $dbc->getMealTitle($_GET['id']); ?>">
        <button type="button" class="btn btn-primary">Email</button></a>
      <!--<buton type="button" class="btn btn-info">Phone</button>-->
    </div><!--end of info--></div>
  </div><!--end of row-->
</div><!--end of container-->
  <?php include('footer.php'); ?>
