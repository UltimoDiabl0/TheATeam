<?php
  session_start();
 ?>
<?php

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_SESSION['username'])){

    if ($_POST['startTime']<=$_POST['endTime']){
    // Preventing SQL Injection via prepare statement, and escaping variables to use as plain text and not code
      $userHandler = $dbh->prepare("CALL createTimeblock( '".$_SESSION['username']."',:startTime, :endTime, :label )");
      $userHandler->bindParam(':startTime', $_POST['startTime']);
      $userHandler->bindParam(':endTime', $_POST['endTime']);
      $userHandler->bindParam(':label', $_POST['label']);
      $userHandler->execute();
      header("Location: calendar.php");
    }
    else {
      $userHandler = $dbh->prepare("CALL createTimeblock( '".$_SESSION['username']."',:startTime, :endTime, :label )");
      $userHandler->bindParam(':startTime', $_POST['endTime']);
      $userHandler->bindParam(':endTime', $_POST['startTime']);
      $userHandler->bindParam(':label', $_POST['label']);
      $userHandler->execute();
      header("Location: calendar.php");
    }
  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }

  ?>
