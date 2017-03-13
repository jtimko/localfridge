<?php
  $title = "Admin";
  require_once("header.php");
  require_once("connect.php");
?>
<div class="container" ng-app="myApp">
  <div class="row">
    <div class="col-md-6 col-xs-12" id="info" ng-controller="myCtrl">
      <input type="text" ng-model="search">
      <ul>
        <li ng-repeat="user in users | filter : search">
          <div>
            <h3>{{user.userName}}</h3>
            <p>{{user.email}}</p>
          </div>
        </li>
      </ul>
    </div><!--end of info--></div>
  </div><!--end of row-->
</div><!--end of container-->
<script src="js/myapp.js"></script>
  <?php include('footer.php'); ?>
