<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location: index.php");
  }
 ?>
<html>
<head>
  <title>Tymer - Create Timeblock</title>
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


   <form action='createTimeblockDB.php' method='post'>
     Start Time:
     <input type='datetime-local' name='startTime' pattern="yyyy-mm-dd hh:mm">
     <br>
     End Time:
     <input type='datetime-local' name='endTime' pattern="yyyy-mm-dd hh:mm">
     <br>
     <input type='text' name='label' placeholder='Timeblock Label'>
     <?php
     if($_SESSION['fail']){
        echo "<div class='redtext'>";
          echo "<p> Invalid Inputs! Please fill out the fields. Label must be between 1 and 500 characters.</p>";
        echo "</div>";
        $_SESSION['fail'] = false;
      }
     ?>


     <input type='submit' value='Create Timeblock'>
   </form>

</div>
</body>
</html>
