var addOrUpdate;

window.onload = function () {
    
    document.querySelector("table").addEventListener("click", selectHandler);
    document.querySelector("#btnView").addEventListener("click", getStats); 
    document.querySelector("#btnTopRank").addEventListener("click", getTopRank); 


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
        html += "</tr>";
    }
    theTable.innerHTML = html;
}

