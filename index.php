<?php
session_start();
session_regenerate_id(true); 
?>
<!DOCTYPE>
<html>
<head>
  <link rel="stylesheet" href="css/stylelib.css">
</head>
<body>
<h2 style="width: 50%;">CCT Library</h2><br></br>
<p style="width: 50%;">Welcome to CCT online library</p>
<div class="body-style">
  <div class='body-style' id='left-body'></div>
  <div class='body-style' id='left-body'>
    <form class='form-style' action="register.php" method="get">
    <input type="submit" name="submit" value="Register" class='button'/></form>
    <form class='form-style' action="login.php" method="get">
    <input type="submit" name="submit" value="Login" class='button'/>
    <?php
    if(!empty($message)){  echo '<br>';
    echo $message;
    }
    ?>
    </form>
  </div>
</div>
<?php include 'scripts/footer.php'; ?>