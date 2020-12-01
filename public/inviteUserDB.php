<?php
  session_start();
 ?>
<?php

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_SESSION['username'])
  && isset($_POST['usernameInv'])
  && isset($_POST['inviteMessage'])
  && isset($_SESSION['groupID'])
  && strlen($_POST['usernameInv']) != 0
  && strlen($_POST['inviteMessage']) != 0
  && strlen($_POST['usernameInv']) <= 32
  && strlen($_POST['inviteMessage']) <= 500){


    // Preventing SQL Injection via prepare statement, and escaping variables to use as plain text and not code
    $userHandler = $dbh->prepare("CALL inviteToGroup( '".$_SESSION['username']."', :usernameInv, '".$_SESSION['groupID']."', :inviteMessage)");
    $userHandler->bindParam(':usernameInv', $_POST['usernameInv']);
    $userHandler->bindParam(':inviteMessage', $_POST['inviteMessage']);
    $userHandler->execute();
    header("Location: groupView.php");

  } else {
    $_SESSION['fail'] = true;
    header("Location: inviteNewUser.php");
  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }

  ?>
