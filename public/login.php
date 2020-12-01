<?php
session_start();

    try{
      $config = parse_ini_file("db.ini");
      $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if (isset($_POST['username']) && isset($_POST['password']) && strlen($_POST['username']) != 0 && strlen($_POST['password']) != 0){

        // Preventing SQL Injection via prepare statement, and escaping variables to use as plain text and not code
        $userHandler = $dbh->prepare('SELECT loginUser( :username, :password)');
        $userHandler->bindParam(':username', $_POST['username']);
        $userHandler->bindParam(':password', $_POST['password']);
        $userHandler->execute();

        foreach ($userHandler->fetch(PDO::FETCH_ASSOC) as $row) {
            if (!is_null($row[0])) {
              $_SESSION["loggedIn"] = true;
              $_SESSION["username"] = $row;
              header("Location: calendar.php");
              return;
            }
          }
          $_SESSION["fail"] = true;
          header("Location: index.php");
      }else {
        $_SESSION["fail"] = true;
        header("Location: index.php");
      }

      } catch (PDOException $e) {
        print "\nError! " . $e->getMessage()."<br/>";
        die();
      }

 ?>
