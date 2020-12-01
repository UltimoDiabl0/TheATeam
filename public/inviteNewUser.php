<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location: index.html");
  }
 ?>
<html>
<head>
  <title>Tymer - Invite User</title>
  <link rel="stylesheet" href="./css/master.css">
</head>
<body>

  <form action='groupView.php' method='post' class='timeblockDevDisplay' >
  <input type='submit' value='Go Back'>
  </form>

   <form action='inviteUserDB.php' method='post'>
     <input type='text' name='usernameInv' placeholder='Users Name'>
     <input type='text' name='inviteMessage' placeholder='Invite Message'>
     <?php
     if($_SESSION['fail']){
       echo "<div class='redtext'>";
        echo "<p>Failed to Invite user! Username must be between 1 and 32 characters and the message must be between 1 and 500 characters.</p>";
       echo "</div>";
       $_SESSION['fail'] = false;
     }
     ?>
     <input type='submit' value='Invite'>
   </form>


</body>
</html>
