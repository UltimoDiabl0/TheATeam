<?php
  session_start();
  session_destroy();
  header("Location: index.html");
    //echo "<form action='logout.php' method='post' class='timeblockDevDisplay' >";
    //echo "<input type='submit' value='Logout'>";
    //echo "</form>";
  ?>
