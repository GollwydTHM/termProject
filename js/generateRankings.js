window.onload = function () {
    // btn event handlers
    document.querySelector("#btnView").addEventListener("click", generateList);
    document.querySelector("#btnRank").addEventListener("click", generateRankings);
};

function generateRankings() {
    let output = [];
    let allRows = document.querySelectorAll("tr");
    for (let i = 1; i < allRows.length; i++) {
        let currentScore = allRows[i].querySelectorAll("td")[4].innerHTML;
        let rank = allRows[i].querySelectorAll("td")[5].innerHTML;
        if (currentScore === "null") {
            alert("null score detected. Round cannot be ranked");
            break;
        } else if (rank !== "null") {
            alert("null score detected. Round cannot be ranked");
            break;
        } else {

            let currentMatchID = allRows[i].querySelectorAll("td")[0].innerHTML;
            let currentRoundID = allRows[i].querySelectorAll("td")[1].innerHTML;
            let currentMatchGroup = allRows[i].querySelectorAll("td")[2].innerHTML;
            let currentTeam = allRows[i].querySelectorAll("td")[3].innerHTML;

            let rank = null;
            let temp = [];
            temp = [currentMatchID, currentRoundID, currentMatchGroup, currentTeam, currentScore, rank];
            output[i - 1] = temp;
        }
    }
    //if the if/ifelse are triggered, the output is empty. if else if triggered move ahead
    if (output.length > 0) {
        //this sorts the array
        output.sort(function (a, b) {
            return b[4] - a[4];
        });
        console.log(output);
        //this assigns rank based on the sort
        for (var i = 0; i < output.length; i++) {
            output[i][5] = i + 1;
        }

        for (var i = 0; i < output.length; i++) {
            let obj = {
                "matchID": output[i][0],
                "roundID": output[i][1],
                "matchgroup": output[i][2],
                "teamID": output[i][3],
                "score": output[i][4],
                "ranking": output[i][5]
            };
            let url = "../matchupService/matchup/" + output[i][0];
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {

                    let response = xmlhttp.responseText;
                    console.log(response);
                    if (response.search("ERROR") >= 0) {
                        alert("Whoops!");
                    } else {
                        //maybe rebuild the table? deal with that later
                    }
                }
            };
            xmlhttp.open("PUT", url, true);
            xmlhttp.send(JSON.stringify(obj));
        }
        alert("Round ranked! Onto the next");
    }

}
//NOT MY/OUR CODE REMOVE LATER
function shuffle(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }
    return array;
}


function generateList() {
    let roundID = document.querySelector("#rounds").value;

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
