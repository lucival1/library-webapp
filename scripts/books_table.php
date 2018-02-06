<?php
//check if the array possess any values before creating books table
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
?>