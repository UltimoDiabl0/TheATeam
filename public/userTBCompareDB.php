<?php
  session_start();
 ?>
<?php

try{
  $config = parse_ini_file("db.ini");
  $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_SESSION['username'])){
    userStart = array();
    userEnd = array();
    targetStart = array();
    targetEnd = array();

    //put the user's timeblocks into arrays for ease of use
    foreach ($dbh->query('CALL getTimeblocks("'.$_SESSION['username'].'")') as $row) {
      array_push(userStart, $row[1]);
      array_push(userEnd, $row[2]);
    }
    //put the target's timeblocks into arrays for ease of use
    foreach ($dbh->query('CALL getTimeblocks("'.$_POST['username'].'")') as $row) {
      array_push(targetStart, $row[1]);
      array_push(targetEnd, $row[2]);
    }



    notFound = true;//used to track if there is more to look at
    userLength = count(userStart);//the number of timeblocks that the user has
    targetLength = count(targetStart);//the number of timeblocks that the target has
    userSlider = 0;//used to iterate through both user arrays at once
    targetSlider = 0;//used to iterate through both target arrays at once
    while(notFound){
//check if the start of a the current user's timeblock falls in the middle of the target's current timeblock
      if (userStart[userSlider]>=targetStart[targetSlider]&&userStart[userSlider]<targetEnd[targetSlider]){
        if(userEnd[userSlider]<=targetEnd[targetSlider]){
          if (date_diff(userStart[userSlider],userEnd[userSlider])>=$POST['sharedLength']){
            notFound=false;
            $_SESSION['startTime']=userStart[userSlider];

          }
        }
        else{
          if (date_diff(userStart[userSlider],targetEnd[userSlider])>=$POST['sharedLength']){
            notFound=false;
            $_SESSION['startTime']=userStart[userSlider];
          }
        }
      }
//check if the start of a the current target's timeblock falls in the middle of the user's current timeblock
        elseif(targetStart[targetSlider]>=userStart[userSlider]&&targetStart[targetSlider]<userEnd[userSlider]){
          if(userEnd[userSlider]<=targetEnd[targetSlider]){
            //check if there is enough time for the user's request
            if (date_diff(targetStart[targetSlider],userEnd[userSlider])>=$POST['sharedLength']){
              notFound=false;
              $_SESSION['startTime']=targetStart[targetSlider];
            }
          }
          else{
            if (date_diff(targetStart[targetSlider],targetEnd[userSlider])>=$POST['sharedLength']){
              notFound=false;
              $_SESSION['startTime']=targetStart[targetSlider];
            }
          }
        }
        //find which timeblock comes first, and move on to that person's next timeblock
        if (userEnd[userSlider]<=targetEnd[targetSlider]){
          userSlider = userSlider + 1;
          if (userSlider>=userLength){
            notFound=false;
          }
        }
        else{
          targetSlider = targetSlider + 1;
          if (targetSlider>=targetLength){
            notFound=false;
          }
        }

      }



      header("Location: userTBCompare.php");

  }

  } catch (PDOException $e) {
    print "\nError! " . $e->getMessage()."<br/>";
    die();
  }

  ?>
