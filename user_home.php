<?php
  require_once('scripts/session_validation.php');
  session_regenerate_id(true); 
  include 'scripts/header.php'; 
  $search_err = "";
  ?>
<?php
  global $rows;
  $search = "";
  
  //check if search button was pressed before trying to search
  //user is notified if the requirement isn't fulfilled
  if(isset($_GET['search'])){
    if (strlen($_GET["title"]) > 2) {  
        $title = test_input($_GET['title']);
        // create the connection
        include('scripts/db.php');
        // select the correct table
        $stmt = $DBH->prepare("SELECT * FROM books WHERE title LIKE '%".$title."%'");
        $stmt->execute();
        include('scripts/errordb.php');
        // get the rows and put it in a variable
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $search_err = "*Search requires at least 3 charactheres<br>";
    }
  }
  
  //check out button fetch a list of all the books in the library and the user
  //can check out direct from the list if one wishes
  if(isset($_GET['checkall'])){
        // create the connection
        include('scripts/db.php');
        // select the correct table
        $stmt = $DBH->prepare("SELECT * FROM books");
        $stmt->execute();
        include('scripts/errordb.php');
        // get the rows and put it in a variable
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  if(isset($_GET['checkedout'])){
      include('scripts/checked_out.php');
  }
  
  //clean data from undesirable chars
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<h2>CCT Library</h2><br/>
    <p>Welcome <?php echo $_SESSION["username"].",";?>
    <span><?php
      if (is_array($rows) || is_object($rows)){
          echo "those are the current books in our Library";
      }
    ?></span></p>
<div class='body-style'>
  <div class='body-style' id='left-body'>
    <form class='form-style' action=""<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <input type="text" name="title" placeholder="Title name"></input>    
    <span class="error"><?php echo $search_err;?></span>
    <input type="submit" name="search" value="Search" class='button'/></form>

    <form class='form-style' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <input type="submit" name="checkall" value="Check all" class='button'/></form>

    <form class='form-style' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <input type="submit" name="checkedout" value="Checked out" class='button'/></form>

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
    <span><?php
      //check if the array possess any values before creating table
      if(isset($_GET['checkall']) or isset($_GET['search'])){
        if (is_array($rows) || is_object($rows)){
          echo "<table class='table-style'>";
            echo "<tr><th>Title</th><th>Author</th><th>ISBN</th><th>Quantity</th><th></th></tr>";
            foreach($rows as $row){
              echo "<tr>";
              echo "<td>";
              echo $row['title'];
              echo "</td>";
              echo "<td>";
              echo $row['author'];
              echo "</td>";
              echo "<td>";
              echo $row['isbn'];
              echo "</td>";
              echo "<td>";
              echo $row['quantity'];
              echo "</td>";
              if($row['quantity'] > 0){
                echo "<td>";//view link
                echo "<a href=scripts/check_out.php?isbn=".$row['isbn'].">Check Out</a>";
                echo "</td>";
              }
              echo "</tr>";
            }
          echo "</table>";
        }
      }
      if(isset($_GET['checkedout'])){
        if (is_array($rows) || is_object($rows)){
          echo "<table class='table-style'>";
            echo  "<tr><th>Student ID</th><th>ISBN</th><th>Quantity</th><th>Borrow Date</th><th>Return Date</th></tr>";
            foreach($rows as $row){
              echo "<tr>";
              echo "<td>";
              echo $row['student_id'];
              echo "</td>";
              echo "<td>";
              echo $row['isbn'];
              echo "</td>";
              echo "<td>";
              echo $row['quantity'];
              echo "</td>";
              echo "<td>";
              echo $row['acquire_date'];
              echo "</td>";
              echo "<td>";
              echo $row['return_date'];
              echo "</td>";
              echo "</tr>";
            }
            echo "</table>";
        }
      }
    ?></span>
  </div>
</div>
<?php include 'scripts/footer.php'; ?>
