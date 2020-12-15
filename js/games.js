var addOrUpdate;

window.onload = function () {
    
    document.querySelector("table").addEventListener("click", selectHandler);
    document.querySelector("#btnView").addEventListener("click", getAll);
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
     
}

function getAll() {
    //hide addUpdate incase it is opened
//    hideAddUpdate();

    //AJAX
    let url = "../gameService/games";
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

function buildTable(text) {
    
    let temp = JSON.parse(text);
    console.log(temp);
    let theTable = document.querySelector("table");
    let html = theTable.querySelector("tr").innerHTML;
    for (let i = 0; i < temp.length; i++) {
        let record = temp[i];
        html += "<tr>";
        html += "<td>" + record.gameID + "</td>";
        html += "<td>" + record.matchID + "</td>";
        html += "<td>" + record.gameNumber + "</td>";
        html += "<td>" + record.gameStateID + "</td>";
        html += "<td>" + record.gameScore + "</td>";
        html += "<td>" + record.gameBalls + "</td>";
        html += "</tr>";
    }
    theTable.innerHTML = html;
}

function viewStatistics(){
    
}