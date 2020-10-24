<?php
session_start();

    try{
      $config = parse_ini_file("db.ini");
      $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if (isset($_POST['username']) and isset($_POST['password']) and ($_POST['password'] == $_POST['passConfirm']) and ($_POST['username'] != "") and ($_POST['password'] != "") and ($_POST['passConfirm'] != "")){

        // Preventing SQL Injection via prepare statement, and escaping variables to use as plain text and not code
        $userHandler = $dbh->prepare('CALL createUser( :username, :password, :timezone)');
        $userHandler->bindParam(':username', $_POST['username']);
        $userHandler->bindParam(':password', $_POST['password']);
        $userHandler->bindParam(':timezone', $_POST['timezone']);

        if($userHandler->execute()){
            //User created successful account
            header("Location: index.html");
        } else {
            //User failed to create successful account
            header("Location: signUp.html");
        }

      } else {
        //User failed to input correct information
        header("Location: signUp.html");
      }

      } catch (PDOException $e) {
        print "\nError! " . $e->getMessage()."<br/>";
        die();
      }

 ?>
