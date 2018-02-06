<?php
  require_once("session_validation.php");
  session_regenerate_id(true);
  include 'header.php';
?>
<?php
  global $row;
  global $new_row;
  $checkout_msg = "";
  
  //get actual epoch time and convert to datetime
  //uses the actual time to add 7 days to find return date
  $epoch = time();
  $acquire_date = new DateTime("@$epoch");
  $epoch = $epoch + 604800; //add 7 days with epoch time
  $return_date = new DateTime("@$epoch"); 
  
  //get isbn from the GET METHOD and set variable
  //check if the current user has any active books with the same isbn borrowed
  //if there is no entry a new register is made with the student_id, isbn and quantity.
  //also the epoch time that was processed before is added in the DB
  $isbn = $_GET['isbn'];
  include('db.php');  
  $stmt = $DBH->prepare("SELECT quantity FROM checked_out_books WHERE isbn =".$isbn." AND student_id=".$_SESSION['student_id']);
  $stmt->execute();
  include('errordb.php');
  $rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach($rows1 as $new_row){
      $new_row['quantity'];
  }
  $borrowed = $new_row['quantity'] + 1;
  if($borrowed == 1){
    $stmt = $DBH->prepare("INSERT INTO checked_out_books (student_id, isbn, quantity, acquire_date, return_date) VALUES (?,?,?,?,?)");
    $stmt->bindValue(1, $_SESSION['student_id']);
    $stmt->bindValue(2, $isbn);
    $stmt->bindValue(3, $borrowed);
    $stmt->bindValue(4, $acquire_date->format('Y-m-d'));
    $stmt->bindValue(5, $return_date->format('Y-m-d'));
    $stmt->execute();
    $checkout_msg = "Your book has been checked out, ".$_SESSION['username'];
    include('errordb.php');
    //query the database to get quantity of books available
    $stmt = $DBH->prepare("SELECT quantity FROM books WHERE isbn =".$isbn);
    $stmt->execute();
    include('errordb.php');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($rows as $row){
        $row['quantity'];
    }
    //subtract one from the books quantity column and update the column in the DB
    $to_borrow = $row['quantity'] - 1;
    $stmt = $DBH->prepare("UPDATE books SET quantity = ".$to_borrow." WHERE isbn = ".$isbn);
    $stmt->execute();
    include('errordb.php');
  } else if($borrowed > 1){
      $checkout_msg = $_SESSION['username']." you can not check more than one sample of the same book.";
  }
      //$stmt = $DBH->prepare("UPDATE checked_out_books SET quantity=".$borrowed." WHERE  student_id=".$_SESSION['student_id']." AND isbn=".$isbn);
      //$stmt = $DBH->prepare("DELETE FROM checked_out_books WHERE student_id=".$_SESSION['student_id']." AND isbn=".$isbn);
      //$stmt->execute();
  else{
    header("Location:../user_home.php");
  }
  //after the DB is used the page is redirected to user_home after 2 seconds
  header("refresh:2;url=../user_home.php");
?>
<br/>
<span class="info_msg"><?php echo $checkout_msg;?></span>.<br/>
<?php include 'footer.php'; ?>
