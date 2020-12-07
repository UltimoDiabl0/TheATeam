<?php
  session_start();
 ?>
<?php

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_SESSION['username'])){
    $targetStart = array();
    $targetEnd = array();
    $init = 0;
    foreach($dbh->query('SELECT username FROM inGroup WHERE inGroup.groupID = "'.$_SESSION['groupID'].'"') as $userList){
      if($init){
        $holdStart = array();
        $holdEnd = array();
        $userStart = array();
        $userEnd = array();
        foreach ($dbh->query('CALL getTimeblocks("'.$userList[0].'")') as $row) {
          array_push($userStart, $row[1]);
          array_push($userEnd, $row[2]);
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
          foreach ($dbh->query("SELECT compareTimeblocks('$targetStart[$targetSlider]','$userEnd[$userSlider]')")as $row){
            $temp3 = $row;
          }
          foreach ($dbh->query("SELECT compareTimeblocks('$userEnd[$userSlider]','$targetEnd[$targetSlider]')")as $row){
            $temp4 = $row;
          }


          if ($temp[0] >= 0 && $temp1[0] < 0){
            if ($temp4[0]<1){
              array_push($holdStart,$userStart[$userSlider]);
              array_push($holdEnd,$userEnd[$userSlider]);
            }
            else{
              array_push($holdStart,$userStart[$userSlider]);
              array_push($holdEnd,$targetEnd[$targetSlider]);
            }
          }
    //check if the start of a the current target's timeblock falls in the middle of the user's current timeblock
          elseif($temp2[0]>=0 && $temp3[0]<0){
            if ($temp4[0]<1){
              array_push($holdStart,$targetStart[$targetSlider]);
              array_push($holdEnd,$userEnd[$userSlider]);
            }
            else{
              array_push($holdStart,$targetStart[$targetSlider]);
              array_push($holdEnd,$targetEnd[$targetSlider]);
            }
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
          }






        $targetStart = $holdStart;
        $targetEnd = $holdEnd;
      }
      else{
        $init = 1;
        foreach ($dbh->query('CALL getTimeblocks("'.$userList[0].'")') as $row) {
          array_push($targetStart, $row[1]);
          array_push($targetEnd, $row[2]);
        }
      }
    }


    if (count($targetStart)>0){
      echo"<p>Time to start your event: ".$targetStart[0]."</p>";
    }
    else{
      echo"<p>No common time</p>";
    }
    echo "<form action='groupView.php' method='post'>";
      echo "<input type='submit' value='Go Back'>";
    echo "</form>";


  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }

  ?>
