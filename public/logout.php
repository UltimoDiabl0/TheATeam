<?php
  session_start();

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_SESSION['username'])){
    session_destroy();
    header("Location: index.html");
    //echo "<form action='logout.php' method='post' class='timeblockDevDisplay' >";
    //echo "<input type='submit' value='Logout'>";
    //echo "</form>";
  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }


 ?>
