<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location: index.html");
  }
 ?>
<html>
<head>
  <title>Tymer - Invite User</title>
</head>
<body>

  <form action='groupView.php' method='post' class='timeblockDevDisplay' >
  <input type='submit' value='Go Back'>
  </form>

   <form action='inviteUserDB.php' method='post'>
     <input type='text' name='usernameInv' placeholder='Users Name'>
     <input type='text' name='inviteMessage' placeholder='Invite Message'>
     <input type='submit' value='Invite'>
   </form>


</body>
</html>
