<?php
  session_start();
  if (!isset($_SESSION['username'])){
    header("Location:index.html");
  }
 ?>
<?php

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_SESSION['username'])){

    // Preventing SQL Injection via prepare statement, and escaping variables to use as plain text and not code
    $userHandler = $dbh->prepare('SELECT getUser(:username)');
    $userHandler->bindParam(':username', $_POST['searchbarInput']);
    $userHandler->execute();
    foreach ($userHandler->fetch(PDO::FETCH_ASSOC) as $row) {
        if (!is_null($row[0])) {
          $_SESSION['usernameSearched'] = $row;
          header("Location: calendar.php");
          return;
        }else{
          header("Location: calendar.php");
        }
      }
  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }

  ?>
