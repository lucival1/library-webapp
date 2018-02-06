<?php
session_start();

//create empty variables
$student_err = "";
$name_err = "";
$pass_err = "";
$pass_check = FALSE;

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if (strlen($_POST["username"]) > 3) {  
        $username = test_input($_POST['username']);
    } else {
        $name_err = "*Username requires at least 3 chars<br>";
    }
  if (empty($_POST["password"])) {
      $pass_err = "*Password is required<br>";
  } else {
      $password = test_input($_POST["password"]);
      $pass_check = valid_pass($password);
  }
    
  //user connection
  if(!empty("username") and $pass_check and $_POST["user_type"] == "student"){
    // create the connection
    include('scripts/db.php');
      
    //salt
    $pass_salted = "6s1ah74w1j9t1gw2edawdeadaefeaf".$password;
    //Password hash('type of encryption, variable to be encryptited
    $pass_hashed = hash('sha512', $pass_salted);
      
    $q = $DBH->prepare("select * from users where username = :username and password = :password LIMIT 1");
    $q->bindValue(':username', $username);
    $q->bindValue(':password', $pass_hashed);
    $q->execute();
    
    $row = $q->fetch(PDO::FETCH_ASSOC);         
    //returns table row(s) as an associative array
    //of values column names to data values
    //Array ( [id] => 1 [username] => seaanc 
    //        [email] => 12345 [password] => 12345 [date] => 2017-10-05 14:06:07 )
    
    $message = '';
    if (!empty($row)){ //is the array empty
      $student_id = $row['student_id'];
      $username = $row['username'];
      $password = $row['password'];
      //$message = 'Logged in as: '.$username;                  
      $_SESSION["username"] = $username;
      $_SESSION["student_id"] = $student_id;
      header('Location:user_home.php');
    } else {
        $message= 'Sorry your log in details are not correct';
    }
  } else{
        $message='Fill out the required fields';
  }
  
  //admin connection
  if(!empty("username") and $pass_check and $_POST["user_type"] == "admin"){
    
    // create the connection
    include('scripts/db.php');    
    //not salted yet
    $pass_salted = "6s1ah74w1j9t1gw2edawdeadaefeaf".$password;
    //Password hash('type of encryption, variable to be encryptited
    $pass_hashed = hash('sha512', $pass_salted);
      
    $q = $DBH->prepare("select * from admin where username = :username and password = :password LIMIT 1");
    $q->bindValue(':username', $username);
    $q->bindValue(':password', $pass_hashed);
    $q->execute();
    
    $row = $q->fetch(PDO::FETCH_ASSOC);
    
    $message = '';
    if (!empty($row)){ //is the array empty
      $admin_id = $row['admin_id'];
      $username = $row['username'];
      $password = $row['password'];        
      $_SESSION["username"] = $username;
      $_SESSION["admin_id"] = $admin_id;
      $_SESSION['admin']= 'admin';
      //$message = 'Logged in as: '.$username;
      header('Location:admin_home.php');
    } else {
        $message= 'Sorry your log in details are not correct';
    }
  } else{
        $message='Fill out the required fields';
  }
}

//test passwords
function valid_pass($password){
  if(strlen($password)>=6 and strlen($password)<=10){
    if(ctype_alnum($password)){
      return TRUE;
    }
  }
}

//clean data from undesirable chars
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!DOCTYPE>
<html>
<head>
  <link rel="stylesheet" href="css/stylelib.css">
</head>
<body>
<h2 style="width: 50%;">CCT Library</h2><br> 
<div class="body-style">
  <div class='body-style' id='left-body'></div>
  <div class='body-style' id='left-body'>
    <form class='form-style' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">  
      Username<input type="text" name="username"/>
      <span class="error"><?php echo $name_err;?></span>
      Password <input type="password" name="password"/>
      <span class="error"><?php echo $pass_err;?></span>
      <input type="radio" name="user_type" value="student"checked> Student
      <input type="radio" name="user_type" value="admin"> Admin <br/>
      <input type="submit" name="login" value="Login" class='button'/>
      <?php
      if(!empty($message)){  echo '<br>';
      echo $message;
      }
      ?>
    </form>
  </div>
</div>
<?php include 'scripts/footer.php'; ?>
</body>
</html>