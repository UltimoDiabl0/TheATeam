<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location:index.php");
  }
 ?>
<!DOCTYPE html>
<html>

  <head>
    <title>Thymer - Calendar</title>
    <link rel="stylesheet" href="./css/master.css">
  </head>

  <body>
    <?php

        try{
          $config = parse_ini_file("db.ini");
          $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          if (isset($_SESSION['username'])){

            echo "<form action='logout.php' method='post' class='timeblockDevDisplay' >";
              echo "<input type='submit' value='Logout'>";
            echo "</form>";

            if(isset($_POST['username'])){

              echo "<form action='groupView.php' method='post' class='timeblockDevDisplay' >";
                echo "<input type='submit' value='Go Back'>";
              echo "</form>";

              echo "<form action='findTimeSingle.php' method='post'>";
                echo"<input type='hidden' value='".$_POST['username']."' name='otherUser'>";
                echo "<input type='submit' value='Find Time'>";
              echo "</form>";

              echo "<p>This is ".$_POST['username']."'s Timeblocks </p>";
              foreach ($dbh->query('CALL getTimeblocks("'.$_POST['username'].'")') as $row) {
                  echo "<form class='timeblockDevDisplay' >";
                    echo "<p>Timeblock ID: $row[0],  Start Time: $row[1], End Time: $row[2], Label: $row[3]</p>";
                  echo "</form>";
                }

          }else{
            echo "<a href='groupList.php'>To Group Page</a>";
            if($_SESSION['fail']){
              echo "<div class='redtext'>";
                echo "<p>Failed to edit Timeblock</p>";
              echo "</div>";
              $_SESSION['fail'] = false;
            }
            echo "<p>This is ".$_SESSION['username']."'s Timeblocks </p>";
            echo "<form action='createTimeblock.php' method='post'>";
              echo "<input type='submit' value='Create New Timeblock'>";
            echo "</form>";
            foreach ($dbh->query('CALL getTimeblocks("'.$_SESSION['username'].'")') as $row) {
                echo "<form action='deleteTimeblock.php' method='post' class='timeblockDevDisplay' >";

                  echo "<p>Timeblock ID: $row[0],  Start Time: $row[1], End Time: $row[2], Label: $row[3]</p>";
                  echo "<input type='hidden' value=$row[0] name='timeblockID'>";
                  echo "<input type='submit' value='Delete'>";

                echo "</form>";

                echo "<form action='editTimeblock.php' method='post'>";
                  echo "<input type='hidden' value=$row[0] name='timeblockID'>";
                  echo "<input type='submit' value='Edit'>";
                echo "</form>";
            }
          }
        }


          } catch (PDOException $e) {
              print "\nError! " . $e->getMessage()."<br/>";
              die();
          }
     ?>
    </body>
</html>
