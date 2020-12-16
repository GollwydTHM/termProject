var addOrUpdate;

window.onload = function () {
    // btn event handlers

    document.querySelector("#btnGet").addEventListener("click", getAll);
    document.querySelector("#btnAdd").addEventListener("click", addPlayer);
    document.querySelector("#btnUpdate").addEventListener("click", updatePlayer);
    document.querySelector("#btnDelete").addEventListener("click", deletePlayer);
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

    let playerID = Number(document.querySelector("#inputID").value);
    let teamID = Number(document.querySelector("#inputTeamID").value);
    let firstName = document.querySelector("#inputFirstName").value;
    let lastName = document.querySelector("#inputLastName").value;
    let hometown = document.querySelector("#inputHometown").value;
    let provinceCode = document.querySelector("#inputProvinceCode").value;


    //validation successful, create team object
    let obj = {
        "playerID": playerID,
        "teamID": teamID,
        "firstName": firstName,
        "lastName": lastName,
        "hometown": hometown,
        "provinceCode": provinceCode
    };


    //determine the directory for AJAX call
    let url = "../playerService/players/" + playerID;
    //determine which method do we use for AJAX call?
    let method = (addOrUpdate === "add") ? "POST" : "PUT";

    //AJAX
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            console.log(resp);
            if (resp.search("ERROR") >= 0 || resp != "1") {

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



function deletePlayer() {
    var playerID = document.querySelector(".highlighted").querySelector("td").innerHTML;
    console.log(playerID);



    //AJAX
    let url = "../playerService/players/" + playerID;
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            console.log(resp);
            if (resp.search("ERROR") >= 0 || resp != "1") {
                alert("Player could not be deleted.");
            } else {
                alert("The player has been DELETED from the database.");
                getAll();
            }
        }
    };
    xmlhttp.open("DELETE", url, true);
    xmlhttp.send();
}
function addPlayer() {
    // Show panel, panel handler takes care of the rest
    addOrUpdate = "add";
    resetUpdatePanel();
    showUpdatePanel();
}

function updatePlayer() {
    addOrUpdate = "update";
    resetUpdatePanel();
    populateUpdatePanelWithSelectedItem();
    showUpdatePanel();
}
function resetUpdatePanel() {
    document.querySelector("#inputID").value = 0;
    document.querySelector("#inputTeamID").value = 0;
    document.querySelector("#inputFirstName").value = "";
    document.querySelector("#inputLastName").value = "";
    document.querySelector("#inputHometown").value = "";
    document.querySelector("#inputProvinceCode").value = "";
}


function clearAddUpdate() {
    // obtain todays date for releaseDate field as placeholder.
    document.querySelector("#inputID").value = 0;
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
    document.querySelector("#inputTeamID").value = tds[1].innerHTML;
    document.querySelector("#inputFirstName").value = tds[2].innerHTML;
    document.querySelector("#inputLastName").value = tds[3].innerHTML;
    document.querySelector("#inputHometown").value = tds[4].innerHTML;
    document.querySelector("#inputProvinceCode").value = tds[5].innerHTML;

}
function getAll() {
    //hide addUpdate incase it is opened
    hideUpdatePanel();

    //AJAX
    let url = "../playerService/players";
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
        html += "<td>" + record.playerID + "</td>";
        html += "<td>" + record.firstName + "</td>";
        html += "<td>" + record.lastName + "</td>";
        html += "<td>" + record.hometown + "</td>";
        html += "<td>" + record.provinceCode + "</td>";
        html += "</tr>";
    }
    theTable.innerHTML = html;
}