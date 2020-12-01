<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location:index.php");
  }
 ?>
<!DOCTYPE html>
<html>

  <head>
    <title>Thymer - Group</title>
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

            echo "<form action='calendar.php' method='post' class='timeblockDevDisplay' >";
              echo "<input type='submit' value='Go Back'>";
            echo "</form>";

            echo "<form action='createGroup.php' method='post' class='timeblockDevDisplay' >";
              echo "<input type='submit' value='Create Group'>";
            echo "</form>";


            echo "<p>This is ".$_SESSION['username']."'s Invites </p>";
            foreach ($dbh->query('CALL getInvites("'.$_SESSION['username'].'")') as $row) {
                echo "<form action='denyInvite.php' method='post' class='timeblockDevDisplay' >";

                  echo "<p>Host User: $row[0],  Current User: $row[1], GroupID: $row[2], Group Label: $row[3] InviteID: $row[4]</p>";
                  echo "<input type='hidden' value=$row[4] name='inviteID'>";
                  echo "<input type='submit' value='Deny'>";


                echo "</form>";

                echo "<form action='acceptInvite.php' method='post' class='timeblockDevDisplay' >";

                  echo "<input type='hidden' value=$row[4] name='inviteID'>";
                  echo "<input type='hidden' value=$row[2] name='groupID'>";
                  echo "<input type='submit' value='Accept'>";

                echo "</form>";

            }

            echo "<p>This is ".$_SESSION['username']."'s Groups </p>";
            foreach ($dbh->query('CALL getGroups("'.$_SESSION['username'].'")') as $row) {
                echo "<form action='groupView.php' method='post' class='timeblockDevDisplay' >";

                  echo "<p>GroupID: $row[0],  Current User: $row[1], isHost: $row[2], groupName: $row[3] groupType: $row[4] groupDesc: $row[5]</p>";
                  echo "<input type='hidden' value=$row[0] name='groupID'>";
                  echo "<input type='hidden' value=$row[2] name='isHost'>";
                  echo "<input type='submit' value='Go To Group'>";

                  echo "</form>";
                  echo "<form action='leaveGroup.php' method='post' class='timeblockDevDisplay' >";
                  echo "<input type='hidden' value=$row[0] name='groupID'>";
                  echo "<input type='hidden' value=$row[2] name='isHost'>";
                  echo "<input type='submit' value='Leave Group'>";
                  echo "</form>";


            }

          }

          else{
            header("Location: index.html");
          }

          } catch (PDOException $e) {
              print "\nError! " . $e->getMessage()."<br/>";
              die();
          }
     ?>
    </body>
</html>
