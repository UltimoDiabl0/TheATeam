<?php
  session_start();
 ?>
<?php

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_SESSION['username'])){
    $userStart = array();
    $userEnd = array();
    $targetStart = array();
    $targetEnd = array();

    //put the user's timeblocks into arrays for ease of use
    foreach ($dbh->query('CALL getTimeblocks("'.$_SESSION['username'].'")') as $row) {
      array_push($userStart, $row[1]);
      array_push($userEnd, $row[2]);
    }
    //put the target's timeblocks into arrays for ease of use
    foreach ($dbh->query('CALL getTimeblocks("'.$_POST['otherUser'].'")') as $row) {
      array_push($targetStart, $row[1]);
      array_push($targetEnd, $row[2]);
    }



    $notFound = true;//used to track if there is more to look at
    $userLength = count($userStart);//the number of timeblocks that the user has
    $targetLength = count($targetStart);//the number of timeblocks that the target has
    $userSlider = 0;//used to iterate through both user arrays at once
    $targetSlider = 0;//used to iterate through both target arrays at once
    while($notFound){
//check if the start of a the current user's timeblock falls in the middle of the target's current timeblock


      $temp = array();
      foreach ($dbh->query("SELECT compareTimeblocks('$userStart[$userSlider]','$targetStart[$targetSlider]')")as $row){
        $temp = $row;
      }
      foreach ($dbh->query("SELECT compareTimeblocks('$userStart[$userSlider]','$targetEnd[$targetSlider]')")as $row){
        $temp1 = $row;
      }
      foreach ($dbh->query("SELECT compareTimeblocks('$targetStart[$targetSlider]','$userStart[$userSlider]')")as $row){
        $temp2 = $row;
      }
      foreach ($dbh->query("SELECT compareTimeblocks('$userEnd[$userSlider]','$targetEnd[$targetSlider]')")as $row){
        $temp3 = $row;
      }
      foreach ($dbh->query("SELECT compareTimeblocks('$userEnd[$userSlider]','$targetEnd[$targetSlider]')")as $row){
        $temp4 = $row;
      }


      if ($temp[0] >= 0 && $temp1[0] < 0){

        $notFound = 0;

        $_SESSION['startTime'] = $userStart[$userSlider];
      }
//check if the start of a the current target's timeblock falls in the middle of the user's current timeblock
      elseif($temp2[0]>=0 && $temp3[0]<0){
              $notFound=0;
              $_SESSION['startTime'] = $targetStart[$targetSlider];
      }

        //find which timeblock ends first, and move on to that person's next timeblock
      if ($temp4[0] <= 0){

          $userSlider = $userSlider + 1;
          if ($userSlider >= $userLength){
            $notFound=0;
            break;
          }
        }
      else{

          $targetSlider = $targetSlider + 1;
          if ($targetSlider >= $targetLength){
            $notFound=0;
            break;
          }
        }

        if(!$notFound){
        //  header("Location:calendar.php");
        }
      }



      if (isset($_SESSION['startTime'])){
        echo"<p>Time to start your event: ".$_SESSION['startTime']."</p>";
      }
      else{
        echo"<p>No common time</p>";
      }

      echo "<form action='calendar.php' method='post'>";
        echo"<input type='hidden' value='".$_POST['otherUser']."' name='username'>";
        
        echo "<input type='submit' value='Go Back'>";
      echo "</form>";
      //header("Location:calendar.php");

  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }

  ?>
