<?php
  //delete the row with the checked out book and increase the number of available books
  if(!empty($studentid) and !empty($isbn)){
    include('db.php');
    $stmt = $DBH->prepare("DELETE FROM checked_out_books WHERE student_id=".$studentid." AND isbn = ".$isbn);
    $stmt->execute();
    include('errordb.php');
    $stmt = $DBH->prepare("SELECT quantity FROM books WHERE isbn =".$isbn);
    $stmt->execute();
    include('errordb.php');
    $check_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($check_rows as $check_row){
        $check_row['quantity'];
    }
    //subtract one from the books quantity column and update the column in the DB
    $to_borrow = $check_row['quantity'] + 1;
    $stmt = $DBH->prepare("UPDATE books SET quantity = ".$to_borrow." WHERE isbn = ".$isbn);
    $stmt->execute();
    include('errordb.php');
    $info_msg = $_SESSION["username"]." the book ".$isbn." has been checked in.";
  }else {
  }
?>