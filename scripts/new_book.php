<?php
  //connects in the DB to add new book
  //set query insert the new book data in the DB
  //prepare statement and bind parameters
  if(!empty($title) and !empty($author) and !empty($isbn) and !empty($quantity)){
    include('db.php');
    $stmt = $DBH->prepare("INSERT INTO books (title, author, isbn, quantity) VALUES (?, ?, ?, ?);");
    $stmt->bindParam(1, $title);
    $stmt->bindParam(2, $author);
    $stmt->bindParam(3, $isbn);
    $stmt->bindParam(4, $quantity);
    $stmt->execute();    
    include('errordb.php');
    $info_msg = "The book '".$title."' has been added in the library";
  }
?>