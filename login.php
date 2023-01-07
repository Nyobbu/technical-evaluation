<?php

session_start();
if (isset($_SESSION['basic_role'])){
  echo "test";
  header('Location: ./index.php');
  exit();
  }


$user = "";
$pass = "";
$postdata = "{\"username\":\"".$user."\",\"password\":\"".$pass."\"}";

function setcreds($username,$password){
  $_SESSION['username'] = $username;
  $_SESSION['password'] = $password;
}

function login(){
  $ch = curl_init();
  $postdata = "{\"username\":\"".$_SESSION['username']."\",\"password\":\"".$_SESSION['password']."\"}";
  curl_setopt($ch, CURLOPT_URL, 'https://netzwelt-devtest.azurewebsites.net/Account/SignIn');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
  
  $headers = array();
  $headers[] = 'Accept: application/json';
  $headers[] = 'Content-Type: application/json';
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  
  $result = curl_exec($ch);
  if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
  }
  curl_close($ch);
  //$item = var_dump(json_decode($result, true));
  $item = json_decode($result,true);
  //echo "<script> 
  //console.log(".json_encode($result,true).");</script>";
  if(isset($item['message']))
    {
      echo $item['message'];
    }
  else
    {
      echo "<script> console.log(".json_encode($result,true).");</script>";
      $_SESSION['basic_role'] = json_encode($item['roles']);
      $_SESSION['login_status'] = '1';
      //echo "<script> console.log(".$_SESSION['login_status'].");</script>";
      header('Location: ./index.php');
    }
  }

  
?>

<html>
  <head>
 <!-- <script src="js/script.js"></script>-->
    <title>
      Technical Examination
    </title>
</head>
<body>
    <h1>
      Log-in
</h1>
<form action="login.php" method = "post" class = 'form'>
  Username:
  <input name = "username" id = "username" type = "text"/> <br/><br/>
  Password:
  <input name = "password" id = "password" type = "password"/> <br/><br/>
  <input name = "enter" type = "submit" value = "Login"/>
</form>
<?php
if(isset($_POST["enter"]))
{
setcreds($_POST['username'],$_POST['password']);
login();
}
?>

</body>
</html>


