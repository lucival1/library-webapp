<?php
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
?>