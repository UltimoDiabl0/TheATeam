<?php
  session_start();
  if(!isset($_SESSION["fail"])){
    $_SESSION["fail"] = false;
    $_SESSION["success"] = false;
  }
?>
<html>

<head>
  <title>Thymer - login</title>
  <link rel="stylesheet" href="./css/master.css">
</head>

<body>

  <form action="login.php" method="post">
    <div class="userText">
      <input type="text" name="username" placeholder="Username">
      <input type="password" name="password" placeholder="Password">
    </div>
    <?php
      if($_SESSION["fail"]){
        echo "<div class='redtext'>";
          echo "<p>Invalid Username or Password! Please Try Again.</p>";
        echo "</div>";
        $_SESSION["fail"] = false;
      }
      if($_SESSION["success"]){
        echo "<div class='bluetext'>";
          echo "<p>Account Creation Successful.</p>";
        echo "</div>";
        $_SESSION["success"] = false;
      }

    ?>
    <div class="lsButtons">
      <input type="submit" name="logIn" value="Log In">
      <a href="signUpView.php">Sign Up</a>
    </div>
  </form>

</body>

</html>
