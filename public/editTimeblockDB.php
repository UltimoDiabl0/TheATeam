<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location:index.php");
  }
 ?>
<?php

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_SESSION['username'])
&& isset($_POST['startTime'])
&& isset($_POST['endTime'])
&& isset($_POST['label'])
&& strlen($_POST['label']) != 0
&& strlen($_POST['startTime']) != 0
&& strlen($_POST['endTime']) != 0
&& strlen($_POST['label']) <= 500 ){

    // Preventing SQL Injection via prepare statement, and escaping variables to use as plain text and not code
    $userHandler = $dbh->prepare("CALL editTimeblock( '".$_SESSION['timeblockID']."','".$_POST['startTime']."', '".$_POST['endTime']."', :label)");
    $userHandler->bindParam(':label', $_POST['label']);
    $userHandler->execute();
    header("Location: calendar.php");

  } else {
    //User input improper information
    $_SESSION['fail'] = true;
    header("Location: calendar.php");

  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }

  ?>
