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

              echo "<form action='logout.php' method='post' class='timeblockDevDisplay' >";
                echo "<input type='submit' value='Logout'>";
              echo "</form>";

              echo "<form action='groupList.php' method='post'>";
                echo "<input type='submit' value='Go Back'>";
              echo "</form>";

              echo "<form action='findTimeGroup.php' method='post'>";
                echo "<input type='submit' value='Find Time'>";
              echo "</form>";

              if($_SESSION['isHost'] == 1){

              echo "<form action='inviteNewUser.php' method='post'>";
                echo "<input type='submit' value='Invite New User'>";
              echo "</form>";

            }

              foreach ($dbh->query('SELECT username FROM inGroup WHERE inGroup.groupID = "'.$_SESSION['groupID'].'"') as $row) {
                if($_SESSION['username'] != $row[0]){
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

                    echo "<form action='calendar.php' method='post' class='timeblockDevDisplay' >";
                      echo "<input type='hidden' value=$row[0] name='username'>";
                      echo "<input type='submit' value='View Calendar'>";
                    echo "</form>";
              }
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
