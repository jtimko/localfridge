<?php
require_once('connect.php');
echo json_encode($dbc->adminCheckUsers());

 ?>
