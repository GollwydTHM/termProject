var addOrUpdate;

window.onload = function () {
    getAll();
    document.querySelector("#btnView").addEventListener("click", getAll());
};

function getAll() {
    //hide addUpdate incase it is opened
    //hideAddUpdate();

    //AJAX
    let url = "../matchupService/matchup/qual";
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let response = xmlhttp.responseText;
            console.log(response);
            if (response.search("ERROR") >= 0) {
                alert("Whoops!");
            } else {
                buildTable(xmlhttp.responseText);
            }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function buildTable(text) {
    let temp = JSON.parse(text);
    let list = document.querySelector("#qualRankings");
    let items = list.querySelectorAll("li");
    console.log("--->" + temp.length);
    for (let i = 0; i < temp.length; i++) {
        let record = temp[i];
        items[i].innerHTML = record.teamName;
    }
}