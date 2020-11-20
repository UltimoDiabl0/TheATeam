<?php
  session_start();
 ?>
<?php

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_POST['groupName']) && isset($_POST['groupType']) && isset($_POST['groupDesc'])){

    // Preventing SQL Injection via prepare statement, and escaping variables to use as plain text and not code
    $userHandler = $dbh->prepare("CALL createGroup( :groupName, :groupType, :groupDesc, '".$_SESSION['username']."')");
    $userHandler->bindParam(':groupName', $_POST['groupName']);
    $userHandler->bindParam(':groupType', $_POST['groupType']);
    $userHandler->bindParam(':groupDesc', $_POST['groupDesc']);
    $userHandler->execute();
    header("Location: groupList.php");

  }else{
    header("Location: createGroup.php");
  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }

  ?>
