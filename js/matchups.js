var addOrUpdate;

window.onload = function () {
    getFifty();
    getForTree();
    document.querySelector("#btnView").addEventListener("click", getFifty());
};

function getFifty() {
    //hide addUpdate incase it is opened
    //hideAddUpdate();

    //AJAX
    let url = "../matchupService/matchup/qualTournament";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let response = xmlhttp.responseText;
            //console.log(response);
            if (response.search("ERROR") >= 0) {
                alert("Whoops!");
            } else {
                buildQualContainer(xmlhttp.responseText);
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function buildQualContainer(text) {
    let temp = JSON.parse(text);
    let list = document.querySelector("#qualRankings");
    let items = list.querySelectorAll("li");
    //console.log("--->" + temp.length);
    for (let i = 0; i < temp.length; i++) {
        let record = temp[i];
        items[i].innerHTML = record.teamName;
    }
}

function getForTree() {
    //AJAX
    let url = "../matchupService/matchup/matchTree";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let response = xmlhttp.responseText;
            if (response.search("ERROR") >= 0) {
                alert("Whoops!");
            } else {
                console.log(response);
                fillTree(xmlhttp.responseText);
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function fillTree(inTeams) {
    
    let fakeTeams = [];
    
    let tbodies = document.querySelectorAll("tbody");
    let seed1 = tbodies[0];
    let seed2 = tbodies[0];
    let seed3 = tbodies[0];
    let seed4 = tbodies[0];
    let final = tbodies[0];
    let rand4 = tbodies[0];
    let rand3 = tbodies[0];
    let rand2 = tbodies[0];
    let rand1 = tbodies[0];
    console.log(seed1);
}