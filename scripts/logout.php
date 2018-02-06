<?php
session_start();
//clear all the variables, destroy the session and 
//close the hability to write data on the session
//then redirect to index page
unset($_SESSION);
session_destroy();
session_write_close();
header('Location:../index.php');
die;
?>