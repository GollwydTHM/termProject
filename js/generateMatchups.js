window.onload = function () {
    // btn event handlers
    document.querySelector("#btnView").addEventListener("click", generateList);
    document.querySelector("#btnMatch").addEventListener("click", generateMatchups);

};

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


function generateMatchups() {
    let roundID = "QUAL";
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
                let responseArr = JSON.parse(response);
                //console.log(responseArr);
                let output = [];
                for (var i = 0; i < responseArr.length; i++) {
                    let team = responseArr[i].teamID;
                    let rank = responseArr[i].ranking;
                    output[i] = [team, rank];
                }
                output.sort(function (a, b) {
                    return b[1] - a[1];
                });
                let top16 = output.slice(34);
                top16.sort(function (a, b) {
                    return a[1] - b[1];
                });
                for (var i = 0; i < 8; i++) {
                    console.log(i);
                    
                    
                }

                //console.log(top16);
//                for (var i = 0; i < 8; i++) {
//                    
//                }
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
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


