<?php
$connection = mysqli_connect('localhost','root');
if(!$connection){
  die("Database Connection failed" . mysqli_error($connection));
}
if(!mysqli_select_db($connection,'fusionEra')){
  die("Database selection failed" . mysqli_error($connection));
}
 ?>
