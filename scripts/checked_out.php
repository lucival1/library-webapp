<?php
  require_once("session_validation.php");
  session_regenerate_id(true); 
  include 'header.php';
?>
  <link rel="stylesheet" href="../css/stylelib.css">
  <p>Those are the current books checked out 
  <span class="info_msg"><?php echo $_SESSION["username"];?>
  </span>.</p>
<?php
  //fetch the data for checked out book from the DB with the respective student_id
  if(isset($_GET['checkedout'])){
    include('db.php');
    $stmt = $DBH->prepare("SELECT * FROM checked_out_books WHERE student_id=".$_SESSION["student_id"]);
    $stmt->execute();
    include('errordb.php');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    include 'checkedout_table.php';
  }
?>
<?php include 'footer.php'; ?>