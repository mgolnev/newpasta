<?php
$db = new mysqli("localhost", "mysql", "mysql", "pasta");

$db->set_charset("utf8");
  if (mysqli_connect_errno()) {
    throw new Exception(mysqli_connect_error(), mysqli_connect_errno());
  }


?>
