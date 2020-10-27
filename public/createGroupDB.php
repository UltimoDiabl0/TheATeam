<?php

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_SESSION['username'])){

    $dbh->query("CALL createGroup('".$_POST['groupName']."','".$_POST['groupType']."','".$_POST['groupDesc']."','".$_SESSION['username']."')");
    header("Location: groupList.php");

  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }

  ?>
