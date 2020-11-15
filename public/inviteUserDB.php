<?php
  session_start();
 ?>
<?php

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_SESSION['username'])){

    
    // Preventing SQL Injection via prepare statement, and escaping variables to use as plain text and not code
    $userHandler = $dbh->prepare("CALL inviteToGroup( '".$_SESSION['username']."', :usernameInv, '".$_SESSION['groupID']."', :inviteMessage)");
    $userHandler->bindParam(':usernameInv', $_POST['usernameInv']);
    $userHandler->bindParam(':inviteMessage', $_POST['inviteMessage']);
    $userHandler->execute();
    header("Location: groupView.php");

  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }

  ?>
