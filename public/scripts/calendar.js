
//Given a date, we will take said day and get out a day of the week.
/** dateToDay(Date _date){
  //Get the day of the week in the form of an integer value, where sunday=0 and saturday=6
  var dayOfWeek = _date.getDay();

  return dayOfWeek;

}

//
function writeToDay(Date startTime, Date endTime){



}**/

var curTime = Date.now();

buildCalendar();

function buildCalendar() {

  console.log("BuildCalendar");

  //Get the current date and time to help build the calendar.
  //

  //Get all the elements holding the printed timeBlocks
  //Made a class called 'timeBlockDummy' which just is there to distinquish the time block paragraphs from the one before
  //saying that this is the user's timeblocks.
  var timeBlockQuery = document.querySelectorAll("p.timeBlockDummy");
  var timeBlocks = [];

  //Loop through each of the p blocks and get the time necessary for input into the timeBlocks.
  timeBlockQuery.forEach(function(time){
    var innerTxT = time.innerText.split(' ');
    var startDate = convertToTime(innerTxT[5]+' '+innerTxT[6]);
    var endDate = convertToTime(innerTxT[9]+' '+innerTxT[10]);
    //Create the timeblock while making sure the id (test[2]) is a number at base 10
    timeBlocks.push(createTimeBlock(parseInt(innerTxT[2], 10), startDate, endDate, innerTxT[12]));
  } );

  console.log(timeBlocks);


  //Now the juicy stuff, making the calendar appear!
  //The container to hold each day of the current week.
  var dayContainer = document.querySelector('#calendar');
  var weekContainer = document.querySelector('#week');

  //TODO: Determine the current day's Day of week int
  //      loop through and find each day before and make sections for those
  //      make a section for it
  //      Loop through and find each day in the future and make a section for it.
  //      Finally, add the necessary information into each section.
  //      How? For now we should just put the raw info, we can make it prettier later.

  //Start of the week.
  var sunday = pointToSunday(new Date(curTime));
  var timeBlockCopy = [...timeBlocks];

  for (let i=0; i<7; i++){
      //Again each day is worth 86400000ms
      var day = new Date(sunday.getTime()+(86400000*i));
      //24 hours per day, 60 minutes per hour
      //Think for now we'll just go for hourly blocks.

      //First, create the day.
      document.open();
      //.innerHTML
      var dayBlock = document.createElement('section');
      dayBlock.classList.add('dayLabel');
      dayBlock.innerHTML = day.toDateString();
      weekContainer.appendChild(dayBlock);

      //Now get the timeblocks
      var testTimeBlock = document.createElement('section');
      //Now apply its class and add it as a child to the container.
      testTimeBlock.classList.add('dayBlock');

      insertTimeBlocks(testTimeBlock, timeBlockCopy, day);

      dayContainer.appendChild(testTimeBlock);

      document.close();

  }

  document.open();

  var devDisplays = document.querySelectorAll("form.timeblockDevDisplay");

  console.log(devDisplays);

  devDisplays.forEach(function(devDisplay){
    removeBlock(devDisplay);
  });

  document.close();

  console.log(timeBlockCopy)

}

