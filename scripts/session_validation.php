<?php
session_start();
if(!isset($_SESSION['username'])){
  session_destroy();
  session_unset();
  header('Location:login.php');
}

?>