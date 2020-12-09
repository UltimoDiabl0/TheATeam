<?php
session_start();

?>

<html>

<head>
  <title>Thymer - Sign Up</title>
  <link rel="stylesheet" href="./css/master.css">
</head>

<body>
  <div class="indexCenter">
    <img src="images/ThymerLogo.png"/>
    <h1> New User? Sign up here! </h1>


  <form action="signUp.php" method="post">
    <div class="userText">
      <input type="text" name="username" placeholder="Username">
      <input type="password" name="password" placeholder="Password">
      <input type="password" name="passConfirm" placeholder="Confirm Password">
      <select name="timezone" ID="timezone">
        <option value="EST"> EST </option>
        <option value="PST"> PST </option>
        <option value="CST"> CST </option>
        <option value="MST"> MST </option>
        <option value="CET"> CET </option>
        <option value="GMT"> GMT </option>
        <option value="EET"> EET </option>
        <option value="MSK"> MSK </option>
        <option value="WGT"> WGT </option>
      </select>
    </div>
    <?php
    if($_SESSION["fail"]){
      echo "<div class='redtext'>";
        echo "<p> Invalid Inputs! Username must be between 1 and 32 characters. Password must also be between 1 and 32 characters. </p>";
      echo "</div>";
      $_SESSION["fail"] = false;
    }

    ?>
    <div class="lsButtons">
      <input type="submit" name="signUp" value="Sign Up">
    </div>

  </form>
  <h1> Already have an account? </h1>
  <form action=index.php method='post'>
    <input type='submit' value='Go Back'>
  </form>
</div>
</body>

</html>
