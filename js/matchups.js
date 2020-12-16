var addOrUpdate;

window.onload = function () {
    
    document.querySelector("table").addEventListener("click", selectHandler);
    document.querySelector("#btnView").addEventListener("click", getAll);
    document.querySelector("#btnUpdate").addEventListener("click", updateScore);
//    hideAddUpdate();
};
function clearSelections() {
    var trs = document.querySelectorAll("tr");
    for (var i = 0; i < trs.length; i++) {
        trs[i].classList.remove("highlighted");
    }
}
function selectHandler(e) {
    //add style to parent of clicked cell
    clearSelections();
    e.target.parentElement.classList.add("highlighted");
    document.querySelector("#btnUpdate").removeAttribute("disabled");
}

function getAll() {
    //hide addUpdate incase it is opened
    //hideAddUpdate();

    //AJAX
    let url = "../matchupService/matchup";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let response = xmlhttp.responseText;
            console.log(response);
            if (response.search("ERROR") >= 0) {
                alert("Whoops!");
            } else {
                buildTable(xmlhttp.responseText);
                clearSelections();
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    
     
}
function updateScore(){
    
    console.log("im hhere");
    var tds = document.querySelector(".highlighted").querySelectorAll("td");
    let matchID = tds[0].innerHTML;
    let roundID = tds[1].innerHTML;
    let matchGroup = tds[2].innerHTML;
    let teamID = tds[3].innerHTML;
    let score = tds[4].innerHTML;
    let ranking = tds[5].innerHTML;
    
    
    let obj = {
        "matchID": matchID,
        "roundID": roundID,
        "matchGroup": matchGroup,
        "teamID": teamID,
        "score": score,
        "ranking": ranking
    };
    //AJAX
    let url = "../matchupService/matchup/" + matchID;
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let response = xmlhttp.responseText;
            //console.log(response);
            if (response.search("ERROR") >= 0) {
                alert("Whoops!");
            } else {
                alert("Updated");
                getAll();
            }
        }
    };
    xmlhttp.open("PUT", url, true);
    xmlhttp.send(JSON.stringify(obj));
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



