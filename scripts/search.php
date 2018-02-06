<?php
  session_start();
  session_regenerate_id(true); 
  include 'header.php';
  ?>
<?php
  $search = "";
  if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (strlen($_GET["title"]) > 2) {  
        $title = test_input($_GET['title']);
    } else {
        $search_err = "*Search requires at least 3 charactheres<br>";
        header("Location:user_home.php");
    }
      
  // create the connection
    include('db.php');
    // select the correct table
    $stmt = $DBH->prepare("SELECT * FROM books WHERE title LIKE '%".$title."%'");
    $stmt->execute();
    include('errordb.php');
    // get the rows and put it in a variable
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  //clean data from undesirable chars
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<h2>CCT Library</h2><br></br>
<p>Here are the results for <?php echo $_GET["title"];?></p>
<form class='form-style' action="search.php" method="get">
<input type="text" name="title" placeholder="Title name"></input>
<input type="submit" name="search" value="Search" class='button'/></form>
<br/>
<?php
  echo "<table class="books-table">";
    echo "<tr><th>Title</th><th>Author</th><th>ISBN</th><th>Quantity</th></tr>";
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
        echo "<a href=check_out.php?isbn=".$row['isbn'].">Check Out</a>";
        echo "</td>";
      }
      echo "</tr>";
    }
  echo "</table>";
  
  include 'footer.php'; ?>