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
    include('scripts/search_btn.php');
  }
  
  //check all button fetch a list of all the books in the library and the user
  //can check out direct from the list if one wishes
  if(isset($_GET['checkall'])){
    include('scripts/checkall_btn.php');
  }
  
  if(isset($_GET['checkedout'])){
    include('scripts/checkedout_btn.php');
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
        include ('scripts/books_table.php');
      }
      if(isset($_GET['checkedout'])){
        include ('scripts/checkedout_table.php');
      }
    ?></span>
  </div>
</div>
<?php include 'scripts/footer.php'; ?>
