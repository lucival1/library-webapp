<?php
  include('scripts/db.php');
  $stmt = $DBH->prepare("SELECT * FROM checked_out_books WHERE return_date < CURRENT_DATE()");
  $stmt->execute();
  include('scripts/errordb.php');
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>