<?php
  session_start();
 ?>
<!DOCTYPE html>
<html>

  <head>
    <title>Thymer - Groups</title>
    <link rel="stylesheet" href="./css/master.css">
  </head>

  <body>

    <?php

        try{
          $config = parse_ini_file("db.ini");
          $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          if (isset($_SESSION['username'])){
            if(isset($_POST['groupID'])){
                $_SESSION['groupID'] = $_POST['groupID'];
                $_SESSION['isHost'] = $_POST['isHost'];
            }
            echo "<form action='groupList.php' method='post'>";
              echo "<input type='submit' value='Go Back'>";
            echo "</form>";


            foreach ($dbh->query('SELECT username FROM inGroup WHERE inGroup.groupID = "'.$_SESSION['groupID'].'"') as $row) {
              echo "<p>This is $row[0]'s Timeblocks</p>";
              if($_SESSION['isHost'] == 1){
                if($_SESSION['username'] != $row[0]){
                  echo "<form action='kick.php' method='post'>";
                    echo "<input type='hidden' value='".$_SESSION['groupID']."' name='groupID'>";
                    echo "<input type='hidden' value=$row[0] name='toBeKicked'>";
                    echo "<input type='submit' value='Kick'>";
                  echo "</form>";

                  echo "<form action='promoteToHost.php' method='post'>";
                    echo "<input type='hidden' value='".$_SESSION['groupID']."' name='groupID'>";
                    echo "<input type='hidden' value=$row[0] name='newHost'>";
                    echo "<input type='submit' value='Make Host'>";
                  echo "</form>";
                }
              }
              foreach ($dbh->query('CALL getTimeblocks("'.$row[0].'")') as $timeblock) {
                echo "<form action='deleteTimeblock.php' method='post' class='timeblockDevDisplay' >";

                  echo "<p>Timeblock ID: $timeblock[0],  Start Time: $timeblock[1], End Time: $timeblock[2], Label: $timeblock[3]</p>";

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
