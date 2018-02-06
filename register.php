<?php
session_start();
// This is a very small sample register page. The user will fill out their information
// on the form. When they click the submit button, the data will be inserted into the database.

//create empty variables
global $rows;
$student_err = "";
$name_err = "";
$pass_err = "";
$captcha_err = "";
$pass_check = FALSE;


//check if POST was used, check if contain enough chars, then passes the values to variables
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(is_numeric($_POST["student_id"]) and strlen($_POST["student_id"]) == 7) { //test if has exactly 7 numeric chars
        //need to create if to check id on database
        $student_id = test_input($_POST['student_id']);
    } else {
        $student_err = "*Student ID require 7 digit number<br>";      
    }
    if(strlen($_POST["username"]) > 3) {
        $username = test_input($_POST['username']);
    } else {
        $name_err = "*Username requires at least 3 characters<br>";
    }    
    if(empty($_POST["password"]) or empty($_POST["password1"]) ) {
        $pass_err = "*Password is required<br>";
    } else {
        $password = test_input($_POST['password']);
        $password1 = test_input($_POST['password1']);
        $pass_check = valid_pass($password, $password1);
    }
    
    if(!empty($_POST["student_id"]) and !empty($_POST["username"]) and $pass_check){
      //check if student id is already present in the DB
      //if it is a new Student ID calls the register method
      include('scripts/db.php');
      $stmt = $DBH->prepare("SELECT * FROM users WHERE student_id =".$_POST["student_id"]);
      $stmt->execute();
      include('scripts/errordb.php');
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach($rows as $row){
        $id_check = $row['student_id'];
      }
      if(empty($id_check)){
        dbRegister($student_id, $username, $password);
      }else{
        $message = "The Student ID is already registered";
      }
    } else{
          $message='Fill out the required fields';
    }
}

//DB connection
function dbRegister($student_id, $username, $password){
  try {
      include('scripts/db.php');
      //salt
      $pass_salted = "6s1ah74w1j9t1gw2edawdeadaefeaf".$password;
      //Password hash('type of encryption, variable to be encryptited
      $pass_hashed = hash('sha512', $pass_salted);
      
      $sql = "INSERT INTO users (student_id, username, password) VALUES (?, ?, ?);";
      $sth = $DBH->prepare($sql);
    
      $sth->bindParam(1, $student_id);
      $sth->bindParam(2, $username);
      $sth->bindParam(3, $pass_hashed);
      
      $sth->execute();
      $_SESSION["username"] = $username;
      $_SESSION["student_id"] = $student_id;

      //$message = 'You are now registered '.$username;          
      //redirect to login page after registering
      header('Location: login.php');
  } catch(PDOException $e) {
      echo 'Error' . $e;
    }
}

//test passwords
function valid_pass($password, $password1){
  if($password == $password1){
    if(strlen($password)>=6 and strlen($password)<=10){
      if(ctype_alnum($password)){
        return TRUE;
      }
    }else{
      $pass_err = "*Password requires at least 6 characters<br>";
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
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<h2>CCT Library</h2>
<form class='form-style' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">  
  <label>Studend ID</label><input type="text" name="student_id" required/>
  <span class="error"><?php echo $student_err;?></span>
  <label>Username</label><input type="text" name="username" required/>
  <span class="error"><?php echo $name_err;?></span>
  <label>Password</label><input type="password" name="password" required/>
  <span class="error"><?php echo $pass_err;?></span>
  <label>Repeat Password</label><input type="password" name="password1" required/>
  <span class="error"><?php echo $pass_err;?></span>
  <!-- google captcha -->
  <div class="g-recaptcha" data-sitekey="6Lf4sTsUAAAAAEPvJX2byJxit9ZtYXYMNpBBX7bB"></div>  
  <span class="error" style="font-size:16px;"><?php if(!empty($message)){ echo $message;echo "<br>"; }?></span><br>
  <input type="submit" class='button' name='submit' value= 'Register'/>
</form>
<?php include 'scripts/footer.php'; ?>
</body>
</html>