//Insert a time block into the day block specified.
//This may occur twice if only start time or end time are used.
//Takes in the newly created dayblock, as well as the list of timeblocks.
function insertTimeBlocks(dayBlockElement, timeBlocks, curDay) {

  //Open the document and be ready to create the blocks necessary.
  document.open();

  console.log(curDay.toDateString());
    for(let i = 0; i < 24; i++){
      var testTimeBlock = document.createElement('section');
      //testTimeBlock.style.height = '10px';
      testTimeBlock.style.height = ((1/24)*100)+'%';
      testTimeBlock.classList.add('timeBlockDisplay');


      timeBlocks.forEach(function(timeBlock){

        //console.log(timeBlock.endTime.getTime() - timeBlock.startTime.getTime());
        var totalTime = timeBlock.endTime.getTime() - timeBlock.startTime.getTime(); //Total time in MS the timeblock is active for
        //3600000
        var totalHours = Math.ceil(totalTime / 3600000);
        console.log(totalHours);

        console.log(timeBlock.startTime.getTime() + ", " + timeBlock.endTime.getTime() + ", " + curDay.getTime());


        console.log(dayCompare(timeBlock.startTime, curDay));
        //Current solution: Listing them all by the hour.
        if (timeBlock.startTime.getMonth() <= curDay.getMonth() && timeBlock.endTime.getMonth() >= curDay.getMonth()){

          if (timeBlock.startTime.getDate() <= curDay.getDate() && timeBlock.endTime.getDate() >= curDay.getDate()) {

              var curHour = curDay.getTime() + (i*3600000);
              var curNextHour = curHour + 3600000;

              console.log(curDay.getDate()+","+i+",")
              console.log(timeBlock.startTime.getTime() >= curHour && timeBlock.startTime.getTime() < curNextHour);

              //TODO: Make this not millitary time
              if ((timeBlock.isPrinting == true) && (timeBlock.endTime.getTime() >= curHour && !(timeBlock.endTime.getTime() <= curNextHour))) {
                //TODO: Add functionality to delete and edit buttons.
                testTimeBlock.innerHTML = (curDay.getHours() + i) + ":00 " + timeBlock.label;
              }

              if (timeBlock.startTime.getTime() >= curHour && timeBlock.startTime.getTime() < curNextHour) {
                //Checks if the timeblock start time falls within the current hour and the next hour
                testTimeBlock.innerHTML = (curDay.getHours() + i) + ":00 " + timeBlock.label
                + "<form action='editTimeblock.php' method='post'  class='basicButton'>"
                    + "<input type='hidden' value="+timeBlock.id+" name='timeblockID'>"
                    + " <input type='submit' value='Edit'>"
                + "</form>"
                + "<form action='deleteTimeblock.php' method='post'  class='basicButton' >"
                    + "<input type='hidden' value="+timeBlock.id+" name='timeblockID'>"
                    + "<input type='submit' value='Delete'>";
                + "</form>"
                timeBlock.isPrinting = true;
              }

          }
          //testTimeBlock.appendChild(); //Append the php delete button
        }
      });

      dayBlockElement.appendChild(testTimeBlock);

      //Start and end on same day

      //Start on this day, but end on another

      //Did not start on this day, but started before, and does not end today

      //Did not start on this day, but ends on this day.




    }

    document.close();

}

//Create a time block object which converts the starttime and endtime into dates as well as maintaining the id and label
function createTimeBlock(id, startTime, endTime, label) {
  //This thing is an object, it has an id as a number (which should be parsed!)
  const obj = {};
  obj.id = id;
  //It has a start and end time (which should be converted into time!)
  obj.startTime = startTime;
  obj.endTime = endTime;
  //And a label, it can be a string
  obj.label = label;
  obj.isPrinting = false;
  return obj;
}

//For how our php devs export the phps, they export the information in a way that makes it
//REALLY convenient for making new dates, we just need to remove a comma from the end to get a proper
//Date value
//Time is a string here! Not a date!
function convertToTime(time){
  //The string's length is a total of 21 characters, meaning we just need to slice it from the first to the second to
  //Last to get the string we need to make a date.
  var realTime = time.slice(0, 19);
  //Now we can make a proper date and return it.
  const date = new Date(realTime);
  return date;
}

function pointToSunday(date){
  //One day is 86400000 milliseconds
  var dayOfWeek = date.getDay();
  var time = date.getTime();
  var newDate = new Date(time-(86400000*dayOfWeek));
  console.log(newDate.getFullYear() + " " + (newDate.getMonth() + 1) + " " + newDate.getDate() + " ");
  var newerDate = new Date(newDate.getFullYear(), newDate.getMonth(), newDate.getDate(), 0, 0, 0, 0);
  return newerDate;
}

//Compares the two's dates by checking the actual date, the month and year
//If all of these are equal for both days, returns true, else false.
function dayCompare(day1, day2){

  if (day1.getFullYear() != day2.getFullYear()) {
    return false;
  }

  if (day1.getMonth() != day2.getMonth()) {
    return false;
  }

  if (day1.getDate() != day2.getDate()){
    return false;
  }

  return true;
}

//For some reason calling this function properly removed the element rather than just making the element call remove from the loop it's used in
//So we gotta keep this.
function removeBlock(elem) {
  elem.remove();
}


function getNextWeek() {

}
