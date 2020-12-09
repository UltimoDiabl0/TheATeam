<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location: index.php");
  }
 ?>
<html>
<head>
  <title>Tymer - Create Group</title>
    <link rel="stylesheet" href="./css/master.css">
</head>
<body>
  <div class="navBar">
    <a href="calendar.php">My Calendar</a>
    <a href="groupList.php">My Groups</a>
    <form action="searchUser.php" method='post'>
      <input type="text" placeholder="Search..." name="searchbarInput">
    </form>
    <a href="logout.php" style="float: right;">Log Out</a>
  </div>
  <div class="indexCenter">
    <h1> Create a group! </h1>
   <form action='createGroupDB.php' method='post'>
     <input type='text' name='groupName' placeholder='Group Name'>
     <input type='text' name='groupType' placeholder='Group Type'>
     <input type='text' name='groupDesc' placeholder='Group Description'>
     <input type='submit' value='Create Group'>
   </form>
   <?php
    if($_SESSION['fail']){
      echo "<div class='redtext'>";
        echo "<p>Creation Failed! Name must be between 1 and 32 characters, Type must be between 1 and 32 characters ,and Description must be between 1 and 500 characters</p>";
      echo "</div>";
      $_SESSION['fail'] = false;
    }

   ?>

</div>
</body>
</html>
