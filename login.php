<?php

session_start();
$url = "https://netzwelt-devtest.azurewebsites.net/Account/SignIn";

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
<form method = "post" class = 'form'>
  Username:
  <input name = "username" id = "username" type = "text"/> <br/><br/>
  Password:
  <input name = "password" id = "password" type = "password"/> <br/>
  <input type = "submit" value = "Login"/>
</form>
<!-- Script to post fetch api here -->
<script>
  const formSend = document.querySelector('.form');
  formSend.addEventListener('submit', event =>{
    event.preventDefault();

    const formData = new FormData(formSend);
    const data = Object.fromEntries(formData);
    fetch('https://netzwelt-devtest.azurewebsites.net/Account/SignIn', {
      method: 'POST',
      headers:{
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    });
  });
  </script>
</body>
</html>


