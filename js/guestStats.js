var addOrUpdate;

window.onload = function () {
    getStats();
    document.querySelector("table").addEventListener("click", selectHandler); 
    document.querySelector("#btnTopRank").addEventListener("click", getTopRank);  
    document.querySelector("#btnPay").addEventListener("click", getPayouts); 

//    hideAddUpdate();
};
function clearSelections() {
    var trs = document.querySelectorAll("tr");
    for (var i = 1; i < trs.length; i++) {
        trs[i].classList.remove("highlighted");

        // hide 'play' button on each row
        let tds = trs[i].querySelectorAll("td");
        tds[4].classList.add("hidden");
        tds[5].classList.add("hidden");
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
    row[4].classList.remove("hidden");
    row[5].classList.remove("hidden");
}
function getPayouts(text){
    var arrayRank = [];
    let table = document.querySelector("table");
    
    for (let i = 1; i < table.rows.length; i++) { 
        let record = table.rows[i].cells[0].textContent;
        arrayRank[i-1] = record;
        
    }
     console.log(arrayRank);
    for (var i = 0; i < arrayRank.length; i++) {
        let teamID = arrayRank[i];
        let obj = {
            "teamID": teamID
        };
        //AJAX
        let url = "../statsService/teams/" + teamID;
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                let response = xmlhttp.responseText;
                //console.log(response);
                if (response.search("ERROR") >= 0) {
                    alert("Whoops!");
                } else {
                    console.log("DONE!");
                    console.log(response);
                    clearSelections();
                }
            }
        };
        xmlhttp.open("PUT", url, true);
        xmlhttp.send(JSON.stringify(obj));
    }
}
 
//get statistics
function getStats() { 
    //AJAX
    let url = "../statsService/stats/all";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let response = xmlhttp.responseText;
            //console.log(response);
            if (response.search("ERROR") >= 0) {
                alert("Whoops!");
            } else {
                buildTable(xmlhttp.responseText); 
                console.log(response);
                clearSelections();
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    
     
} 
//sort by rank
function getTopRank(){
    //AJAX
    let url = "../statsService/stats/ranks";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let response = xmlhttp.responseText;
            //console.log(response);
            if (response.search("ERROR") >= 0) {
                alert("Whoops!");
            } else {
                buildTable(xmlhttp.responseText); 
                console.log(response);
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
        html += "<td>" + record.score + "</td>";
        html += "<td>" + record.ranking + "</td>";
        html += "<td class='btnCell hidden'>" +
                "<form action='viewPlayers.php' method='POST'>" + 
                "<input type='hidden' name='teamID' value='" + record.teamID + "'>" +
                "<button type='submit' class='cellBtn'>View List of Players</button>" +
                "</form>" +
                "</td>" +
                "<td class='btnCell hidden'>" +
                "<form action='viewListGames.php' method='POST'>" +
                 "<input type='hidden' name='teamID' value='" + record.teamID + "'>" +
                "<button type='submit' class='btnGames'>View List of Games</button>" +
                "</form>" +
                "</td>";
        html += "</tr>";
        
        
    }
    theTable.innerHTML = html;
}

