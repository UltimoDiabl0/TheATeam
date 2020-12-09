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


          $cache_session_username = (isset($_SESSION['username']))?$_SESSION['username']:'';
          $cache_post_username = (isset($_POST['username']))?$_POST['username']:$_SESSION['username'];
          $cache_session_usernameSearched = (isset($_SESSION['usernameSearched']))?$_SESSION['usernameSearched']:$_SESSION['username'];


          if (isset($_SESSION['username'])){

          //  echo "<form action='logout.php' method='post'  >";
          //    echo "<input type='submit' value='Logout'>";
        //    echo "</form>";
            echo "".$_POST['username']."";
            if(isset($_POST['username']) || isset($_SESSION['usernameSearched'])){

              if(isset($_SESSION['usernameSearched'])){
                echo "<form action='calendar.php'>";
                  echo "<input type='submit' value='Go Back'>";
                echo "</form>";

                echo "<form action='findTimeSingle.php' method='post'>";
                  echo "<input type='hidden' value=".$_SESSION['usernameSearched']." name='username'>";
                  echo "<input type='submit' value='Find Time'>";
                echo "</form>";

                echo "<p>This is ".$_SESSION['usernameSearched']."'s Timeblocks </p>";
                foreach ($dbh->query('CALL getTimeblocks("'.$_SESSION['usernameSearched'].'")') as $row) {
                    echo "<form class='timeblockDevDisplay' >";
                      echo "<p class='timeBlockDummy'>Timeblock ID: $row[0],  Start Time: $row[1], End Time: $row[2], Label: $row[3]</p>";
                    echo "</form>";
                  }
                  $_SESSION['usernameSearched'] = $_SESSION['username'];
              }else{

                echo "<form action='groupView.php' method='post'  >";
                  echo "<input type='submit' value='Go Back'>";
                echo "</form>";

              echo "<form action='userTBCompareDB.php' method='post'>";
                echo"<input type='hidden' value='".$_POST['username']."' name='otherUser'>";

                echo "<input type='submit' value='Find Time'>";
              echo "</form>";

              if (isset($_SESSION['startTime'])){
                $_SESSION['startTime'] = null;
              }

              echo "<p>This is ".$_POST['username']."'s Timeblocks </p>";
              foreach ($dbh->query('CALL getTimeblocks("'.$_POST['username'].'")') as $row) {
                  echo "<form class='timeblockDevDisplay' >";
                    echo "<p class='timeBlockDummy'>Timeblock ID: $row[0],  Start Time: $row[1], End Time: $row[2], Label: $row[3]</p>";
                  echo "</form>";
                }
              }
          }else{
            //echo "<a href='groupList.php'>To Group Page</a>";
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

                  echo "<p class='timeBlockDummy'>Timeblock ID: $row[0],  Start Time: $row[1], End Time: $row[2], Label: $row[3]</p>";
                  echo "<input type='hidden' value=$row[0] name='timeblockID'>";
                  echo "<input class='tbDeleteButton' type='submit' value='Delete'>";

                echo "</form>";

                echo "<form action='editTimeblock.php' method='post' class='timeblockDevDisplay'>";
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

          <!--
            This is for frontenders to put in, do not fret my backend brothers.
          -->

          <!--
            We actually need to perform a seperate script here due to the fact javascript
            Normally cannot get php information on its own file,
            so we need to obtain it from the php file.
            Thankfully I have learned a better way than copying and pasting from the forms itself.
         -->

          <script type="text/javascript">
            var sessionUser = "<?= $cache_session_username ?>";
            var calenderUser = "<?= $cache_post_username ?>";
            var secretSessionUser = "<?= $cache_session_usernameSearched ?>";
          </script>

          <button onclick="getLastWeek()">Last Week</button>
          <button onclick="getNextWeek()">Next Week</button>

          <div id="week" value="daysOfWeek" class="calendarStyle">
            <!--<section class="dayLabel">Sunday</section>
            <section class="dayLabel">Monday</section>
            <section class="dayLabel">Tuesday</section>
            <section class="dayLabel">Wednesday</section>
            <section class="dayLabel">Thursday</section>
            <section class="dayLabel">Friday</section>
            <section class="dayLabel">Saturday</section>-->
          </div>
          <div class="calendarStyle" id="calendar">
            <!--
            <section value="0" class="dayBlock"></section>
            <section value="1" class="dayBlock"></section>
            <section value="2" class="dayBlock"></section>
            <section value="3" class="dayBlock"></section>
            <section value="4" class="dayBlock"></section>
            <section value="5" class="dayBlock"></section>
            <section value="6" class="dayBlock"></section>
          -->
          </div>
          <script src="scripts/calendar.js"></script>

    </body>
</html>
