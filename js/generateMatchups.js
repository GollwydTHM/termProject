window.onload = function () {
    // btn event handlers
//    document.querySelector("#btnSEED1").addEventListener("click", seed1);
//    document.querySelector("#btnSEED2").addEventListener("click", seed2);
//    document.querySelector("#btnSEED3").addEventListener("click", seed3);
//    document.querySelector("#btnSEED4").addEventListener("click", seed4);
////    document.querySelector("#btnRAND1").addEventListener("click", generateList);
////    document.querySelector("#btnSEED2").addEventListener("click", generateList);
////    document.querySelector("#btnSEED3").addEventListener("click", generateList);
////    document.querySelector("#btnSEED4").addEventListener("click", generateList);
////    document.querySelector("#btnFINAL").addEventListener("click", generateList);
    document.querySelector("#btnView").addEventListener("click", generateList);
    document.querySelector("#btnRank").addEventListener("click", getRanks);
//    document.querySelector("#rounds").addEventListener("change", populateMatchSelect);


};

function getRanks() {
    let output = [];
    let allRows = document.querySelectorAll("tr");
    let lastMatchID;
    for (var i = 1; i < allRows.length; i++) {
        let teamID = allRows[i].querySelectorAll("td")[3].innerHTML;
        let rank = allRows[i].querySelectorAll("td")[5].innerHTML;
        lastMatchID = allRows[i].querySelectorAll("td")[0].innerHTML;
        //console.log(lastMatchID);
        output[i] = [teamID, rank];
        output.sort(function (a, b) {
            return b[1] - a[1];
        });
    }
    top16 = output.slice(34);
    top16.sort(function (a, b) {
        return a[1] - b[1];
    });
    console.log(top16);
    top16.splice(-1, 1);
    let pairs = setSEEDPairs(top16);
    console.log(pairs);
    lastMatchID++;
    console.log(lastMatchID);
    console.log(teamID = pairs[0][1]);
    for (var i = 0; i < pairs.length; i++) {
        console.log(i);
        for (var i2 = 0; i2 < 2; i2++) {
            if (i % 2 === 0) {

                teamID = pairs[i2][1];
            } else {
                teamID = pairs[i2][0];
            }
            let obj = {
                "matchID": lastMatchID,
                "teamID": teamID

            };
            lastMatchID++;
            let url = "../matchupService/matchup/" + teamID;

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    let response = xmlhttp.responseText;
                    //console.log(response);
                    if (response.search("ERROR") >= 0) {
                        alert("Whoops!");
                    } else {
                        console.log("test");
                    }
                }
            };
            xmlhttp.open("PUT", url, false);
            xmlhttp.send(JSON.stringify(obj));
        }

    }


}

function setSEEDPairs(inArray) {
    console.log(inArray);
    let pairs = [];
    let totalLength = inArray.length;
    for (var i = 0; i < inArray.length; i++) {
        pairs[i] = [inArray[i][0], inArray[inArray.length - 1][0]];
        inArray.splice(-1, 1);
    }
    return pairs;


}

