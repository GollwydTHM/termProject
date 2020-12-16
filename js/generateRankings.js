window.onload = function () {
    // btn event handlers
    document.querySelector("#btnView").addEventListener("click", generateList);
    document.querySelector("#btnRank").addEventListener("click", generateRankings);

    document.querySelector("#rounds").addEventListener("change", populateMatchSelect);
};

function generateRankings() {
    let output = [];
    let allRows = document.querySelectorAll("tr");
    let noNull = false;
    for (let i = 1; i < allRows.length; i++) {
        let currentScore = allRows[i].querySelectorAll("td")[4].innerHTML;
        let rank = allRows[i].querySelectorAll("td")[5].innerHTML;
        if (currentScore === "null") {
            alert("null score detected. Round cannot be ranked");
            noNull = false;
            break;
        } else if (rank !== "null") {
            alert("score detected. Round has already been ranked");
            noNull = false;
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
            noNull = true;
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
                        generateList();
                    }
                }
            };
            xmlhttp.open("PUT", url, true);
            xmlhttp.send(JSON.stringify(obj));
        }
        alert("Round ranked! Onto the next");
    }

}


function generateList() {
    let roundID = document.querySelector("#rounds").value;
    let matchGroup = document.querySelector("#matchGroup").value;
    console.log(matchGroup);
    //AJAX
    let url = "../matchupService/matchup/" + roundID + "/" + matchGroup;
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
    
    updateMatchup();
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

function populateMatchSelect() {
    let roundID = document.querySelector("#rounds").value;
    let idNum = roundID.charAt(4);
    let total = 0;
    let output = "<select id='matchGroup' name='matchGroup'>";
    if (idNum === "1") {
        total = 8;
    } else if (idNum === "2") {
        total = 4
    } else if (idNum === "3") {
        total = 2
    } else {
        total = 1
    }
    let number = 0;
    for (var i = 0; i < total; i++) {
        number = i + 1;
        output += "<option value='" + number + "'>" + number + "</option>";
    }
    output += "</select>";
    document.getElementById('optionList').innerHTML = output;
    console.log(output);
}

function updateMatchup() {
    for (var i = 0; i < 50; i++) {
        let url = "../matchupService/matchup/ScoreMatch/" + i;

        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                let resp = xmlhttp.responseText;
                if (resp.search("ERROR") >= 0 || resp != "1") {
                    console.log(resp);
                    alert("Error occered when PUT");
                } else {
                    //alert("Updated!");
                }
            }
        };
        xmlhttp.open("PUT", url, true);
        xmlhttp.send();
    }


}