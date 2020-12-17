var addOrUpdate;

window.onload = function () {
    getAll();
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
        tds[3].classList.add("hidden");
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
    row[3].classList.remove("hidden");
}

function getAll() {
    //AJAX
    let url = "../teamService/teams";
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
        html += "<td>" + record.teamID + "</td>";
        html += "<td>" + record.teamName + "</td>";
        html += "<td>" + record.earnings + "</td>";
        html += "<td class='btnCell hidden'>" +
                "<form action='viewPlayers.php' method='POST'>" +
                "<input type='hidden' name='teamID' value='" + record.teamID + "'>" +
                "<button type='submit' class='cellBtn'>View Players</button>" +
                "</form>" +
                "</td>";
        html += "</tr>";
    }
    theTable.innerHTML = html;
}

function viewStatistics() {

}