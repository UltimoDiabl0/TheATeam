<?php
  session_start();
 ?>

 <head>
   <title>Thymer - Find Time</title>
   <link rel="stylesheet" href="./css/master.css">
 </head>

 <body>

  <?php

      $config = parse_ini_file("db.ini");
      $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if (isset($_SESSION['username'])){
        if(isset($_POST['groupID'])){
            $_SESSION['groupID'] = $_POST['groupID'];
            $_SESSION['isHost'] = $_POST['isHost'];
        }
      }

      foreach($dbh->query('SELECT username FROM inGroup WHERE inGroup.groupID = "'.$_SESSION['groupID'].'"') as $row) {
          echo "<p class='username'>$row[0]</p>";
          foreach ($dbh->query('CALL getTimeblocks("'.$row[0].'")') as $row2){
            echo "<p class='timeBlockDummy'>User: $row[0], Timeblock ID: $row2[0],  Start Time: $row2[1], End Time: $row2[2], Label: $row2[3]</p>";
          }
          echo "<p> End $row[0]'s Timeblocks </p>";
      }


   ?>

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
   <script src="scripts/findTime.js"></script>


 </body>
