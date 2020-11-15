<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location: index.html");
  }
 ?>
<html>
<head>
  <title>Tymer - Create Timeblock</title>
</head>
<body>

  <form action='calendar.php' method='post' class='timeblockDevDisplay' >
  <input type='submit' value='Go Back'>
  </form>

   <form action='createTimeblockDB.php' method='post'>
     Start Time:
     <input type='datetime-local' name='startTime' pattern="yyyy-mm-dd hh:mm">
     <br>
     End Time:
     <input type='datetime-local' name='endTime' pattern="yyyy-mm-dd hh:mm">
     <br>
     <input type='text' name='label' placeholder='Timeblock Label'>
     <input type='submit' value='Create Timeblock'>
   </form>


</body>
</html>
