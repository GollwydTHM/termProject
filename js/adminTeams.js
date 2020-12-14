var addOrUpdate;

window.onload = function () {
    // btn event handlers
    
    document.querySelector("#btnGet").addEventListener("click", getAll);
    document.querySelector("#btnAdd").addEventListener("click", addTeam);
    document.querySelector("#btnUpdate").addEventListener("click", updateTeam);
    document.querySelector("#btnDelete").addEventListener("click", deleteTeam);
    document.querySelector("#btnOK").addEventListener("click", processForm);
    document.querySelector("#btnCancel").addEventListener("click", hideUpdatePanel);
      

    // event handler for table selection
    document.querySelector("table").addEventListener("click", selectHandler);

    hideUpdatePanel();
};
function clearSelections() {
    var trs = document.querySelectorAll("tr");
    for (var i = 0; i < trs.length; i++) {
        trs[i].classList.remove("highlighted");
    }
}
function selectHandler(e) {
    clearSelections();
    e.target.parentElement.classList.add("highlighted");
    document.querySelector("#btnUpdate").removeAttribute("disabled");
    document.querySelector("#btnDelete").removeAttribute("disabled");
}



function processForm() {
    console.log("processform start");
    //variable declarations for validation
    
    let teamID = Number(document.querySelector("#inputID").value);
    let teamName = document.querySelector("#inputTeamName").value;
    let earnings = Number(document.querySelector("#inputEarnings").value);
    //validation successful, create team object
    let obj = {
        "teamID": teamID,
        "teamName": teamName,
        "earnings": earnings
    };
    
       
    //determine the directory for AJAX call
    let url = "../teamService/teams/" + teamID;
    //determine which method do we use for AJAX call?
    let method = (addOrUpdate === "add") ? "POST" : "PUT";

    //AJAX
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            if (resp.search("ERROR") >= 0 || resp != "1") {
                console.log(resp);
                alert("Error occered when " + method);
            } else {
                alert("Updated!");
                getAll(); 
            }
        }
    };
    xmlhttp.open(method, url, true);
    xmlhttp.send(JSON.stringify(obj));
}



function deleteTeam() {
    var teamID = document.querySelector(".highlighted").querySelector("td").innerHTML;
    console.log(teamID);
    
     

    //AJAX
    let url = "../teamService/teams/" + teamID;
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            console.log(resp);
            if (resp.search("ERROR") >= 0 || resp != "1") {
                alert("Team could not be deleted.");
            } else {
                alert("The team has been DELETED from the database.");
                getAll();
            }
        }
    };
    xmlhttp.open("DELETE", url, true);
    xmlhttp.send();

}
function addTeam() {
    // Show panel, panel handler takes care of the rest
    addOrUpdate = "add";
    resetUpdatePanel();
    showUpdatePanel();
}

function updateTeam() {
    addOrUpdate = "update";
    resetUpdatePanel();
    populateUpdatePanelWithSelectedItem();
    showUpdatePanel();
}
function resetUpdatePanel() {
    document.querySelector("#inputID").value = 0;
    document.querySelector("#inputTeamName").value = "";
    document.querySelector("#inputEarnings").value = 0;
}
 

function clearAddUpdate() {
    // obtain todays date for releaseDate field as placeholder.
    document.querySelector("#inputTeamName").value = "";
}

function showUpdatePanel() {
    document.getElementById("AddUpdatePanel").classList.remove("hidden");
}

function hideUpdatePanel() {
    document.getElementById("AddUpdatePanel").classList.add("hidden");
}
function populateUpdatePanelWithSelectedItem() {
    var tds = document.querySelector(".highlighted").querySelectorAll("td");
    document.querySelector("#inputID").value = tds[0].innerHTML;
    document.querySelector("#inputTeamName").value = tds[1].innerHTML;
    if (tds[2].innerHTML !== "null") {
        document.querySelector("#inputEarnings").value = tds[2].innerHTML; 
    }
    else{
        document.querySelector("#inputEarnings").value = 0;
    }
}
function getAll() {
    //hide addUpdate incase it is opened
    hideUpdatePanel();

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
                resetUpdatePanel();
                hideUpdatePanel();
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    
    
    document.querySelector("#btnUpdate").setAttribute("disabled", "disabled");
    document.querySelector("#btnDelete").setAttribute("disabled", "disabled");
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
        html += "</tr>";
    }
    theTable.innerHTML = html;
}
