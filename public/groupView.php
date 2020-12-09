<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location:index.php");
  }
 ?>
<!DOCTYPE html>
<html>

  <head>
    <title>Thymer - Groups</title>
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
              if(isset($_POST['groupID'])){
                  $_SESSION['groupID'] = $_POST['groupID'];
                  $_SESSION['isHost'] = $_POST['isHost'];
              }

              //echo "<form action='logout.php' method='post' class='timeblockDevDisplay' >";
              //  echo "<input type='submit' value='Logout'>";
              //echo "</form>";

              //echo "<form action='groupList.php' method='post'>";
              //  echo "<input type='submit' value='Go Back'>";
              //echo "</form>";

              echo "<form action='groupTBCompare.php' method='post'>";
                echo "<input type='submit' value='Find Time'>";
              echo "</form>";

              if($_SESSION['isHost'] == 1){

              echo "<form action='inviteNewUser.php' method='post'>";
                echo "<input type='submit' value='Invite New User'>";
              echo "</form>";

            }
              /* For every user in the group*/
              foreach ($dbh->query('SELECT username FROM inGroup WHERE inGroup.groupID = "'.$_SESSION['groupID'].'"') as $row) {
                /* If the user is not the person looking at the page */
                if($_SESSION['username'] != $row[0]){

                  ?>

                  <div id="displayGroupUsers" class="groupListDisplay">
                  </div>
                  <script type="text/javascript">
                  document.open();

                  var groupUsername = <?php echo json_encode($row); ?>;
                  var individualUser = document.createElement('user');
                  var userGroupID = "<?= $_SESSION['groupID'] ?>";
                  individualUser.style.width = "20%";
                  individualUser.style.height = "100px";
                  individualUser.style.background = "white";
                  individualUser.style.color = "black";
                  individualUser.style.borderStyle = "solid";
                  individualUser.style.textAlign = "center";
                  individualUser.style.fontSize = "200%";
                  individualUser.style.marginRight = "1em";
                //  individualUser.style.borderRadius = "20px";
                  individualUser.innerHTML =  groupUsername[0] + "<br/><form action='calendar.php' method='post'> <input type='hidden' value=" + groupUsername[0] + " name='username'> <input type='submit' value='View Calendar'> </form>";


                   document.getElementById("displayGroupUsers").appendChild(individualUser);
                  document.close();
                  </script>
                  <?php

              //    echo "<p>$row[0]:</p>";
            //      echo "<form action='calendar.php' method='post' class='timeblockDevDisplay' >";
            //        echo "<input type='hidden' value=$row[0] name='username'>";
            //        echo "<input type='submit' value='View Calendar'>";
            //      echo "</form>";
                  /* If the current user is the host */
                    if($_SESSION['isHost'] == 1){
                      /* And if the user we are looking at is not the user looking at the page */
                      if($_SESSION['username'] != $row[0]){
                        ?>
                        <script>


                    //    var groupUsername = <?php echo json_encode($row); ?>;
                        var individualUserHost = document.getElementById('displayGroupUsers');

                        console.log(groupUsername[0]);
                        console.log(userGroupID);
                        //indiviualUserHost.style.maxheight = "106px";
                        /*
                        individualUserHost.style.width = "20%";
                        individualUserHost.style.height = "100px";
                        individualUserHost.style.background = "white";
                        individualUserHost.style.color = "black";
                        individualUserHost.style.borderStyle = "solid";
                        individualUserHost.style.textAlign = "center";
                        individualUserHost.style.fontSize = "200%";
                        individualUserHost.style.marginRight = "1em";
                      //  individualUser.style.borderRadius = "20px";*/
                    //  individualUser.innerHTML = "<p> hi </p>";
                        individualUser.innerHTML =  groupUsername[0] + "<br/><form action='calendar.php' method='post' class='groupViewButton'> <input type='hidden' value=" + groupUsername[0] + " name='username'> <input type='submit' value='View Calendar'> </form>  <form action='kick.php' method='post' class='inlineButtons'> <input type='hidden' value=" + userGroupID + " name='groupID'> <input type='hidden' value=" + groupUsername[0] + " name='toBeKicked'> <input type='hidden' value='0' name='toBeKicked'> <input type='submit' value='Kick'> </form> <form action='promoteToHost.php' method='post' class='inlineButtons'> <input type='hidden' value=" + userGroupID + " name='groupID'> <input type='hidden' value=" + groupUsername[0] + " name='newHost'> <input type='submit' value='Make Host'> </form>";

                         document.getElementById("displayGroupUsers").appendChild(individualUser);

                        </script>
                        <?php

                      //  echo "<form action='kick.php' method='post'>";
                      //    echo "<input type='hidden' value='".$_SESSION['groupID']."' name='groupID'>";
                      //    echo "<input type='hidden' value=$row[0] name='toBeKicked'>";
                      //    echo "<input type='hidden' value='0' name='toBeKicked'>";
                      //    echo "<input type='submit' value='Kick'>";
                      //  echo "</form>";

                      //  echo "<form action='promoteToHost.php' method='post'>";
                      //    echo "<input type='hidden' value='".$_SESSION['groupID']."' name='groupID'>";
                      //    echo "<input type='hidden' value=$row[0] name='newHost'>";
                      //    echo "<input type='submit' value='Make Host'>";
                      //  echo "</form>";

                      }
                    }
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
