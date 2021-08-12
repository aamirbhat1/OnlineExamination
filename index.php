<?php session_start(); ?>
<!DOCTYPE HTML>
<html><head><title>WeLcome To Online Exam</title>
<link href="quiz.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
<script type="text/javascript" src="jquery.min.js"></script>
<style type="text/css">
body {
    background: url(image/background.jfif) center fixed;
    background-repeat: no-repeat;
    background-size: cover;
    font-size: 20px;
  margin-left: 0px;
  margin-top: 0px;
}
.form-group{
  margin-left: 40px;
}
#submit{
  float:left;
  margin-left: 40px;
  margin-right: 10px;
}
#error{
  margin-left: 40px;
  width: 370px;
}
#sign{
  color: white;
}
#sign:hover{ 
  text-decoration: none;
}
</style>
</head>
<body>
  <?php
    include("header.php");
    include("database.php");
extract($_POST);
$error="";
if(array_key_exists("submit",$_POST)) {
  if(mysqli_connect_error()){
    die("Database Connection Error");
  }
  if(!$_POST['loginid']) {
    $error.= " Login id is required <br>";
  }
  if(!$_POST['pass']){
    $error .= "A password is required <br>";
  }
  else{
    $result=mysqli_query($cn,"select * from mst_user where login='$loginid' ");
    $row=mysqli_fetch_array($result);
    if(isset($row))
    {
      $hashedPassword=md5(md5($row['user_id']).$_POST['pass']);
      if ($hashedPassword==$row['pass']) {
         $_SESSION['user_id']=$row['user_id'];
         if ($_POST['stayloggedin']=='1') {
           setcookie("user_id",$row['user_id'],time() +60*60*24*365);
         }
         header('location:login.php');
      }
      else{
      $error="Invalid username or password";
    }
  }
  else{
      $error="Invalid username or password";
    }
   }
}
?>
<marquee>
  <p class="style5"><span class="style7">WelCome to Online exam. This Site will provide the quiz for various subject of interest. You need to login to take the online exam.</span></p>
</marquee>
<?php 
if ($error !="") 
{
    $error ="<p>There were Errors in your Form</p>".$error;
    echo '<div class="alert alert-danger" id="error" role="alert">'.$error.'</div>'; }  
  ?>
<form name="form1" method="post" action="" style="width: 400px;">
  <div class="form-group">
    <label>User Name</label>
    <input type="text" name="loginid" class="form-control" id="loginid2" aria-describedby="emailHelp">
  </div>
  <div class="form-group">
    <label for="Password">Password</label>
    <input type="password" class="form-control"  name="pass" id="pass2">
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" name="stayloggedin" id="exampleCheck1" value=1>
    <label class="form-check-label"  for="exampleCheck1">Remember me</label>
  </div>
  <button type="submit" name="submit" id="submit" class="btn btn-primary">Login</button>
    <button  class="btn btn-success"><a href="signup.php" id="sign">SignUp</a></button>
</form>
<footer>&copy :Aamir</footer>
</body>
</html>
