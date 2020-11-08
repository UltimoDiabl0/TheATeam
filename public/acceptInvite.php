<?php
session_start();

    try{
      $config = parse_ini_file("db.ini");
      $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if (isset($_SESSION['username'])){

        $dbh->query("CALL addToGroup('".$_POST['groupID']."','".$_SESSION['username']."')");

        $dbh->query("CALL denyInvite('".$_POST['inviteID']."')");
        header("Location: groupList.php");

      }

      } catch (PDOException $e) {
        print "\nError! " . $e->getMessage()."<br/>";
        die();
      }

 ?>
