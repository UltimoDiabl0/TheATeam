<?php
session_start();

    try{
      $config = parse_ini_file("db.ini");
      $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if (isset($_POST['username'])
      && isset($_POST['password'])
       && (strcmp($_POST['password'], $_POST['passConfirm']) == 0)
       && (strlen($_POST['username']) != 0)
       && (strlen($_POST['password']) != 0)
       && (strlen($_POST['passConfirm']) != 0)
       && strlen($_POST['username']) <= 32
       && strlen($_POST['password']) <= 32
       && strlen($_POST['passConfirm']) <= 32){

        // Preventing SQL Injection via prepare statement, and escaping variables to use as plain text and not code
        $userHandler = $dbh->prepare('CALL createUser( :username, :password, :timezone)');
        $userHandler->bindParam(':username', $_POST['username']);
        $userHandler->bindParam(':password', $_POST['password']);
        $userHandler->bindParam(':timezone', $_POST['timezone']);

        if($userHandler->execute()){
            //User created successful account
            $_SESSION["success"] = true;
            header("Location: index.php");
        } else {
            //User failed to create successful account
            $_SESSION["fail"] = true;
            header("Location: signUpView.php");
        }

      } else {
        //User failed to input correct information
        $_SESSION["fail"] = true;
        header("Location: signUpView.php");
      }

      } catch (PDOException $e) {
        print "\nError! " . $e->getMessage()."<br/>";
        die();
      }

 ?>
