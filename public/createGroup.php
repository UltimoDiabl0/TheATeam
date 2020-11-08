<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location: index.html");
  }
 ?>
<html>
<head>
  <title>Tymer - Create Group</title>
</head>
<body>

  <form action='groupList.php' method='post' class='timeblockDevDisplay' >
  <input type='submit' value='Go Back'>
  </form>

   <form action='createGroupDB.php' method='post'>
     <input type='text' name='groupName' placeholder='Group Name'>
     <input type='text' name='groupType' placeholder='Group Type'>
     <input type='text' name='groupDesc' placeholder='Group Description'>
     <input type='submit' value='Create Group'>
   </form>


</body>
</html>
