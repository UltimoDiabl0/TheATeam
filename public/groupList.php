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
    <div class="navBar">
      <a href="calendar.php">My Calendar</a>
      <a href="groupList.php">My Groups</a>
      <form action="searchUser.php" method='post'>
        <input type="text" placeholder="Search..." name="searchbarInput">
      </form>
      <a href="logout.php" style="float: right;">Log Out</a>
    </div>

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


        //    echo "<p>This is ".$_SESSION['username']."'s Invites </p>";
            echo "<h1> These are your invites </h1>";
            foreach ($dbh->query('CALL getInvites("'.$_SESSION['username'].'")') as $row) {
              ?>
              <div id="displayCurrInvites" class="groupListDisplay">
              </div>
              <script>
              document.open();
              var tempInviteArray = <?php echo json_encode($row); ?>;
              var individualInvite = document.createElement('invite');
              individualInvite.style.width = "20%";
              individualInvite.style.height = "150px";
              individualInvite.style.background = "white";
              individualInvite.style.color = "black";
              individualInvite.style.borderStyle = "solid";
              individualInvite.style.textAlign = "center";
              individualInvite.style.fontSize = "200%";
              individualInvite.innerHTML =  tempInviteArray[5] + "<br/> <form action='acceptInvite.php' method='post'> <input type='hidden' value=" + tempInviteArray[4] + " name='inviteID'> <input type='hidden' value=" + tempInviteArray[2] + " name='groupID'> <input type='submit' value='Accept'> </form> <br/> <form action='denyInvite.php' method='post'> <input type='hidden' value=" + tempInviteArray[4] + " name='inviteID'> <input type='submit' value='Deny'> </form> <p style='font-size:50%'>From: " + tempInviteArray[0] + "</p>";


               document.getElementById("displayCurrInvites").appendChild(individualInvite);
              document.close();
              </script>
              <?php
              //  echo "<form action='denyInvite.php' method='post' class='timeblockDevDisplay' >";

              //    echo "<p>Host User: $row[0],  Current User: $row[1], GroupID: $row[2], Group Label: $row[3] InviteID: $row[4]</p>";
                //  echo "<input type='hidden' value=$row[4] name='inviteID'>";
              //    echo "<input type='submit' value='Deny'>";

            //    echo "</form>";

            //    echo "<form action='acceptInvite.php' method='post' class='timeblockDevDisplay' >";

            //      echo "<input type='hidden' value=$row[4] name='inviteID'>";
            //      echo "<input type='hidden' value=$row[2] name='groupID'>";
            //      echo "<input type='submit' value='Accept'>";

          //      echo "</form>";

            }

          //  echo "<p>This is ".$_SESSION['username']."'s Groups </p>";
            echo "<h1> These are your groups </h1>";
            foreach ($dbh->query('CALL getGroups("'.$_SESSION['username'].'")') as $row) {
              ?>
              <div id="displayCurrGroups" class="groupListDisplay">
              </div>
              <script>
              document.open();
               var tempGroupArray = <?php echo json_encode($row); ?>;
               console.log(tempGroupArray);
               var individualGroup = document.createElement('group');
               individualGroup.style.width = "20%";
               individualGroup.style.height = "150px";
               individualGroup.style.background = "white";
               individualGroup.style.color = "black";
               individualGroup.style.borderStyle = "solid";
               individualGroup.style.textAlign = "center";
               individualGroup.style.fontSize = "200%";
               individualGroup.innerHTML = tempGroupArray[3] + "<br/> <form action='groupView.php' method='post'> <input type='hidden' value=" + tempGroupArray[0] + " name='groupID'><input type='hidden' value=" + tempGroupArray[2] + " name='isHost'> <input type='submit' value='Go To Group'> </form> <br/> <form action='leaveGroup.php' method='post'> <input type='hidden' value=" + tempGroupArray[0] +  " name='groupID'> <input type='hidden' value=" + tempGroupArray[2] +  " name='isHost'> <input type='submit' value='Leave Group'> </form>";
               individualGroup.style.margin = "10px";
               document.getElementById("displayCurrGroups").appendChild(individualGroup);
            document.close();
              </script>

              <?php
                 //echo "<form action='groupView.php' method='post' class='timeblockDevDisplay' >";
                // echo "<p class='groupListDummy'>GroupID: $row[0],  Current User: $row[1], isHost: $row[2], groupName: $row[3], groupType: $row[4], groupDesc: $row[5]</p>";
                //  echo "<input type='hidden' value=$row[0] name='groupID'>";
                //  echo "<input type='hidden' value=$row[2] name='isHost'>";
                //  echo "<input type='submit' value='Go To Group'>";

                //  echo "</form>";
                //  echo "<form action='leaveGroup.php' method='post' class='timeblockDevDisplay' >";
                //  echo "<input type='hidden' value=$row[0] name='groupID'>";
                //  echo "<input type='hidden' value=$row[2] name='isHost'>";
                //  echo "<input type='submit' value='Leave Group'>";
                //  echo "</form>";


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





         <script src="scripts/groupList.js"></script>

    </body>
</html>