function generateList() {
    let roundID = document.querySelector("#rounds").value;
//    console.log(matchGroup);
    //updateMatchup();
    //AJAX
    let url = "../matchupService/matchup/" + roundID;
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {

            let response = xmlhttp.responseText;
            //console.log(response);
            if (response.search("ERROR") >= 0) {
                alert("Whoops!");
            } else {
                buildTable(xmlhttp.responseText);
                //clearSelections();
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}
function buildTable(text) {

    let temp = JSON.parse(text);
    let theTable = document.querySelector("table");
    let html = theTable.querySelector("tr").innerHTML;
    for (let i = 0; i < temp.length; i++) {
        let record = temp[i];
        html += "<tr>";
        html += "<td>" + record.matchID + "</td>";
        html += "<td>" + record.roundID + "</td>";
        html += "<td>" + record.matchgroup + "</td>";
        html += "<td>" + record.teamID + "</td>";
        html += "<td>" + record.score + "</td>";
        html += "<td>" + record.ranking + "</td>";
        html += "</tr>";
    }
    theTable.innerHTML = html;
}

//function getRoundData(inRound) {
//    console.log(inRound);
//    generateMatchups(inRound);
//}
//
//function seed1() {
//    let prevRound = "QUAL";
//    getRoundData(prevRound);
//}
//
//function seed2() {
//    let prevRound = "SEED1";
//    getRoundData(prevRound);
//}
//function seed3() {
//    let prevRound = "SEED2";
//    getRoundData(prevRound);
//}
//function seed4() {
//    let prevRound = "SEED3";
//    getRoundData(prevRound);
//}
//
//
//
//function generateMatchups(inRound) {
//    let roundID = inRound;
//
//   
//    //AJAX get list of rankings from previous round
//    let url = "../matchupService/matchup/"+roundID;
//    let xmlhttp = new XMLHttpRequest();
//    xmlhttp.onreadystatechange = function () {
//        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
//            
//            let response = xmlhttp.responseText;
////            console.log("response:")
////            console.log(response);
//            if (response.search("ERROR") >= 0) {
//                alert("Whoops!");
//            } else {
//                buildArray(xmlhttp.responseText);
//            }
//        }
//    };
//    xmlhttp.open("GET", url, true);
//    xmlhttp.send();
//}
//
//function buildArray(inText) {
//    let test = IsValidJSONString(inText);
//    console.log(test);
//    let responseArr = [];
//    console.log(inText);
//    responseArr = JSON.parse(inText);
//    console.log(responseArr);
//    let output = [];
//    for (var i = 0; i < responseArr.length; i++) {
//        let team = responseArr[i].teamID;
//        let rank = responseArr[i].ranking;
//        output[i] = [team, rank];
//    }
//    //sorts and clips rankings
//    output.sort(function (a, b) {
//        return b[1] - a[1];
//    });
//    top16 = output.slice(34);
//    top16.sort(function (a, b) {
//        return a[1] - b[1];
//    });
//    console.log(top16);
//}
//
//function IsValidJSONString(str) {
//    try {
//        JSON.parse(str);
//    } catch (e) {
//        return false;
//    }
//    return true;
//}


//function buildTable(text) {
//
//    let temp = JSON.parse(text);
//    let theTable = document.querySelector("table");
//    let html = theTable.querySelector("tr").innerHTML;
//    for (let i = 0; i < temp.length; i++) {
//        let record = temp[i];
//        html += "<tr>";
//        html += "<td>" + record.matchID + "</td>";
//        html += "<td>" + record.roundID + "</td>";
//        html += "<td>" + record.matchgroup + "</td>";
//        html += "<td>" + record.teamID + "</td>";
//        html += "<td>" + record.score + "</td>";
//        html += "<td>" + record.ranking + "</td>";
//        html += "</tr>";
//    }
//    theTable.innerHTML = html;
//}
//
//let top16 = [];
//function generateMatchups() {
//    let roundID = "QUAL";
//
//    let responseArr = [];
//    //AJAX get list of rankings from previous round
//    let url = "../matchupService/matchup/" + roundID;
//    let xmlhttp = new XMLHttpRequest();
//    xmlhttp.onreadystatechange = function () {
//        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
//
//            let response = xmlhttp.responseText;
//            //console.log(response);
//            if (response.search("ERROR") >= 0) {
//                alert("Whoops!");
//            } else {
//                let responseArr = JSON.parse(response);
//                let output = [];
//                for (var i = 0; i < responseArr.length; i++) {
//                    let team = responseArr[i].teamID;
//                    let rank = responseArr[i].ranking;
//                    output[i] = [team, rank];
//                }
//                //sorts and clips rankings
//                output.sort(function (a, b) {
//                    return b[1] - a[1];
//                });
//                top16 = output.slice(34);
//                top16.sort(function (a, b) {
//                    return a[1] - b[1];
//                });
//                xmlhttp.timeout=4000;
//                console.log(top16);
//
//            }
//        }
//    };
//    xmlhttp.open("GET", url, false);
//    xmlhttp.send();
//
//
//    //console.log(responseArr);
//
//
//    //this is empty now?
//    //console.log(top16);
//    let allRows = document.querySelectorAll("tr");
//
//    console.log(allRows);
//    //sync first loop with the match group numbers in table to get matchid, then update
//    let matchGroup;
//    for (var i = 0; i < 8; i++) {
//        matchGroup = i + 1;
//        let matchID;
//        for (var i3 = 1; i3 < allRows.length; i3++) {
//            let tableGroup = allRows[i3].querySelectorAll("td")[2].innerHTML;
//            if (tableGroup == matchGroup) {
//                matchID = allRows[i3].querySelectorAll("td")[0].innerHTML;
//                console.log(matchID);
//                let teamID;
//                if (i3 % 2 === 0) {
//                    teamID = top16[top16.length - 1];
//                } else {
//                    teamID = top16[0];
//                }
//                let obj = {
//                    "matchID": matchID,
//                    "teamID": teamID
//
//                };
//                let url = "../matchupService/matchup/" + teamID;
//                let xmlhttp = new XMLHttpRequest();
//                xmlhttp.onreadystatechange = function () {
//                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
//
//                        let response = xmlhttp.responseText;
//                        //console.log(response);
//                        if (response.search("ERROR") >= 0) {
//                            alert("Whoops!");
//                        } else {
//                            console.log("test");
//                        }
//                    }
//                };
//                xmlhttp.open("PUT", url, false);
//                xmlhttp.send(JSON.stringify(obj));
//            }
//            top16.splice(top16.length - 1);
//            top16.shift();
//        }
//    }
//}
//
//
//function generateList() {
//    let roundID = document.querySelector("#rounds").value;
//
//    //AJAX
//    let url = "../matchupService/matchup/" + roundID;
//    let xmlhttp = new XMLHttpRequest();
//    xmlhttp.onreadystatechange = function () {
//        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
//
//            let response = xmlhttp.responseText;
//            //console.log(response);
//            if (response.search("ERROR") >= 0) {
//                alert("Whoops!");
//            } else {
//                buildTable(xmlhttp.responseText);
//                //clearSelections();
//            }
//        }
//    };
//    xmlhttp.open("GET", url, false);
//    xmlhttp.send();
//    
//}
//
//
