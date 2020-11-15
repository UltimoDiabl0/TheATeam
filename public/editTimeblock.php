<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location: index.html");
  }else{
      $_SESSION['timeblockID'] = $_POST['timeblockID'];
  }
 ?>
<html>
<head>
  <title>Tymer - Edit Timeblock</title>
</head>
<body>

  <form action='calendar.php' method='post' class='timeblockDevDisplay' >
  <input type='submit' value='Go Back'>
  </form>

   <form action='editTimeblockDB.php' method='post'>
     New Start Time:
     <input type='datetime-local' name='startTime' pattern="yyyy-mm-dd hh:mm">
     <br>
     New End Time:
     <input type='datetime-local' name='endTime' pattern="yyyy-mm-dd hh:mm">
     <br>
     <input type='text' name='label' placeholder='New Timeblock Label'>
     <input type='submit' value='Edit Timeblock'>
   </form>


</body>
</html>
