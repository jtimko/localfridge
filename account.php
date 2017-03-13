<?php
  $title = "Account";
  require_once("header.php");
  require_once("connect.php");

  if (isset($_POST['submit'])) {
    if (isset($_POST['delPost'])) {
      $dbc->delPost($_POST['delPost']);
    }
  }
?>
  <div class="container">
    <div class="row">
      <div class="col-md-6" id="info">
        <h1>Account</h1>
        <p>Please delete any items that have been picked up, or expired. More features coming soon.</p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <?php $dbc->getAccountList($_SESSION['user_id']); ?>
            <button type="submit" class="btn btn-primary" name="submit" value="submit">
              Delete
            </button>
      </div><!--end of info-->
    </div><!--end of row-->
  </div>
  <?php include('footer.php'); ?>
