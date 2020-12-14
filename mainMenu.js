window.onload = function () {
    // btn event handlers
    document.querySelector("#btnViewTeams").addEventListener("click", getAll);
};

//function getAll() {
//    //hide addUpdate incase it is opened
//    //hideAddUpdate();
//
//    //AJAX
//    let url = "teamService/teams";
//
//    let xmlhttp = new XMLHttpRequest();
//    xmlhttp.onreadystatechange = function () {
//        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
//            let response = xmlhttp.responseText;
//            if (response.search("ERROR") >= 0) {
//                alert("Whoops!");
//            } else {
//                buildTable(xmlhttp.responseText);
//            }
//        }
//    };
//    xmlhttp.open("GET", url, true);
//    xmlhttp.send();
//}

function clearAddUpdate() {
    // obtain todays date for releaseDate field as placeholder.
    document.querySelector("#inputTeamName").value = "";
}

function showAddUpdate() {
    document.getElementById("divAddUpdate").classList.remove("hidden");
}

//function buildTable(text) {
//    let temp = JSON.parse(text);
//    let theTable = document.querySelector("table");
//    let html = theTable.querySelector("tr").innerHTML;
//    for (let i = 0; i < temp.length; i++) {
//        let record = temp[i];
//        html += "<tr>";
//        html += "<td>" + record.teamID + "</td>";
//        html += "<td>" + record.teamName + "</td>";
//        html += "<td>" + record.earnings + "</td>";
//        html += "</tr>";
//    }
//    theTable.innerHTML = html;
//}