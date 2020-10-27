<?php
  session_start();

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_SESSION['username'])){

    echo "<form action='createGroupDB.php' method='post'>";
      echo "<input type='text' name='groupName' placeholder='Group Name'>";
      echo "<input type='text' name='groupType' placeholder='Group Type'>";
      echo "<input type='text' name='groupDesc' placeholder='Group Description'>";
      echo "<input type='submit' value='Create Group'>";
    echo "</form>";

  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }



 ?>
