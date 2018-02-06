<?php
  require_once("session_validation.php");
  session_regenerate_id(true); 
  include 'header.php';
  
  //fetch the data for checked out book from the DB with the respective student_id
  if(isset($_GET['checkedout'])){
    include('db.php');
    $stmt = $DBH->prepare("SELECT * FROM checked_out_books WHERE student_id=".$_SESSION["student_id"]);
    $stmt->execute();
    include('errordb.php');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
?>
<?php include 'footer.php'; ?>
