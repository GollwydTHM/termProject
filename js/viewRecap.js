var gameStateID;

window.onload = function () {
    document.querySelector("table").addEventListener("click", selectHandler);
    document.querySelector("#btnView").addEventListener("click", getAll);
//    hideAddUpdate();
};

function clearSelections() {
    var trs = document.querySelectorAll("tr");
    for (var i = 1; i < trs.length; i++) {
        trs[i].classList.remove("highlighted");

        // hide 'play' button on each row
        let tds = trs[i].querySelectorAll("td");
        tds[6].classList.add("hidden");
    }
}

function selectHandler(e) {
    //add style to parent of clicked cell
    clearSelections();
    e.target.parentElement.classList.add("highlighted");

    // get selected row, then target button td and remove hidden class
    let rows = document.querySelector("table").querySelectorAll("tr");
    let selection;
    for (let i = 0; i < rows.length; i++) {
        if (rows[i].classList.contains("highlighted")) {
            selection = i;
            break;
        }
    }
    let row = rows[selection].querySelectorAll("td");
    row[6].classList.remove("hidden");
    gameStateID = row[3].innerHTML;
    console.log(gameStateID);
}

function getAll() {
    //hide addUpdate incase it is opened
    //hideAddUpdate();

    //AJAX
    let url = "../gameService/games/Cplt";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let response = xmlhttp.responseText;
            //console.log(response);
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

function buildTable(text) {
    let temp = JSON.parse(text);
    let theTable = document.querySelector("table");
    let html = theTable.querySelector("tr").innerHTML;
    for (let i = 0; i < temp.length; i++) {
        let record = temp[i];
        html += "<tr>";
        html += "<td>" + record.gameID + "</td>";
        html += "<td>" + record.matchID + "</td>";
        html += "<td>" + record.gameNumber + "</td>";
        html += "<td>" + record.gameStateID + "</td>";
        html += "<td>" + record.score + "</td>";
        html += "<td>" + record.balls + "</td>";
        html += "<td class='btnCell hidden'>" +
                "<form action='../scoreCard.php' method='POST'>" +
                "<input type='hidden' name='gameID' value='" + record.gameID + "'>" +
                "<input type='hidden' name='matchID' value='" + record.matchID + "'>" +
                "<input type='hidden' name='gameNumber' value='" + record.gameNumber + "'>" +
                "<input type='hidden' name='gameStateID' value='" + record.gameStateID + "'>" +
                "<input type='hidden' name='gameBalls' value='" + ((record.balls === null) ? "" : record.balls) + "'>" +
                "<button type='submit' class='cellBtn'>Play</button>" +
                "</form>" +
                "</td>";
        html += "</tr>";
    }
    theTable.innerHTML = html;
}