<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location:index.html");
  }
 ?>
<?php

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_SESSION['username'])){

    if ($_POST['startTime'] <= $_POST['endTime']){
    // Preventing SQL Injection via prepare statement, and escaping variables to use as plain text and not code
    $userHandler = $dbh->prepare("CALL editTimeblock( '".$_SESSION['timeblockID']."','".$_POST['startTime']."', '".$_POST['endTime']."', :label)");
    $userHandler->bindParam(':label', $_POST['label']);
    $userHandler->execute();
      header("Location: calendar.php");
    }
    else {
      $userHandler = $dbh->prepare("CALL editTimeblock( '".$_SESSION['timeblockID']."','".$_POST['startTime']."', '".$_POST['endTime']."', :label)");
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
