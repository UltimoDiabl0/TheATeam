
//Given a date, we will take said day and get out a day of the week.
/** dateToDay(Date _date){
  //Get the day of the week in the form of an integer value, where sunday=0 and saturday=6
  var dayOfWeek = _date.getDay();

  return dayOfWeek;

}

//
function writeToDay(Date startTime, Date endTime){



}**/

const curDayBlock = createTimeBlock(-1, Date.now(), Date.now(), "NullTimeBlock");

buildCalendar();

function buildCalendar() {

  console.log("BuildCalendar");

  //Get the current date and time to help build the calendar.
  var curTime = Date.now();

  //Get all the elements holding the printed timeBlocks
  //Made a class called 'timeBlockDummy' which just is there to distinquish the time block paragraphs from the one before
  //saying that this is the user's timeblocks.
  var timeBlockQuery = document.querySelectorAll("p.timeBlockDummy");
  var timeBlocks = [curDayBlock];

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
  var dayContainer = document.querySelector('calendar');

}

//Create a time block object which converts the starttime and endtime into dates as well as maintaining the id and label
function createTimeBlock(id, startTime, endTime, label){
  //This thing is an object, it has an id as a number (which should be parsed!)
  const obj = {};
  obj.id = id;
  //It has a start and end time (which should be converted into time!)
  obj.startTime = startTime;
  obj.endTime = endTime;
  //And a label, it can be a string
  obj.label = label;
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
