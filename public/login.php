<?php
session_start();

    try{
      $config = parse_ini_file("db.ini");
      $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if (isset($_POST['username']) and isset($_POST['password']) ){
        foreach ($dbh->query("SELECT loginUser(\"".$_POST['username']."\",\"".$_POST['password']."\")") as $row) {
            if (!is_null($row[0])) {
              $_SESSION["loggedIn"] = true;
              $_SESSION["userID"] = $row[0];
              header("Location: calendar.php");
              return;
            }
          }
        header("Location: login.html");
      }

      } catch (PDOException $e) {
        print "\nError! " . $e->getMessage()."<br/>";
        die();
      }
      
 ?>
