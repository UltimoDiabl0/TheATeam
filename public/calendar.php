<?php
  session_start();
 ?>
<!DOCTYPE html>
<html>
  <!-- TestyTest pls work. -->
  <head>
    <title>Thymer - Calendar</title>
    <link rel="stylesheet" href="./css/master.css">
  </head>

  <body>
    <a href="groupList.php">To Group Page</a>
    <!--In the case you haven't added the logout function, we provided a place for it-->
    <input type='submit' value='Logout'></input>
    <!--Please put php here or wherever is more convinient.-->

    <?php

        try{
          $config = parse_ini_file("db.ini");
          $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          if (isset($_SESSION['username'])){
            echo "<p>This is ".$_SESSION['username']."'s Timeblocks </p>";
            foreach ($dbh->query('CALL getTimeblocks("'.$_SESSION['username'].'")') as $row) {
                echo "<form action='deleteTimeblock.php' method='post' class='timeblockDevDisplay' >";

                  echo "<p>Timeblock ID: $row[0],  Start Time: $row[1], End Time: $row[2], Label: $row[3]</p>";
                  echo "<input type='hidden' value=$row[0] name='timeblockID'>";
                  echo "<input type='submit' value='Delete'>";

                echo "</form>";

            }
          }

          } catch (PDOException $e) {
              print "\nError! " . $e->getMessage()."<br/>";
              die();
          }
     ?>

     <div class="calendarStyle">
       <section class="dayBlock"></section>
       <section class="dayBlock"></section>
       <section class="dayBlock"></section>
       <section class="dayBlock"></section>
       <section class="dayBlock"></section>
       <section class="dayBlock"></section>
       <section class="dayBlock"></section>
     </div>

    </body>
</html>
