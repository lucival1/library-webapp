<?php
  require_once('scripts/session_validation.php');
  session_regenerate_id(true); 
  include 'scripts/header.php'; ?>
<?php
  global $rows;
  $search = "";
  $title_err="";
  $author_err="";
  $isbn_err="";
  $quantity_err="";
  $student_err = "";
  $info_msg = "";
  
  //fetch all the data from the books that were checked out from the library
  //connects to the DB, queries and stores in a variable
  if(isset($_GET['checkedout'])){
    include('scripts/db.php');
    $stmt = $DBH->prepare("SELECT * FROM checked_out_books");
    $stmt->execute();
    include('scripts/errordb.php');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  //fetch all books that are overdue in the database and stores in a variable
  if(isset($_GET['booksoverdue'])){
    include('scripts/db.php');
    $stmt = $DBH->prepare("SELECT * FROM checked_out_books WHERE return_date < CURRENT_DATE()");
    $stmt->execute();
    include('scripts/errordb.php');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }  
  
  //when a new books form is submitted we run the following validation code
  //if the data passes the check we run a query in the DB to add the new book
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    //ISBN validation
    if(is_numeric($_POST["isbn"]) and strlen($_POST["isbn"]) == 10) { //test if has exactly 10 numeric chars
        $isbn = test_input($_POST['isbn']);
    } else {
        $isbn_err = "*ISBN requires 10 digit number<br>";      
    }
    //when adding a book: title, author and quantity validation
    if(isset($_POST['addbook'])){
      if(strlen($_POST["title"]) > 2) {      
          $title = test_input($_POST['title']);
      } else {
          $title_err = "*Title requires at least 3 chars<br>";
      }
      if(strlen($_POST["author"]) > 2) {      
          $author = test_input($_POST['author']);
      } else {
          $author_err = "*Author requires at least 3 chars<br>";
      }
      if(is_numeric($_POST["quantity"])) { //test if is numeric
          $quantity = test_input($_POST['quantity']);
      } else {
          $quantity_err = "*Quantity must be numeric<br>";      
      }
      include('scripts/new_book.php');
    }
    //when checking in a book: student_id validation 
    //and call for the checkin script
    if(isset($_POST['checkinbook'])){
      if(is_numeric($_POST["studentid"]) and strlen($_POST["studentid"]) == 7) {
          $studentid = test_input($_POST['studentid']);
      } else {
        $student_err = "*Student ID require 7 digit number<br>";
      }
      include('scripts/check_in.php');
    }
  }
      

  
  //validate data from undesirable chars
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<h2>CCT Library</h2><br></br>
<p>Welcome <?php echo $_SESSION["username"];?></p>

<div class='body-style'>
  <div class='body-style' id='left-body'>
  
    <form class='form-style' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <input type="submit" name="checkedout" value="Books checked out" class='button'/></form>
  
    <form class='form-style' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <input type="submit" name="checkin" value="Check books in" class='button'/></form>

    <form class='form-style' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <input type="submit" name="booksoverdue" value="Books overdue" class='button'/></form>
    
    <form class='form-style' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <input type="submit" name="addnewbook" value="Add new book" class='button'/></form>
    
    <form class='form-style' action="scripts/logout.php" method="get">
    <input type="submit" name="logout" value="Log out" class='button'/>
    <?php
      if(!empty($message)){  echo '<br>';
        echo $message;
      }
    ?>
</form>
  </div>
  <div class='body-style' id='right-body'>
    <span><?php include 'scripts/checkedout_table.php';?></span>    
    <?php 
    if(isset($_GET['addnewbook'])){
      //when add new book is clicked the following form appears on the screen
      echo "<span class='info_msg'>".$info_msg."</span>";
      echo "<form class='form-style' action='' method='POST'>";
        echo "Title<input type='text' name='title'/>";
        echo "<span class='error'>".$title_err."</span>";
        echo "Author<input type='text' name='author'/>";
        echo "<span class='error'>".$author_err."</span>";
        echo "ISBN<input type='text' name='isbn'/>";
        echo "<span class='error'>".$isbn_err."</span>";
        echo "Quantity<input type='text' name='quantity'/>";
        echo "<span class='error'>".$quantity_err."</span><br>";
        echo "<input type='submit' class='button' name='addbook' value= 'Add book'/>";
      echo "</form>";
    }
    if(isset($_GET['checkin'])){
      //when add new book is clicked the following form appears on the screen
      echo "<span class='info_msg'>".$info_msg."</span>";
      echo "<form class='form-style' action='' method='POST'>";
        echo "Student ID<input type='text' name='studentid'/>";
        echo "<span class='error'>".$student_err."</span>";
        echo "ISBN<input type='text' name='isbn'/>";
        echo "<span class='error'>".$isbn_err."</span>";
        echo "<input type='submit' class='button' name='checkinbook' value= 'Check book in'/>";
      echo "</form>";
    }?>
  </div>
</div>
<?php include 'scripts/footer.php'; ?>