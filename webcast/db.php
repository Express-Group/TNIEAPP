<?php
date_default_timezone_set('Asia/Kolkata'); 
$connection = new mysqli("10.50.2.162" , "root" , "SamDb@121!" , "nie_live");
if($connection->connect_errno){
  echo "Failed to connect DB: " . $connection->connect_error;
  exit();
}
$connection->set_charset("utf8");
?> 