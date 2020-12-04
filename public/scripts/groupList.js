
pushThrough();

function pushThrough(){
  //for loop defining how many times to do This
  //The php calls getGroups, CALL getGroups, is there a way I could use that in this javascript to create
  //a foor loop or a for each loop that loops the amount of groups that the user is console.log(require('util').inspect(, { depth: null }));
  var i;
//  for (i=0;i<){

  //TODO: something something invites idk im tired
  //Find each of the groups the user is on based off the php results, then store them in an array
  var groupQuery = document.querySelectorAll("p.groupListDummy");
  var groups = [];

  groupQuery.forEach(function(groupTag) {
    var innerTxt = groupTag.innerText.split(', ');
    console.log(innerTxt);
    var id = innerTxt[0].split(': ')[1];
    var isHost = innerTxt[2].split(': ')[1];
    var gName = innerTxt[3].split(': ')[1];
    var gType = innerTxt[4].split(': ')[1];
    var gDesc = innerTxt[5].split(': ')[1];
    console.log();
    groups.push(parseGroup(parseInt(id), parseInt(isHost), gName, gType, gDesc))
  })

  console.log(groups);

  //document.getElementById("groupListGroups").innerHTML = 1 + 1;
}

function parseGroup(id, isHost, name, type, desc) {
  //This thing is an object, it has an id as a number (which should be parsed!)
  const obj = {};

  obj.id = id;

  switch(isHost) {
    case 1:
      obj.isHost = true;
      break;
    default:
      obj.isHost = false;
      break;
  }

  obj.name = name;

  obj.type = type;

  obj.desc = desc;

  return obj;
}
