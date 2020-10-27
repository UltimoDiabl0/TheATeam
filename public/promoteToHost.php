<?php
session_start();

    try{
      $config = parse_ini_file("db.ini");
      $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if (isset($_SESSION['username'])){

        $dbh->query("CALL changeHost('".$_SESSION['groupID']."','".$_POST['newHost']."','".$_SESSION['username']."')");
        $_SESSION['isHost'] = 0;
        
        header("Location: groupView.php");

      }

      } catch (PDOException $e) {
        print "\nError! " . $e->getMessage()."<br/>";
        die();
      }

 ?>
