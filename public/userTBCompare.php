<?php
  session_start();

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_SESSION['username'])){

    echo "<form action='logout.php' method='post' class='timeblockDevDisplay' >";
      echo "<input type='submit' value='Logout'>";
    echo "</form>";

    echo "<form action='calendar.php' method='post'>";
      echo "<input type='submit' value='Go Back'>";
    echo "</form>";

    echo "<form action='userTBCompareDB.php' method='post'>";
      echo "<input type='time' name='sharedLength' placeholder='How long?'>";
      echo "<input type='submit' value='Compare Time'>";
      echo "<p> Time to start your event: </p>"
    echo "</form>";

    if (isset($_SESSION['startTime']){

        echo "<p> Time to start your event: $_SESSION['startTime']</p>"
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
