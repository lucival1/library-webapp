<?php  
  // create the connection
  include('scripts/db.php');
  // select the correct table
  $stmt = $DBH->prepare("SELECT * FROM books");
  $stmt->execute();
  include('scripts/errordb.php');
  // get the rows and put it in a variable
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>