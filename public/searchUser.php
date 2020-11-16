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
    $userHandler = $dbh->prepare("CALL getUser(:username)");
    $userHandler->bindParam(':username', $_POST['searchbarInput']);
    $userHandler->execute();
    foreach ($userHandler->fetch(PDO::FETCH_ASSOC) as $row) {
        if (!is_null($row[0])) {
          $_POST['username'] = $row;
          header("Location: calendar.php");
          return;
        }
      }
  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }

  ?>
