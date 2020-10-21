<!DOCTYPE html>
<html lang="en">

<head>
  <title>test</title>
</head>
  <body>
  <?php
      try{
        $config = parse_ini_file("db.ini");
        $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        foreach ($dbh->query("SELECT * FROM calendar") as $row) {
            echo '<div>'.$row[0].'</div>';
          }

        } catch (PDOException $e) {
          print "\nError! " . $e->getMessage()."<br/>";
          die();
        }


   ?>
 </body>
</html>
