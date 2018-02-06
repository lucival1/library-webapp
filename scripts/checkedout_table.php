<?php 
  //check if the array possess any values before creating table
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
?>
