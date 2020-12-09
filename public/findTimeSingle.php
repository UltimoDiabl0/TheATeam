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

      echo "<p class='username'>".$_SESSION['username']."</p>";
      foreach ($dbh->query('CALL getTimeblocks("'.$_SESSION['username'].'")') as $row){
        echo "<p class='timeBlockDummy'>User: ".$_SESSION['username'].", Timeblock ID: $row[0],  Start Time: $row[1], End Time: $row[2], Label: $row[3]</p>";
      }
      echo "<p> End ".$_SESSION['username']."'s Timeblocks </p>";

      echo "<p class='username'>".$_POST['username']."</p>";
      foreach ($dbh->query('CALL getTimeblocks("'.$_POST['username'].'")') as $row){
        echo "<p class='timeBlockDummy'>User: ".$_POST['username'].", Timeblock ID: $row[0],  Start Time: $row[1], End Time: $row[2], Label: $row[3]</p>";
      }
      echo "<p> End ".$_POST['username']."'s Timeblocks </p>";

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
